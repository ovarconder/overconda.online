/**
 * Checkout Routes
 *
 * POST /api/checkout/create-session
 */
const { Router } = require('express');
const checkoutController = require('../controllers/checkout.controller');
const router = Router();

router.post('/create-session', checkoutController.createSession);

module.exports = router;
