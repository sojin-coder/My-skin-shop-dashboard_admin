<?php

/**
 * Database Manager Class | ថ្នាក់គ្រប់គ្រងមូលដ្ឋានទិន្នន័យ
 *
 * Implements a Singleton PDO connection and parses .env file.
 * អនុវត្តតាមទម្រង់ Singleton Pattern សម្រាប់ PDO Connection និងផ្ទុកតម្លៃពីឯកសារ .env។
 */
class Database
{
    // Cached PDO connection instance (Singleton) | រក្សាទុក Instance នៃការភ្ជាប់ PDO
    private static ?PDO $connection = null;

    /**
     * Get or initialize PDO connection | ភ្ជាប់ ឬទាញយក PDO Connection
     *
     * @return PDO
     */
    public static function connection(): PDO
    {
        // Only initialize connection if not yet created | បង្កើតការភ្ជាប់ថ្មីតែម្ដងគត់បើមិនទាន់មាន
        if (self::$connection === null) {
            // Load environment variables from .env | ផ្ទុក Environment Variables ពីឯកសារ .env
            self::loadEnv();

            // Load database config array | ផ្ទុកការកំណត់ Database ពី config/database.php
            $config = require __DIR__ . '/../../config/database.php';

            // Construct PDO DSN string | បង្កើតទម្រង់ PDO DSN
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            // PDO options | ការកំណត់លក្ខណៈសម្បត្តិរបស់ PDO
            $options = [
                // Throw exceptions on SQL errors | បោះកំហុសជា PDOException ពេលមានបញ្ហា SQL
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Fetch associative arrays by default | ទាញយកទិន្នន័យជា Associative Array
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Use native prepared statements | ប្រើប្រាស់ Prepared Statements ពិតប្រាកដ
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                // Instantiate PDO connection | បង្កើតការភ្ជាប់ PDO ទៅកាន់ Database
                self::$connection = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $options
                );
            } catch (PDOException $e) {
                // Handle connection failure | បង្ហាញសារកំហុសបើមិនអាចភ្ជាប់បាន
                die('Database Connection Failed: ' . $e->getMessage());
            }
        }

        // Return active connection | ផ្ដល់ត្រឡប់នូវ PDO Connection ដែលកំពុងដំណើរការ
        return self::$connection;
    }

    /**
     * Parse .env file into environment variables | អាន និងទាញយកតម្លៃពី .env ចូល Environment Variables
     */
    private static function loadEnv(): void
    {
        // Path to .env file in root | ផ្លូវនៃឯកសារ .env នៅ root
        $envFile = __DIR__. '/../../.env';

        // Skip if .env does not exist | រំលងបើគ្មានឯកសារ .env
        if (!file_exists($envFile)) {
            return;
        }

        // Read lines ignoring newlines and empty lines | អានរាល់បន្ទាត់ក្នុង .env
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Trim whitespace | លុបចន្លោះទទេមុខ-ក្រោយ
            $line = trim($line);

            // Skip empty lines and comment lines | រំលងបន្ទាត់ទទេ ឬ Comment (#)
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            // Parse key=value pairs | បំបែកទម្រង់ key=value
            if (str_contains($line, '=')) {
                // Split at first '=' | បំបែក key និង value ត្រង់សញ្ញា '=' ដំបូង
                [$key, $value] = explode('=', $line, 2);

                // Trim whitespace and quotes | សម្អាតចន្លោះទទេ និងសម្រង់ "" ឬ ''
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");

                // Set in $_ENV and putenv if not set | កំណត់ចូល $_ENV និង putenv
                if (!array_key_exists($key, $_ENV)) {
                    $_ENV[$key] = $value;
                    putenv("$key=$value");
                }
            }
        }
    }
}