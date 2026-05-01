/**
 * Checkout Controller — Stripe Checkout Session
 *
 * Founder's Deal Pricing (One-time / Lifetime):
 *   Personal  (1 site)    → $19
 *   Pro       (5 sites)   → $49
 *   Agency    (20 sites)  → $99
 *
 * @module controllers/checkout.controller
 */
const stripe = require('../config/stripe');

const PRODUCT_ID = '404-slimmer';

/**
 * Map plan → Stripe Price ID (replace with real IDs from Stripe Dashboard)
 * Create these prices in Stripe Dashboard first:
 *   - 404 Slimmer Personal (1 site, one-time $19)
 *   - 404 Slimmer Pro (5 sites, one-time $49)
 *   - 404 Slimmer Agency (20 sites, one-time $99)
 */
const PRICE_MAP = {
  personal: process.env.STRIPE_PRICE_PERSONAL || 'price_live_personal_xxxxx',
  pro:      process.env.STRIPE_PRICE_PRO      || 'price_live_pro_xxxxx',
  agency:   process.env.STRIPE_PRICE_AGENCY   || 'price_live_agency_xxxxx',
};

const PLAN_MAP = {
  personal: { type: 'Personal',  maxDomains: 1,  expires: null },     // lifetime
  pro:      { type: 'Pro',       maxDomains: 5,  expires: null },     // lifetime
  agency:   { type: 'Agency',    maxDomains: 20, expires: null },     // lifetime
};

/**
 * POST /api/checkout/create-session
 * Body: { plan: 'personal' | 'pro' | 'agency' }
 * Returns: { success: bool, url: string, session_id: string }
 */
async function createSession(req, res) {
  try {
    const { plan, email } = req.body;
    const planKey = (plan || '').toLowerCase();

    if (!PLAN_MAP[planKey]) {
      return res.status(400).json({
        success: false,
        message: 'Invalid plan. Valid: personal, pro, agency',
      });
    }

    const priceId = PRICE_MAP[planKey];
    const { type, maxDomains } = PLAN_MAP[planKey];
    const baseUrl = process.env.STORE_BASE_URL || `${req.protocol}://${req.get('host')}`;

    const session = await stripe.checkout.sessions.create({
      mode: 'payment',
      line_items: [{ price: priceId, quantity: 1 }],
      metadata: {
        product_id: PRODUCT_ID,
        license_type: type,
        max_domains: String(maxDomains),
        plan: planKey,
      },
      success_url: `${baseUrl}/success?session_id={CHECKOUT_SESSION_ID}`,
      cancel_url: `${baseUrl}/projects/404-slimmer#pricing`,
      customer_email: email || undefined,
    });

    console.log('[Checkout] Session created:', session.id, 'plan:', planKey);
    return res.json({ success: true, url: session.url, session_id: session.id });
  } catch (err) {
    console.error('[Checkout] Error:', err.message);
    return res.status(500).json({ success: false, message: 'Failed to create checkout session.' });
  }
}

module.exports = { createSession };
