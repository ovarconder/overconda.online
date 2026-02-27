<?php

declare(strict_types=1);

namespace App\Licensing;

final class LicensingManager
{
    private string $envatoApiKey;

    public function __construct(?string $envatoApiKey = null)
    {
        $this->envatoApiKey = $envatoApiKey ?? (string) (env('ENVATO_API_KEY') ?? '');
    }

    /**
     * Validate Envato purchase code via Envato API.
     *
     * @param string $purchaseCode
     * @return array{
     *     status: 'success'|'error',
     *     message?: string,
     *     data?: array
     * }
     */
    public function validateEnvatoPurchase(string $purchaseCode): array
    {
        $purchaseCode = trim($purchaseCode);

        // Basic format validation (Envato purchase codes are UUID-like).
        if ($purchaseCode === '' ||
            !preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $purchaseCode)
        ) {
            return [
                'status' => 'error',
                'message' => 'Invalid purchase code format.',
            ];
        }

        if ($this->envatoApiKey === '') {
            return [
                'status' => 'error',
                'message' => 'Envato API key is not configured.',
            ];
        }

        $endpoint = 'https://api.envato.com/v3/market/author/sale?code=' . urlencode($purchaseCode);

        $ch = curl_init($endpoint);
        if ($ch === false) {
            return [
                'status' => 'error',
                'message' => 'Unable to initialize request.',
            ];
        }

        $headers = [
            'Authorization: Bearer ' . $this->envatoApiKey,
            'User-Agent: EnvatoValidationClient/1.0',
        ];

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $responseBody = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($responseBody === false) {
            return [
                'status' => 'error',
                'message' => 'Request failed: ' . ($curlError !== '' ? $curlError : 'Unknown cURL error'),
            ];
        }

        $decoded = json_decode($responseBody, true);

        if ($httpCode === 200 && is_array($decoded)) {
            // Map key fields we care about; structure may be extended as needed.
            $itemName = $decoded['item']['name'] ?? null;
            $buyer = $decoded['buyer'] ?? null;
            $supportedUntil = $decoded['supported_until'] ?? null;

            return [
                'status' => 'success',
                'data' => [
                    'item_name' => $itemName,
                    'buyer' => $buyer,
                    'supported_until' => $supportedUntil,
                    'raw' => $decoded,
                ],
            ];
        }

        // Non-200 or unexpected body → treat as error
        $errorMessage = 'Purchase code not found or invalid.';
        if (is_array($decoded) && isset($decoded['error'])) {
            $errorMessage = (string) $decoded['error'];
        }

        return [
            'status' => 'error',
            'message' => $errorMessage,
        ];
    }

    /**
     * Validate a license key.
     *
     * This is a placeholder implementation to be extended with real logic
     * such as calling Envato API or checking against a database.
     */
    public function validateKey(string $licenseKey): bool
    {
        $licenseKey = trim($licenseKey);

        if ($licenseKey === '') {
            return false;
        }

        // Basic placeholder rule: minimal length requirement.
        if (strlen($licenseKey) < 10) {
            return false;
        }

        // TODO: Replace with real validation (database or external API).
        return true;
    }
}

