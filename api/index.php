<?php

declare(strict_types=1);

// Support both legacy /api/validate and plugin /api/v1/activate
require __DIR__ . '/../vendor/autoload.php';

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

// ----- /api/v1/activate (plugin domain activation) -----
if ($method === 'POST' && (strpos($route, '/v1/activate') !== false || $route === '/activate')) {
    $raw = file_get_contents('php://input') ?: '{}';
    $input = json_decode($raw, true);
    if (!is_array($input)) {
        $input = $_POST;
    }
    $license_key   = trim((string) ($input['license_key'] ?? ''));
    $client_domain = trim((string) ($input['domain'] ?? ''));
    $product_id    = trim((string) ($input['product_id'] ?? '404-slimmer'));

    if ($license_key === '') {
        echo json_encode(['success' => false, 'message' => 'Missing License Key']);
        exit;
    }

    try {
        $pdo = \App\Database\Database::getConnection();
    } catch (\Throwable $e) {
        error_log('[OVCD API] DB connection failed: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Service temporarily unavailable']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('SELECT * FROM ovcd_licenses WHERE license_key = ? AND product_id = ?');
        $stmt->execute([$license_key, $product_id]);
        $license = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {
        error_log('[OVCD API] Query failed: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Invalid License Key']);
        exit;
    }

    if ($license) {
        if (!empty($license['domain_registered'])) {
            if ($license['domain_registered'] === $client_domain) {
                echo json_encode([
                    'success' => true,
                    'license_type' => $license['license_type'],
                    'activated_at' => $license['activated_at'],
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Key already used on: ' . $license['domain_registered']]);
            }
        } else {
            $activated_date = date('Y-m-d H:i:s');
            $update = $pdo->prepare('UPDATE ovcd_licenses SET domain_registered = ?, activated_at = ?, updated_at = NOW() WHERE id = ?');
            $update->execute([$client_domain, $activated_date, $license['id']]);

            echo json_encode([
                'success' => true,
                'license_type' => $license['license_type'],
                'activated_at' => $activated_date,
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid License Key']);
    }
    exit;
}

// ----- /api/health -----
if ($method === 'GET' && ($route === '/health' || $route === '/api/health' || strpos($route, 'health') !== false)) {
    echo json_encode(['status' => 'ok', 'service' => 'overconda-licensing']);
    exit;
}

// ----- /api/validate (Envato validation) -----
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
    $repository = $useDb ? new \App\Licensing\LicenseRepository() : null;
    $manager = new \App\Licensing\LicensingManager(null, $repository);
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
