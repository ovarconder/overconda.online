/**
 * License Key Generator
 * Generates keys in format: 404S-XXXX-XXXX-XXXX
 *
 * @module services/keygen.service
 */
const crypto = require('crypto');

function generateLicenseKey() {
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  const random = crypto.randomBytes(12);
  let segments = [];
  for (let i = 0; i < 3; i++) {
    let segment = '';
    for (let j = 0; j < 4; j++) {
      segment += chars[random[i * 4 + j] % chars.length];
    }
    segments.push(segment);
  }
  return `404S-${segments.join('-')}`;
}

module.exports = { generateLicenseKey };
