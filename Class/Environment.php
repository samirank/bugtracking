<?php
/**
 * Environment Configuration Loader
 * 
 * Handles loading and managing environment variables from .env file
 */

class Environment {
    private static $variables = [];
    private static $loaded = false;
    
    /**
     * Load environment variables from .env file
     * 
     * @param string $path Path to .env file
     * @return bool Success status
     */
    public static function load($path = null) {
        if (self::$loaded) {
            return true;
        }
        
        if ($path === null) {
            $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
        }
        
        if (!file_exists($path)) {
            // If .env doesn't exist, use example.env as fallback
            $example_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'example.env';
            if (file_exists($example_path)) {
                $path = $example_path;
            } else {
                return false;
            }
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, '"\'');
                
                // Remove quotes if present
                if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                    (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                
                self::$variables[$key] = $value;
            }
        }
        
        self::$loaded = true;
        return true;
    }
    
    /**
     * Get environment variable
     * 
     * @param string $key Variable name
     * @param mixed $default Default value if not found
     * @return mixed Variable value or default
     */
    public static function get($key, $default = null) {
        if (!self::$loaded) {
            self::load();
        }
        
        return self::$variables[$key] ?? $default;
    }
    
    /**
     * Set environment variable
     * 
     * @param string $key Variable name
     * @param mixed $value Variable value
     */
    public static function set($key, $value) {
        self::$variables[$key] = $value;
    }
    
    /**
     * Check if environment variable exists
     * 
     * @param string $key Variable name
     * @return bool True if exists
     */
    public static function has($key) {
        if (!self::$loaded) {
            self::load();
        }
        
        return isset(self::$variables[$key]);
    }
    
    /**
     * Get all environment variables
     * 
     * @return array All variables
     */
    public static function all() {
        if (!self::$loaded) {
            self::load();
        }
        
        return self::$variables;
    }
    
    /**
     * Get database configuration array
     * 
     * @return array Database configuration
     */
    public static function getDatabaseConfig() {
        return [
            'host' => self::get('DB_HOST', 'localhost'),
            'port' => self::get('DB_PORT', 3306),
            'database' => self::get('DB_NAME', 'bug_tracking_system'),
            'username' => self::get('DB_USERNAME', ''),
            'password' => self::get('DB_PASSWORD', ''),
            'charset' => self::get('DB_CHARSET', 'utf8mb4')
        ];
    }
    
    /**
     * Get application configuration array
     * 
     * @return array Application configuration
     */
    public static function getAppConfig() {
        return [
            'name' => self::get('APP_NAME', 'Bug Tracking System'),
            'version' => self::get('APP_VERSION', '1.2.0'),
            'environment' => self::get('APP_ENV', 'production'),
            'debug' => self::get('APP_DEBUG', 'false') === 'true',
            'url' => self::get('APP_URL', 'http://localhost'),
            'timezone' => self::get('APP_TIMEZONE', 'UTC')
        ];
    }
    
    /**
     * Get security configuration array
     * 
     * @return array Security configuration
     */
    public static function getSecurityConfig() {
        return [
            'session_secure' => self::get('SESSION_SECURE', 'true') === 'true',
            'session_http_only' => self::get('SESSION_HTTP_ONLY', 'true') === 'true',
            'session_same_site' => self::get('SESSION_SAME_SITE', 'Lax'),
            'session_lifetime' => (int) self::get('SESSION_LIFETIME', 3600),
            'security_headers_enabled' => self::get('SECURITY_HEADERS_ENABLED', 'true') === 'true',
            'csp_enabled' => self::get('CSP_ENABLED', 'true') === 'true'
        ];
    }
    
    /**
     * Get upload configuration array
     * 
     * @return array Upload configuration
     */
    public static function getUploadConfig() {
        return [
            'max_size' => (int) self::get('UPLOAD_MAX_SIZE', 5242880),
            'path' => self::get('UPLOAD_PATH', './uploads'),
            'allowed_types' => explode(',', self::get('ALLOWED_FILE_TYPES', 'jpg,jpeg,png,gif,pdf,doc,docx,txt'))
        ];
    }
}
?>