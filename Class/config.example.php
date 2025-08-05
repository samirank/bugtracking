<?php
/**
 * Database Configuration Example
 * 
 * Copy this file to config.php and update the values according to your environment.
 * Never commit the actual config.php file with real credentials to version control.
 */

/**
 * Database connection class with improved security and error handling
 */
class DatabaseConnection extends mysqli {
    // Database configuration - Update these values
    protected $DBLOCATION = "localhost";
    protected $DBUSER     = "your_username";
    protected $DBPASS     = "your_password";
    protected $DBNAME     = "your_database";
    protected $DBPORT     = 3306;
    protected $DBCHARSET  = "utf8mb4";
    
    private $mysqli;
    private $isConnected = false;
    
    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        try {
            $this->mysqli = new mysqli(
                $this->DBLOCATION,
                $this->DBUSER,
                $this->DBPASS,
                $this->DBNAME,
                $this->DBPORT
            );
            
            // Set charset
            $this->mysqli->set_charset($this->DBCHARSET);
            
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

// Set timezone
date_default_timezone_set('UTC');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

// Application constants
define('APP_NAME', 'Bug Tracking System');
define('APP_VERSION', '1.2.0');
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt']);

?>