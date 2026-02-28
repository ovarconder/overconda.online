<?php

declare(strict_types=1);

namespace App\Licensing;

use App\Database\Database;
use PDO;

final class LicenseRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    public function upsert(array $data): void
    {
        $sql = <<<SQL
            INSERT INTO licenses (
                license_key, envato_item_id, envato_item_name, envato_buyer,
                supported_until, site_url, status, last_validated_at, raw_response
            ) VALUES (
                :license_key, :envato_item_id, :envato_item_name, :envato_buyer,
                :supported_until, :site_url, :status, :last_validated_at, :raw_response
            )
            ON DUPLICATE KEY UPDATE
                envato_item_id = VALUES(envato_item_id),
                envato_item_name = VALUES(envato_item_name),
                envato_buyer = VALUES(envato_buyer),
                supported_until = VALUES(supported_until),
                site_url = COALESCE(VALUES(site_url), site_url),
                status = VALUES(status),
                last_validated_at = VALUES(last_validated_at),
                raw_response = VALUES(raw_response),
                updated_at = CURRENT_TIMESTAMP
        SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'license_key' => $data['license_key'],
            'envato_item_id' => $data['envato_item_id'] ?? null,
            'envato_item_name' => $data['envato_item_name'] ?? null,
            'envato_buyer' => $data['envato_buyer'] ?? null,
            'supported_until' => $data['supported_until'] ?? null,
            'site_url' => $data['site_url'] ?? null,
            'status' => $data['status'] ?? 'valid',
            'last_validated_at' => $data['last_validated_at'] ?? date('Y-m-d H:i:s'),
            'raw_response' => isset($data['raw_response']) ? json_encode($data['raw_response']) : null,
        ]);
    }

    public function logValidation(string $licenseKey, ?string $siteUrl, bool $isValid, ?int $httpCode, ?string $errorMessage): void
    {
        try {
            $sql = 'INSERT INTO license_validation_logs (license_key, site_url, is_valid, http_code, error_message) VALUES (:license_key, :site_url, :is_valid, :http_code, :error_message)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'license_key' => $licenseKey,
                'site_url' => $siteUrl,
                'is_valid' => $isValid ? 1 : 0,
                'http_code' => $httpCode,
                'error_message' => $errorMessage,
            ]);
        } catch (\Throwable $e) {
            // Table may not exist; ignore
        }
    }

    public function findByKey(string $licenseKey): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM licenses WHERE license_key = :key LIMIT 1');
        $stmt->execute(['key' => $licenseKey]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
