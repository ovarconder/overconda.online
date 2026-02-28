<?php

declare(strict_types=1);

namespace App\Licensing;

final class LicensingManager
{
    private string $envatoApiKey;
    private ?LicenseRepository $repository;

    public function __construct(?string $envatoApiKey = null, ?LicenseRepository $repository = null)
    {
        $this->envatoApiKey = $envatoApiKey ?? (string) (env('ENVATO_API_KEY') ?? '');
        $this->repository = $repository;
    }

    /**
     * Validate license via Envato API and optionally persist to DB.
     */
    public function validate(string $licenseKey, ?string $siteUrl = null): array
    {
        $licenseKey = trim($licenseKey);
        $siteUrl = $siteUrl ? trim($siteUrl) : null;

        if ($licenseKey === '') {
            return $this->errorResponse('license_key is required.');
        }

        if ($this->envatoApiKey === '') {
            return $this->errorResponse('Envato API key is not configured.');
        }

        $result = $this->validateEnvatoPurchase($licenseKey);

        if ($this->repository) {
            $this->repository->logValidation(
                $licenseKey,
                $siteUrl,
                $result['status'] === 'success',
                $result['http_code'] ?? null,
                $result['status'] === 'error' ? ($result['message'] ?? null) : null
            );
        }

        if ($result['status'] === 'success' && $this->repository) {
            $supportedUntil = $result['data']['supported_until'] ?? null;
            $status = $this->resolveStatus($supportedUntil);
            $dateOnly = $supportedUntil ? substr((string) $supportedUntil, 0, 10) : null;
            $this->repository->upsert([
                'license_key' => $licenseKey,
                'envato_item_id' => $result['data']['item_id'] ?? null,
                'envato_item_name' => $result['data']['item_name'] ?? null,
                'envato_buyer' => $result['data']['buyer'] ?? null,
                'supported_until' => $dateOnly,
                'site_url' => $siteUrl,
                'status' => $status,
                'raw_response' => $result['data']['raw'] ?? null,
            ]);
        }

        return [
            'success' => $result['status'] === 'success',
            'valid' => $result['status'] === 'success',
            'data' => $result['data'] ?? null,
            'error' => $result['status'] === 'error' ? ($result['message'] ?? 'Validation failed') : null,
        ];
    }

    private function resolveStatus(?string $supportedUntil): string
    {
        if ($supportedUntil === null) {
            return 'valid';
        }
        $date = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:sP', $supportedUntil)
            ?: \DateTimeImmutable::createFromFormat('Y-m-d', $supportedUntil);
        if ($date && $date < new \DateTimeImmutable()) {
            return 'expired';
        }
        return 'valid';
    }

    private function errorResponse(string $message): array
    {
        return ['success' => false, 'valid' => false, 'error' => $message];
    }

    /**
     * Validate Envato purchase code via Envato API.
     */
    public function validateEnvatoPurchase(string $purchaseCode): array
    {
        $purchaseCode = trim($purchaseCode);

        if ($purchaseCode === '' ||
            !preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $purchaseCode)
        ) {
            return [
                'status' => 'error',
                'message' => 'Invalid purchase code format.',
            ];
        }

        $endpoint = 'https://api.envato.com/v3/market/author/sale?code=' . urlencode($purchaseCode);

        $ch = curl_init($endpoint);
        if ($ch === false) {
            return ['status' => 'error', 'message' => 'Unable to initialize request.'];
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->envatoApiKey,
                'User-Agent: Overconda-Licensing/1.0',
            ],
        ]);

        $responseBody = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($responseBody === false) {
            return ['status' => 'error', 'message' => 'Request failed: ' . ($curlError ?: 'Unknown error')];
        }

        $decoded = json_decode($responseBody, true);

        if ($httpCode === 200 && is_array($decoded)) {
            $item = $decoded['item'] ?? [];
            $buyer = $decoded['buyer'] ?? null;
            $supportedUntil = $decoded['supported_until'] ?? null;

            return [
                'status' => 'success',
                'http_code' => $httpCode,
                'data' => [
                    'item_id' => $item['id'] ?? null,
                    'item_name' => $item['name'] ?? null,
                    'buyer' => $buyer,
                    'supported_until' => $supportedUntil,
                    'raw' => $decoded,
                ],
            ];
        }

        $errorMessage = 'Purchase code not found or invalid.';
        if (is_array($decoded) && isset($decoded['error'])) {
            $errorMessage = (string) $decoded['error'];
        }

        return [
            'status' => 'error',
            'http_code' => $httpCode,
            'message' => $errorMessage,
        ];
    }
}
