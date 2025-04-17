    <?php
    // En config/cors.php
    return [
        'paths' => ['api/*', 'sanctum/csrf-cookie'],
        'allowed_methods' => ['*'],
        'allowed_origins' => ['*'], // En producción, deberías limitar esto
        'allowed_origins_patterns' => [],
        'allowed_headers' => ['*'],
        'exposed_headers' => [],
        'max_age' => 0,
        'supports_credentials' => false,
    ];
