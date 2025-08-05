<?php
/**
 * Database Configuration
 * 
 * Loads configuration from environment variables for security
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Environment.php';

// Load environment configuration
Environment::load();

/**
 * Database connection class with improved security and error handling
 */
class DatabaseConnection extends mysqli {
    private $mysqli;
    private $isConnected = false;
    
    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        // Get database configuration from environment
        $dbConfig = Environment::getDatabaseConfig();
        
        try {
            $this->mysqli = new mysqli(
                $dbConfig['host'],
                $dbConfig['username'],
                $dbConfig['password'],
                $dbConfig['database'],
                $dbConfig['port']
            );
            
            // Set charset
            $this->mysqli->set_charset($dbConfig['charset']);
            
            // Check connection
            if ($this->mysqli->connect_error) {
                throw new Exception("Connection failed: " . $this->mysqli->connect_error);
            }
            
            $this->isConnected = true;
            
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            $this->isConnected = false;
        }
    }
    
    /**
     * Get database connection
     * 
     * @return mysqli|false Database connection or false on failure
     */
    public function getConnection() {
        if (!$this->isConnected) {
            error_log("Database not connected");
            return false;
        }
        
        return $this->mysqli;
    }
    
    /**
     * Check if connection is active
     * 
     * @return bool
     */
    public function isConnected() {
        return $this->isConnected;
    }
    
    /**
     * Close database connection
     */
    public function closeConnection() {
        if ($this->isConnected && $this->mysqli) {
            $this->mysqli->close();
            $this->isConnected = false;
        }
    }
    
    /**
     * Destructor - Ensure connection is closed
     */
    public function __destruct() {
        $this->closeConnection();
    }
}

// Initialize database connection
$database = new DatabaseConnection();
$connect = $database->getConnection();

// Check if connection was successful
if (!$connect) {
    die("Database connection failed. Please check your configuration.");
}

// Get application configuration
$appConfig = Environment::getAppConfig();
$securityConfig = Environment::getSecurityConfig();
$uploadConfig = Environment::getUploadConfig();

// Set timezone
date_default_timezone_set($appConfig['timezone']);

// Error reporting based on environment
if ($appConfig['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Session configuration for security
ini_set('session.cookie_httponly', $securityConfig['session_http_only'] ? 1 : 0);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', $securityConfig['session_secure'] ? 1 : 0);
ini_set('session.cookie_samesite', $securityConfig['session_same_site']);
ini_set('session.gc_maxlifetime', $securityConfig['session_lifetime']);

// Application constants
define('APP_NAME', $appConfig['name']);
define('APP_VERSION', $appConfig['version']);
define('APP_ENV', $appConfig['environment']);
define('APP_DEBUG', $appConfig['debug']);
define('UPLOAD_MAX_SIZE', $uploadConfig['max_size']);
define('ALLOWED_FILE_TYPES', $uploadConfig['allowed_types']);

?>
