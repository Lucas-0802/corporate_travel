<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'api/*/*'],
    'allowed_methods' => ['*'], 
    'allowed_origins' => ['http://localhost:5173'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];

