<?php
/**
 * Bug Tracking System - Landing Page
 * 
 * Main entry point for the application
 */

// Start session with secure settings
session_start();

// Redirect if already logged in
if (isset($_SESSION['login_user_id'])) {
    header('location: dashboard.php');
    exit();
} else {
    session_destroy();
    session_start();
}

// Handle error messages
$error_message = '';
if (isset($_SESSION['err'])) {
    $error_message = $_SESSION['err'];
    unset($_SESSION['err']);
}

// Define page title
$page_title = APP_NAME . ' - Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Professional bug tracking and application management system">
    <meta name="keywords" content="bug tracking, project management, software development">
    <meta name="author" content="Bug Tracking System">
    
    <title><?php echo htmlspecialchars($page_title); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="logo.svg">
    
    <!-- Bootstrap core CSS -->
    <link href="sb_admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom fonts for this template -->
    <link href="sb_admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Plugin CSS -->
    <link href="sb_admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="sb_admin/css/admin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="sb_admin/css/style.css">
    
    <!-- Security headers -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="logo.svg" width="30" height="30" alt="<?php echo htmlspecialchars(APP_NAME); ?> Logo" class="d-inline-block align-top">
                <?php echo htmlspecialchars(APP_NAME); ?>
            </a>
            
            <div class="navbar-nav ml-auto">
                <a class="nav-link" href="#about">About</a>
                <a class="nav-link" href="#contact">Contact</a>
                <a class="nav-link btn btn-primary" href="#" data-toggle="modal" data-target="#login-modal">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 font-weight-bold">Professional Bug Tracking System</h1>
                    <p class="lead">Streamline your development workflow with our comprehensive bug tracking and application management solution.</p>
                    <div class="mt-4">
                        <a class="btn btn-light btn-lg mr-3" href="#" data-toggle="modal" data-target="#login-modal">
                            <i class="fa fa-sign-in"></i> Sign In
                        </a>
                        <a class="btn btn-outline-light btn-lg" href="#features">
                            <i class="fa fa-info-circle"></i> Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="logo.svg" alt="System Logo" class="img-fluid" style="max-width: 300px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Key Features</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fa fa-bug fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Bug Management</h5>
                            <p class="card-text">Track, assign, and resolve bugs efficiently with detailed reporting and status updates.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fa fa-code fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Application Management</h5>
                            <p class="card-text">Manage multiple applications and modules with comprehensive version control.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fa fa-users fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Team Collaboration</h5>
                            <p class="card-text">Role-based access control for developers, testers, and administrators.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Sign In to Your Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="action/login_validate.php" id="loginForm">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="uname" 
                                   placeholder="Enter your username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="pass" 
                                   placeholder="Enter your password" required>
                        </div>
                        <input type="hidden" name="enc" id="enc" value="">
                        <button type="submit" class="btn btn-primary btn-block" onclick="return encryptPassword();">
                            <i class="fa fa-sign-in"></i> Sign In
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <small class="text-muted">Need help? Contact your system administrator.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo htmlspecialchars(APP_NAME); ?></h5>
                    <p class="text-muted">Professional bug tracking and application management system.</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p class="text-muted">Version <?php echo htmlspecialchars(APP_VERSION); ?></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="sb_admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb_admin/vendor/popper/popper.min.js"></script>
    <script src="sb_admin/vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- Plugin JavaScript -->
    <script src="sb_admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="sb_admin/vendor/chart.js/Chart.min.js"></script>
    <script src="sb_admin/vendor/datatables/jquery.dataTables.js"></script>
    <script src="sb_admin/vendor/datatables/dataTables.bootstrap4.js"></script>
    
    <!-- Custom scripts for this template -->
    <script src="sb_admin/js/sb-admin.min.js"></script>
    <script src="sb_admin/js/aes.js"></script>
    
    <script>
        /**
         * Encrypt password before form submission
         * Note: This is a basic implementation. Consider using HTTPS and server-side hashing for production.
         */
        function encryptPassword() {
            var password = document.getElementById("password").value;
            if (password.trim() === '') {
                alert('Please enter a password');
                return false;
            }
            
            // Use SHA-256 instead of MD5 for better security
            var hash = CryptoJS.SHA256(password);
            document.getElementById('enc').value = hash;
            return true;
        }
        
        // Auto-focus username field when modal opens
        $('#login-modal').on('shown.bs.modal', function () {
            $('#username').focus();
        });
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();
            
            if (username === '' || password === '') {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
        });
    </script>
</body>
</html>