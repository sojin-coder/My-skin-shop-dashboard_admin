<?php

/**
 * Database Connection Configuration | ការកំណត់ការភ្ជាប់មូលដ្ឋានទិន្នន័យ
 *
 * Reads values from environment variables (.env) with fallbacks.
 * អានតម្លៃពី Environment Variables (.env) ជាមួយតម្លៃលំនាំដើមសម្រាប់ Local Development។
 */
return [
    // Database host (default: 127.0.0.1) | ម៉ាស៊ីនបម្រើ Database (លំនាំដើម: 127.0.0.1)
    'host' => getenv('DB_HOST'),

    // Database port (default: 3306) | ច្រក Port របស់ MySQL (លំនាំដើម: 3306)
    'port' => getenv('DB_PORT'),

    // Database schema name | ឈ្មោះ Database ដែលត្រូវភ្ជាប់
    'database' => getenv('DB_DATABASE'),

    // Database username | ឈ្មោះអ្នកប្រើប្រាស់ Database
    'username' => getenv('DB_USERNAME'),

    // Database password | ពាក្យសម្ងាត់ Database
    'password' => getenv('DB_PASSWORD'),

    // Character encoding (UTF-8) | ប្រព័ន្ធកូដតួអក្សរ (គាំទ្រអក្សរខ្មែរ និង Emojis)
    'charset' => 'utf8mb4',
];
