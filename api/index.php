<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

use App\Licensing\LicensingManager;

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');

// Basic routing based on path and method
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Normalize path to be relative to /api
$scriptName = dirname($_SERVER['SCRIPT_NAME'] ?? '') ?: '';
$basePath = rtrim($scriptName, '/');
$relativePath = '/' . ltrim(str_replace($basePath, '', (string) $path), '/');

if ($method === 'POST' && $relativePath === '/validate') {
    $input = json_decode(file_get_contents('php://input') ?: '[]', true);
    $licenseKey = $input['license_key'] ?? null;

    if (!is_string($licenseKey)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'license_key is required and must be a string.',
        ]);
        exit;
    }

    $manager = new LicensingManager();
    $isValid = $manager->validateKey($licenseKey);

    echo json_encode([
        'success' => true,
        'valid' => $isValid,
    ]);
    exit;
}

http_response_code(404);
echo json_encode([
    'success' => false,
    'error' => 'Not Found',
]);

