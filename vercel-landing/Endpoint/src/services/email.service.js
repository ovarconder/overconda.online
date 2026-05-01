/**
 * Email service — sends License Key emails via Resend.com
 *
 * @module services/email.service
 */
const RESEND_API = 'https://api.resend.com/emails';

async function sendLicenseEmail(to, key, type, expires) {
  const apiKey = process.env.RESEND_API_KEY;
  if (!apiKey || apiKey === 're_xxxxx') {
    console.warn('[Email] RESEND_API_KEY not set. Skipping email to', to);
    return { skipped: true };
  }

  const isLifetime = !expires || expires === 'lifetime' || expires === 'null';
  const expiryText = isLifetime ? 'Never expires (lifetime)' : `Expires: ${expires}`;

  const html = `
<html><body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
  <div style="background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%); border-radius: 12px; padding: 32px; text-align: center; color: white;">
    <h1 style="margin: 0 0 8px; font-size: 28px;">🎉 Welcome to 404 Slimmer!</h1>
    <p style="margin: 0; font-size: 16px; opacity: 0.9;">Your license is ready</p>
  </div>
  <div style="background: #f8f9fa; border-radius: 12px; padding: 24px; margin-top: 20px;">
    <h2 style="color: #1a1a2e; font-size: 18px; margin: 0 0 16px;">Your License Key</h2>
    <div style="background: white; border: 2px dashed #4facfe; border-radius: 8px; padding: 16px; text-align: center; font-size: 20px; font-family: 'Courier New', monospace; letter-spacing: 2px; color: #1a1a2e; user-select: all;">${key}</div>
    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
      <tr><td style="padding: 8px 0; color: #666; font-size: 14px;">License Type</td><td style="padding: 8px 0; text-align: right; font-weight: 600; font-size: 14px;">${type}</td></tr>
      <tr><td style="padding: 8px 0; color: #666; font-size: 14px;">Expiry</td><td style="padding: 8px 0; text-align: right; font-weight: 600; font-size: 14px;">${expiryText}</td></tr>
      <tr><td style="padding: 8px 0; color: #666; font-size: 14px;">Product</td><td style="padding: 8px 0; text-align: right; font-weight: 600; font-size: 14px;">404 Slimmer</td></tr>
    </table>
  </div>
  <div style="background: #fff3cd; border-radius: 8px; padding: 16px; margin-top: 16px; border-left: 4px solid #ffc107;">
    <p style="margin: 0; font-size: 13px; color: #856404;"><strong>📋 How to activate:</strong><br>1. WordPress Dashboard → 404 Slimmer<br>2. Click License tab → paste your key<br>3. Click Activate → PRO unlocked instantly!</p>
  </div>
  <p style="text-align: center; color: #999; font-size: 12px; margin-top: 24px;">Need help? <a href="https://www.overconda.space/projects/404-slimmer/support" style="color: #4facfe;">Contact Support</a></p>
</body></html>`;

  try {
    const response = await fetch(RESEND_API, {
      method: 'POST',
      headers: { 'Authorization': `Bearer ${apiKey}`, 'Content-Type': 'application/json' },
      body: JSON.stringify({ from: process.env.EMAIL_FROM || '404 Slimmer <noreply@overconda.space>', to, subject: `Your 404 Slimmer License Key (${type})`, html }),
    });
    if (!response.ok) {
      const errBody = await response.text();
      console.error('[Email] Resend error:', response.status);
      return { success: false };
    }
    const data = await response.json();
    console.log('[Email] Sent license to', to, 'id:', data.id);
    return { success: true, id: data.id };
  } catch (err) {
    console.error('[Email] Failed:', err.message);
    return { success: false };
  }
}

module.exports = { sendLicenseEmail };
