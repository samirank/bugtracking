<?php
/**
 * Bug Tracking System Setup Script
 * 
 * This script helps configure the system for first-time use
 */

// Check if .env file exists
$env_file = __DIR__ . DIRECTORY_SEPARATOR . '.env';
$example_env_file = __DIR__ . DIRECTORY_SEPARATOR . 'example.env';

if (file_exists($env_file)) {
    echo "Configuration file (.env) already exists.\n";
    echo "If you want to reconfigure, please delete the .env file and run this script again.\n";
    exit(0);
}

if (!file_exists($example_env_file)) {
    echo "Error: example.env file not found.\n";
    exit(1);
}

echo "=== Bug Tracking System Setup ===\n\n";

// Copy example.env to .env
if (copy($example_env_file, $env_file)) {
    echo "✓ Created .env file from example.env\n";
} else {
    echo "✗ Failed to create .env file\n";
    exit(1);
}

// Read the .env file
$env_content = file_get_contents($env_file);
$lines = explode("\n", $env_content);

echo "\nPlease configure the following settings:\n\n";

// Database configuration
echo "Database Configuration:\n";
echo "======================\n";
$db_host = readline("Database Host [localhost]: ") ?: 'localhost';
$db_port = readline("Database Port [3306]: ") ?: '3306';
$db_name = readline("Database Name [bug_tracking_system]: ") ?: 'bug_tracking_system';
$db_username = readline("Database Username: ");
$db_password = readline("Database Password: ");

// Application configuration
echo "\nApplication Configuration:\n";
echo "==========================\n";
$app_name = readline("Application Name [Bug Tracking System]: ") ?: 'Bug Tracking System';
$app_url = readline("Application URL [http://localhost]: ") ?: 'http://localhost';
$app_env = readline("Environment [production/development]: ") ?: 'production';

// Security configuration
echo "\nSecurity Configuration:\n";
echo "=======================\n";
$session_secure = readline("Use secure cookies (HTTPS) [true/false]: ") ?: 'true';
$upload_max_size = readline("Max upload size in bytes [5242880]: ") ?: '5242880';

// Update the .env file
$env_content = str_replace('DB_HOST="localhost"', 'DB_HOST="' . $db_host . '"', $env_content);
$env_content = str_replace('DB_PORT="3306"', 'DB_PORT="' . $db_port . '"', $env_content);
$env_content = str_replace('DB_NAME="bug_tracking_system"', 'DB_NAME="' . $db_name . '"', $env_content);
$env_content = str_replace('DB_USERNAME="your_username"', 'DB_USERNAME="' . $db_username . '"', $env_content);
$env_content = str_replace('DB_PASSWORD="your_secure_password"', 'DB_PASSWORD="' . $db_password . '"', $env_content);

$env_content = str_replace('APP_NAME="Bug Tracking System"', 'APP_NAME="' . $app_name . '"', $env_content);
$env_content = str_replace('APP_URL="http://localhost"', 'APP_URL="' . $app_url . '"', $env_content);
$env_content = str_replace('APP_ENV="production"', 'APP_ENV="' . $app_env . '"', $env_content);

$env_content = str_replace('SESSION_SECURE="true"', 'SESSION_SECURE="' . $session_secure . '"', $env_content);
$env_content = str_replace('UPLOAD_MAX_SIZE="5242880"', 'UPLOAD_MAX_SIZE="' . $upload_max_size . '"', $env_content);

// Write the updated .env file
if (file_put_contents($env_file, $env_content)) {
    echo "\n✓ Configuration saved to .env file\n";
} else {
    echo "\n✗ Failed to save configuration\n";
    exit(1);
}

// Test database connection
echo "\nTesting database connection...\n";
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Class' . DIRECTORY_SEPARATOR . 'config.php';

if ($connect) {
    echo "✓ Database connection successful\n";
} else {
    echo "✗ Database connection failed. Please check your credentials.\n";
    exit(1);
}

// Create uploads directory if it doesn't exist
$uploads_dir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
if (!is_dir($uploads_dir)) {
    if (mkdir($uploads_dir, 0755, true)) {
        echo "✓ Created uploads directory\n";
    } else {
        echo "✗ Failed to create uploads directory\n";
    }
}

// Create logs directory if it doesn't exist
$logs_dir = __DIR__ . DIRECTORY_SEPARATOR . 'logs';
if (!is_dir($logs_dir)) {
    if (mkdir($logs_dir, 0755, true)) {
        echo "✓ Created logs directory\n";
    } else {
        echo "✗ Failed to create logs directory\n";
    }
}

echo "\n=== Setup Complete ===\n";
echo "Your Bug Tracking System is now configured!\n";
echo "Default admin credentials:\n";
echo "Username: admin\n";
echo "Password: admin123\n";
echo "\nIMPORTANT: Change the default password after first login!\n";
echo "\nYou can now access your system at: " . $app_url . "\n";

?>