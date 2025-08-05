<?php
/**
 * Utilities Class
 * 
 * Provides common helper functions for the bug tracking system
 */

class Utilities {
    
    /**
     * Sanitize input data
     * 
     * @param string $data Input data to sanitize
     * @return string Sanitized data
     */
    public static function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
    
    /**
     * Validate email address
     * 
     * @param string $email Email to validate
     * @return bool True if valid, false otherwise
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Generate secure random string
     * 
     * @param int $length Length of the string
     * @return string Random string
     */
    public static function generateRandomString($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Hash password using secure algorithm
     * 
     * @param string $password Plain text password
     * @return string Hashed password
     */
    public static function hashPassword($password) {
        return hash('sha256', $password);
    }
    
    /**
     * Verify password against hash
     * 
     * @param string $password Plain text password
     * @param string $hash Stored hash
     * @return bool True if match, false otherwise
     */
    public static function verifyPassword($password, $hash) {
        return self::hashPassword($password) === $hash;
    }
    
    /**
     * Format date for display
     * 
     * @param string $date Date string
     * @param string $format Output format
     * @return string Formatted date
     */
    public static function formatDate($date, $format = 'Y-m-d H:i:s') {
        if (empty($date)) {
            return '';
        }
        
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return $date;
        }
        
        return date($format, $timestamp);
    }
    
    /**
     * Get time ago string
     * 
     * @param string $date Date string
     * @return string Time ago string
     */
    public static function timeAgo($date) {
        if (empty($date)) {
            return '';
        }
        
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return $date;
        }
        
        $time_difference = time() - $timestamp;
        
        if ($time_difference < 60) {
            return 'Just now';
        } elseif ($time_difference < 3600) {
            $minutes = floor($time_difference / 60);
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
        } elseif ($time_difference < 86400) {
            $hours = floor($time_difference / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($time_difference < 2592000) {
            $days = floor($time_difference / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return self::formatDate($date, 'M j, Y');
        }
    }
    
    /**
     * Get severity badge class
     * 
     * @param string $severity Severity level
     * @return string Bootstrap badge class
     */
    public static function getSeverityBadgeClass($severity) {
        switch (strtolower($severity)) {
            case 'critical':
                return 'badge-danger';
            case 'high':
                return 'badge-warning';
            case 'medium':
                return 'badge-info';
            case 'low':
                return 'badge-success';
            default:
                return 'badge-secondary';
        }
    }
    
    /**
     * Get priority badge class
     * 
     * @param string $priority Priority level
     * @return string Bootstrap badge class
     */
    public static function getPriorityBadgeClass($priority) {
        switch (strtolower($priority)) {
            case 'urgent':
                return 'badge-danger';
            case 'high':
                return 'badge-warning';
            case 'medium':
                return 'badge-info';
            case 'low':
                return 'badge-success';
            default:
                return 'badge-secondary';
        }
    }
    
    /**
     * Get status badge class
     * 
     * @param string $status Status
     * @return string Bootstrap badge class
     */
    public static function getStatusBadgeClass($status) {
        switch (strtolower($status)) {
            case 'open':
                return 'badge-danger';
            case 'assigned':
                return 'badge-warning';
            case 'in_progress':
                return 'badge-info';
            case 'testing':
                return 'badge-primary';
            case 'fixed':
                return 'badge-success';
            case 'closed':
                return 'badge-secondary';
            case 'reopened':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }
    
    /**
     * Format file size
     * 
     * @param int $bytes File size in bytes
     * @return string Formatted file size
     */
    public static function formatFileSize($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
    
    /**
     * Validate file upload
     * 
     * @param array $file $_FILES array element
     * @param array $allowed_types Allowed file types
     * @param int $max_size Maximum file size in bytes
     * @return array Validation result
     */
    public static function validateFileUpload($file, $allowed_types = [], $max_size = UPLOAD_MAX_SIZE) {
        $result = [
            'valid' => false,
            'message' => ''
        ];
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $result['message'] = 'File upload failed';
            return $result;
        }
        
        // Check file size
        if ($file['size'] > $max_size) {
            $result['message'] = 'File size exceeds maximum limit of ' . self::formatFileSize($max_size);
            return $result;
        }
        
        // Check file type
        if (!empty($allowed_types)) {
            $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_types)) {
                $result['message'] = 'File type not allowed. Allowed types: ' . implode(', ', $allowed_types);
                return $result;
            }
        }
        
        $result['valid'] = true;
        return $result;
    }
    
    /**
     * Log activity
     * 
     * @param int $user_id User ID
     * @param string $action Action performed
     * @param string $table_name Table name
     * @param int $record_id Record ID
     * @param array $details Additional details
     * @return bool Success status
     */
    public static function logActivity($user_id, $action, $table_name = null, $record_id = null, $details = []) {
        global $connect;
        
        try {
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $details_json = !empty($details) ? json_encode($details) : null;
            
            $query = "INSERT INTO activity_log (user_id, action, table_name, record_id, details, ip_address) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $connect->prepare($query);
            $stmt->bind_param("ississ", $user_id, $action, $table_name, $record_id, $details_json, $ip_address);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error logging activity: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send email notification
     * 
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $message Email message
     * @return bool Success status
     */
    public static function sendEmail($to, $subject, $message) {
        // Basic email sending implementation
        // In production, use a proper email library like PHPMailer
        
        $headers = [
            'From: ' . APP_NAME . ' <noreply@example.com>',
            'Reply-To: noreply@example.com',
            'Content-Type: text/html; charset=UTF-8',
            'X-Mailer: PHP/' . phpversion()
        ];
        
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
    
    /**
     * Generate pagination links
     * 
     * @param int $current_page Current page number
     * @param int $total_pages Total number of pages
     * @param string $base_url Base URL for pagination
     * @return string HTML pagination links
     */
    public static function generatePagination($current_page, $total_pages, $base_url) {
        if ($total_pages <= 1) {
            return '';
        }
        
        $html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        
        // Previous button
        if ($current_page > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=' . ($current_page - 1) . '">Previous</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
        }
        
        // Page numbers
        $start = max(1, $current_page - 2);
        $end = min($total_pages, $current_page + 2);
        
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $current_page) {
                $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=' . $i . '">' . $i . '</a></li>';
            }
        }
        
        // Next button
        if ($current_page < $total_pages) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=' . ($current_page + 1) . '">Next</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
        }
        
        $html .= '</ul></nav>';
        
        return $html;
    }
    
    /**
     * Check if user has permission
     * 
     * @param string $required_type Required user type
     * @param string $user_type Current user type
     * @return bool True if user has permission
     */
    public static function hasPermission($required_type, $user_type) {
        $permissions = [
            'admin' => ['admin'],
            'developer' => ['admin', 'developer'],
            'tester' => ['admin', 'developer', 'tester']
        ];
        
        return in_array($user_type, $permissions[$required_type] ?? []);
    }
}
?>