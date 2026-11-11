
<?php

/**
 * Migration: Create Users Table | បង្កើតតារាង Users
 *
 * Defines table schema and rollback SQL | កំណត់ទម្រង់ Schema និងបញ្ជា Rollback
 */
return [
    // Apply migration (up) | បញ្ជា SQL បង្កើតតារាង (Up)
    'up' => "
        CREATE TABLE IF NOT EXISTS users (
            -- Primary auto-incrementing ID | លេខសម្គាល់អត្តសញ្ញាណកើនឡើងស្វ័យប្រវត្ត
            id INT AUTO_INCREMENT PRIMARY KEY,
            -- Full name | ឈ្មោះពេញ
            name VARCHAR(255) NOT NULL,
            -- Unique email address | អ៊ីមែល (មិនជាន់គ្នា)
            email VARCHAR(255) NOT NULL UNIQUE,
            -- Hashed password | ពាក្យសម្ងាត់ Hash
            password VARCHAR(255) NOT NULL,
            -- Created timestamp | ពេលវេលាបង្កើត
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            -- Updated timestamp | ពេលវេលាកែប្រែចុងក្រោយ
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",

    // Rollback migration (down) | បញ្ជា SQL លុបតារាង (Down)
    'down' => "
        DROP TABLE IF EXISTS users;
    "
];