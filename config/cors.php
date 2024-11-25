<?php
return [
    'paths' => ['/*', ''], // Các route áp dụng CORS

    'allowed_methods' => ['*'], // Cho phép tất cả HTTP methods

    'allowed_origins' => ['*'], // Cho phép tất cả domain, hoặc chỉ định ['https://example.com']

    'allowed_origins_patterns' => [], // Các pattern domain cụ thể

    'allowed_headers' => ['*'], // Cho phép tất cả header

    'exposed_headers' => [], // Header lộ ra trong response

    'max_age' => 0, // Thời gian cache preflight request

    'supports_credentials' => false, // Có gửi cookie hay không
];
