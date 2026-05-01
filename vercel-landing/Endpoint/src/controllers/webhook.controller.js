/**
 * Webhook Controller — Stripe events
 *
 * On checkout.session.completed:
 *   1. Generate license key
 *   2. INSERT INTO licenses
 *   3. Send email to customer
 *
 * @module controllers/webhook.controller
 */
const stripe = require('../config/stripe');
const { getPool } = require('../config/database');
const { generateLicenseKey } = require('../services/keygen.service');
const { sendLicenseEmail } = require('../services/email.service');

async function handleWebhook(req, res) {
  const sig = req.headers['stripe-signature'];
  const webhookSecret = process.env.STRIPE_WEBHOOK_SECRET;

  if (!webhookSecret || webhookSecret === 'whsec_xxxxx') {
    console.error('[Webhook] STRIPE_WEBHOOK_SECRET not configured!');
    return res.status(500).json({ received: false, error: 'Webhook secret not configured' });
  }

  let event;
  try {
    event = stripe.webhooks.constructEvent(req.body, sig, webhookSecret);
  } catch (err) {
    console.error('[Webhook] Signature verification failed:', err.message);
    return res.status(400).json({ received: false, error: `Signature failed: ${err.message}` });
  }

  console.log('[Webhook] Event:', event.type, 'id:', event.id);

  if (event.type === 'checkout.session.completed' || event.type === 'checkout.session.async_payment_succeeded') {
    await handleCheckoutCompleted(event.data.object);
  }

  return res.json({ received: true });
}

async function handleCheckoutCompleted(session) {
  const { metadata, customer_details, id: sessionId } = session;

  if (!metadata || metadata.product_id !== '404-slimmer') {
    console.log('[Webhook] Session', sessionId, 'not for 404-slimmer, skipping');
    return;
  }

  const licenseType = metadata.license_type || 'Personal';
  const maxDomains = parseInt(metadata.max_domains, 10) || 1;
  const customerEmail = customer_details?.email;

  // Founder's Deal = lifetime (NULL expires_at)
  const expiresAt = null;

  // Generate unique key (retry on collision)
  let licenseKey;
  let inserted = false;
  const pool = getPool();
  let attempts = 0;

  while (!inserted && attempts < 5) {
    attempts++;
    licenseKey = generateLicenseKey();
    try {
      await pool.execute(
        `INSERT INTO licenses (license_key, product_id, license_type, max_domains, status, expires_at)
         VALUES (?, ?, ?, ?, 'active', ?)`,
        [licenseKey, '404-slimmer', licenseType, maxDomains, expiresAt]
      );
      inserted = true;
    } catch (err) {
      if (err.code === 'ER_DUP_ENTRY') {
        console.log('[Webhook] Key collision, retry', attempts);
        continue;
      }
      console.error('[Webhook] DB insert failed:', err.message);
      return;
    }
  }

  if (!inserted) {
    console.error('[Webhook] Failed to generate unique key after', attempts, 'attempts');
    return;
  }

  console.log('[Webhook] License created:', licenseKey, 'type:', licenseType, 'for', customerEmail);

  if (customerEmail) {
    sendLicenseEmail(customerEmail, licenseKey, licenseType, expiresAt)
      .then(r => { if (r.success) console.log('[Webhook] Email sent to', customerEmail); })
      .catch(err => console.error('[Webhook] Email error:', err.message));
  }
}

module.exports = { handleWebhook };
