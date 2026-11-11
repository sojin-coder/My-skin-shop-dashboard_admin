<?php

/**
 * Script សម្រាប់ដំណើរការ Database Migration តាម CLI
 * Database Migration CLI Script | Script ដំណើរការ Database Migration តាម CLI
 *
 * ស្វែងរកឯកសារ migration ទាំងអស់ក្នុងថត database/migrations ហើយដំណើរការ
 * បញ្ជា SQL ក្នុងផ្នែក 'up' សម្រាប់ migration នីមួយៗ។
 * Runs 'up' SQL migrations from database/migrations/*.php.
 * ស្វែងរកឯកសារ migration ក្នុង database/migrations ហើយដំណើរការ SQL 'up'។
 *
 * របៀបប្រើប្រាស់៖ php database/migrate.php
 * Usage / របៀបប្រើ៖ php database/migrate.php
 */

// ផ្ទុកថ្នាក់ Database មូលដ្ឋាន
// Load core Database class | ផ្ទុកថ្នាក់ Database មូលដ្ឋាន
// require_once _DIR_ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Database.php';

try {
    // បង្ហាញសារជូនដំណឹងនៅលើ Console ថាការ Migrate កំពុងចាប់ផ្ដើម
    // Notify start of migrations | បង្ហាញសារជូនដំណឹងថាការ Migrate ចាប់ផ្ដើម
    echo "Running migrations...\n";

    // បង្កើតការភ្ជាប់ PDO ដោយប្រើការកំណត់ពី .env / config
    // Establish PDO connection | បង្កើតការភ្ជាប់ PDO ដោយប្រើការកំណត់ពី .env / config
    $db = Database::connection();

    // ស្វែងរកឯកសារ PHP Migration ទាំងអស់ក្នុងថត database/migrations
    // Find all migration files | ស្វែងរកឯកសារ Migration ទាំងអស់
    $migrationFiles = glob(__DIR__ . '/migrations/*.php');

    // តម្រៀបឯកសារតាមលំដាប់អក្ខរក្រម ដើម្បីធានាថា Migration ដំណើរការតាមលំដាប់លំដោយត្រឹមត្រូវ
    // Sort alphabetically for order | តម្រៀបឯកសារតាមលំដាប់អក្ខរក្រម
    sort($migrationFiles);

    // ដំណើរការម្ដងមួយឯកសារៗ
    // Run each migration | ដំណើរការម្ដងមួយឯកសារៗ
    foreach ($migrationFiles as $file) {
        // យកឈ្មោះឯកសារ (ឧ. 001_create_users_table.php)
        // Get filename | យកឈ្មោះឯកសារ (ឧ. 001_create_users_table.php)
        $migrationName = basename($file);
        echo "Migrating: $migrationName\n";

        // ផ្ទុកឯកសារ migration ដែលផ្ដល់ត្រឡប់មកវិញនូវ array ដែលមាន key 'up' និង 'down'
        // Load migration definition | ផ្ទុកឯកសារ migration
        $migration = require $file;

        // ប្រសិនបើមានបញ្ជា SQL 'up' ត្រូវដំណើរការវាលើ Database
        // Execute 'up' SQL statement | ប្រសិនបើមាន SQL 'up' ត្រូវដំណើរការលើ Database
        if (isset($migration['up'])) {
            $db->exec($migration['up']);
            echo "Migrated:  $migrationName\n";
        }
    }

    // បង្ហាញសារជោគជ័យពេលដំណើរការចប់សព្វគ្រប់
    // Output completion message | បង្ហាញសារជោគជ័យពេលដំណើរការចប់សព្វគ្រប់
    echo "All migrations completed successfully.\n";
} catch (Exception $e) {
    // ចាប់យក និងបង្ហាញសារកំហុសបើមានបញ្ហា
    // Catch and print error | ចាប់យក និងបង្ហាញសារកំហុសបើមានបញ្ហា
    echo "Migration failed: " . $e->getMessage() . "\n";
    // បញ្ឈប់ script ជាមួយ error exit code 1
    // Exit with status code 1 | បញ្ឈប់ script ជាមួយ error exit code 1
    exit(1);
}