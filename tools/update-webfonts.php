<?php

declare(strict_types=1);

/**
 * Updates the static Google Fonts catalog used by the Customizer.
 *
 * Usage:
 *   GOOGLE_FONTS_API_KEY="..." php tools/update-webfonts.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$apiKey = getenv('GOOGLE_FONTS_API_KEY');
if ($apiKey === false || trim($apiKey) === '') {
    fwrite(STDERR, "Set GOOGLE_FONTS_API_KEY before running this script.\n");
    exit(1);
}

$endpoint = 'https://www.googleapis.com/webfonts/v1/webfonts?' . http_build_query(
    array(
        'sort' => 'alpha',
        'key'  => trim($apiKey),
    ),
    '',
    '&',
    PHP_QUERY_RFC3986
);

/**
 * Downloads the API response without adding a runtime dependency to the theme.
 */
function azbalac_download_webfonts(string $url): string
{
    if (function_exists('curl_init')) {
        $curl = curl_init($url);
        if ($curl === false) {
            throw new RuntimeException('Could not initialize cURL.');
        }

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT        => 60,
                CURLOPT_USERAGENT      => 'Azbalac-One-Webfonts-Updater/1.0',
            )
        );

        $response = curl_exec($curl);
        $status   = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $error    = curl_error($curl);
        curl_close($curl);

        if (!is_string($response) || $status < 200 || $status >= 300) {
            throw new RuntimeException(
                sprintf('Google Fonts API request failed (HTTP %d): %s', $status, $error)
            );
        }

        return $response;
    }

    if (!filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN)) {
        throw new RuntimeException('Neither cURL nor allow_url_fopen is available.');
    }

    $context = stream_context_create(
        array(
            'http' => array(
                'method'        => 'GET',
                'timeout'       => 60,
                'ignore_errors' => true,
                'header'        => "User-Agent: Azbalac-One-Webfonts-Updater/1.0\r\n",
            ),
        )
    );
    $response = file_get_contents($url, false, $context);

    if (!is_string($response)) {
        throw new RuntimeException('Google Fonts API request failed.');
    }

    $statusLine = $http_response_header[0] ?? '';
    if (!preg_match('/\s2\d{2}\s/', $statusLine)) {
        throw new RuntimeException('Google Fonts API request failed: ' . $statusLine);
    }

    return $response;
}

try {
    $response = azbalac_download_webfonts($endpoint);
    $decoded  = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

    if (!isset($decoded['items']) || !is_array($decoded['items'])) {
        throw new RuntimeException('The Google Fonts API response contains no font list.');
    }

    $items = array();
    foreach ($decoded['items'] as $item) {
        if (
            !is_array($item)
            || !isset($item['family'], $item['variants'])
            || !is_string($item['family'])
            || trim($item['family']) === ''
            || preg_match('/[\x00-\x1F\x7F]/', $item['family'])
            || !is_array($item['variants'])
        ) {
            continue;
        }

        $variants = array_values(
            array_unique(
                array_filter(
                    $item['variants'],
                    static function ($variant): bool {
                        return is_string($variant)
                            && preg_match('/^(?:regular|italic|[1-9]00(?:italic)?)$/', $variant) === 1;
                    }
                )
            )
        );

        if ($variants === array()) {
            continue;
        }

        $items[] = array(
            'family'   => trim($item['family']),
            'variants' => $variants,
        );
    }

    usort(
        $items,
        static fn(array $left, array $right): int => strcasecmp($left['family'], $right['family'])
    );

    if ($items === array()) {
        throw new RuntimeException('No valid Google Fonts entries were found.');
    }

    $catalog = array(
        'generated' => gmdate('Y-m-d'),
        'source'    => 'Google Fonts Developer API',
        'items'     => $items,
    );

    $output = "<?php\n\nreturn " . var_export($catalog, true) . ";\n";
    $target = dirname(__DIR__) . '/inc/customizer/webfonts.php';

    if (file_put_contents($target, $output, LOCK_EX) === false) {
        throw new RuntimeException('Could not write ' . $target);
    }

    fwrite(STDOUT, sprintf("Updated %s with %d font families.\n", $target, count($items)));
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . "\n");
    exit(1);
}
