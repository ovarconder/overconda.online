<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Licensing\LicenseRepository;
use App\Licensing\LicensingManager;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad();
}

function env(string $key, $default = null)
{
    return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
}

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
$route = '/' . trim(str_replace($basePath, '', (string) $path), '/');

if ($method === 'GET' && ($route === '/health' || $route === '/api/health')) {
    echo json_encode(['status' => 'ok', 'service' => 'overconda-licensing']);
    exit;
}

if ($method === 'POST' && ($route === '/validate' || $route === '/api/validate')) {
    $input = json_decode(file_get_contents('php://input') ?: '{}', true) ?: [];
    $licenseKey = $input['license_key'] ?? null;
    $siteUrl = $input['site_url'] ?? null;

    if (!is_string($licenseKey)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'valid' => false,
            'error' => 'license_key is required and must be a string.',
        ]);
        exit;
    }

    $useDb = !empty(env('DATABASE_DSN', ''));
    $repository = $useDb ? new LicenseRepository() : null;

    $manager = new LicensingManager(null, $repository);
    $result = $manager->validate($licenseKey, is_string($siteUrl) ? $siteUrl : null);

    echo json_encode([
        'success' => $result['success'],
        'valid' => $result['valid'],
        'data' => $result['data'] ?? null,
        'error' => $result['error'] ?? null,
    ]);
    exit;
}

http_response_code(404);
echo json_encode(['success' => false, 'error' => 'Not Found']);
