/**
 * Stripe SDK instance — single shared instance.
 *
 * @module config/stripe
 */
const Stripe = require('stripe');

const stripe = new Stripe(process.env.STRIPE_SECRET_KEY, {
  apiVersion: '2025-02-24.acacia',
  timeout: 30000,
});

module.exports = stripe;
