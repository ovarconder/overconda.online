/**
 * Webhook Routes
 *
 * POST /webhook/stripe — MUST use express.raw() before JSON parsing
 */
const { Router } = require('express');
const express = require('express');
const webhookController = require('../controllers/webhook.controller');
const router = Router();

router.post('/stripe', express.raw({ type: 'application/json' }), webhookController.handleWebhook);

module.exports = router;
