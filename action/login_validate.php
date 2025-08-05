<?php
/**
 * Login Validation Handler
 * 
 * Authenticates users and manages login sessions
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Class' . DIRECTORY_SEPARATOR . 'config.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Class' . DIRECTORY_SEPARATOR . 'Utilities.php';

// Start session
session_start();

// Check if form was submitted
if (!isset($_POST['submit'])) {
    $_SESSION['err'] = 'Invalid request';
    header("location: ../index.php");
    exit();
}

// Get and sanitize input
$username = Utilities::sanitizeInput($_POST['uname'] ?? '');
$password = $_POST['pass'] ?? ''; // Get plain password for server-side verification

// Validate input
if (empty($username) || empty($password)) {
    $_SESSION['err'] = 'Username and password are required';
    header("location: ../index.php");
    exit();
}

try {
    // Query database for user
    $query = "SELECT id, username, password, email, full_name, user_type, status 
              FROM users 
              WHERE username = ? AND status = 'active'";
    
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password using secure comparison
        if (Utilities::verifyPassword($password, $user['password'])) {
            // Set session variables
            $_SESSION['login_user_id'] = $user['id'];
            $_SESSION['login_username'] = $user['username'];
            $_SESSION['login_user_type'] = $user['user_type'];
            $_SESSION['login_full_name'] = $user['full_name'];
            $_SESSION['login_email'] = $user['email'];
            $_SESSION['login_time'] = time();
            
            // Update last login time
            $update_query = "UPDATE users SET last_login = NOW() WHERE id = ?";
            $update_stmt = $connect->prepare($update_query);
            $update_stmt->bind_param("i", $user['id']);
            $update_stmt->execute();
            
            // Log successful login
            Utilities::logActivity($user['id'], 'login', 'users', $user['id'], [
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
            
            // Redirect to dashboard
            header("location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['err'] = 'Invalid username or password';
        }
    } else {
        $_SESSION['err'] = 'Invalid username or password';
    }
    
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    $_SESSION['err'] = 'System error occurred. Please try again.';
}

// Redirect back to login page on failure
header("location: ../index.php");
exit();
?>
