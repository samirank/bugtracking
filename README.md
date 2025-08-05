# Bug Tracking System

A comprehensive PHP-based bug tracking and application management system designed for development teams to efficiently track, manage, and resolve software bugs and issues.

## 🚀 Features

### Core Functionality
- **Bug Management**: Create, track, and update bug reports with detailed information
- **Application Management**: Manage multiple applications and their modules
- **User Management**: Role-based access control (Admin, Developer, Tester)
- **Messaging System**: Internal communication between team members
- **Performance Tracking**: Monitor developer and tester performance metrics
- **File Uploads**: Attach files to bug reports and applications

### User Roles
- **Administrator**: Full system access, user management, application oversight
- **Developer**: Bug assignment, status updates, code fixes tracking
- **Tester**: Bug reporting, application testing, follow-up management

### Dashboard Features
- Real-time bug statistics
- Performance metrics
- Quick access to key functions
- Role-specific navigation

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **UI Framework**: Bootstrap 4
- **Icons**: Font Awesome
- **Charts**: Chart.js
- **Data Tables**: DataTables

## 📋 Prerequisites

Before installing this system, ensure you have:

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (for dependency management - recommended)

## 🔧 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd bug-tracking-system
```

### 2. Quick Setup (Recommended)
Run the interactive setup script:
```bash
php setup.php
```
This will guide you through the configuration process and create the necessary files.

### 3. Manual Setup

#### Database Setup
1. Create a new MySQL database
2. Import the database schema:
```bash
mysql -u your_username -p your_database < database/schema.sql
```

#### Configuration
1. Copy the example environment file:
```bash
cp example.env .env
```
2. Edit the `.env` file with your configuration:
```bash
# Database Configuration
DB_HOST="localhost"
DB_PORT="3306"
DB_NAME="bug_tracking_system"
DB_USERNAME="your_username"
DB_PASSWORD="your_secure_password"

# Application Settings
APP_NAME="Bug Tracking System"
APP_URL="http://your-domain.com"
APP_ENV="production"
```

### 4. File Permissions
Ensure the required directories are writable:
```bash
chmod 755 uploads/
chmod 755 logs/
chmod 644 .env
```

### 5. Web Server Configuration
Point your web server to the project root directory.

## 🚀 Quick Start

1. **Access the System**: Navigate to your web server URL
2. **Default Admin Account**: 
   - Username: `admin`
   - Password: `admin123` (change immediately after first login)
3. **Create Additional Users**: Use the admin panel to create developer and tester accounts

## 📁 Project Structure

```
bug-tracking-system/
├── action/                 # Action handlers and business logic
├── Class/                  # Core classes and database connection
├── template/              # Header, footer, and navigation templates
├── sb_admin/              # Bootstrap admin theme assets
├── uploads/               # File upload directory
├── index.php              # Landing page and login
├── dashboard.php          # Main dashboard
├── README.md              # This file
└── database/              # Database schema and migrations
```

## 🔐 Security Features

- Session-based authentication
- Role-based access control
- Input validation and sanitization
- Secure file upload handling
- SQL injection prevention

## 🎨 Customization

### Styling
- Modify `sb_admin/css/style.css` for custom styling
- Update Bootstrap theme in `sb_admin/css/admin.css`

### Functionality
- Add new features in the `action/` directory
- Extend classes in the `Class/` directory
- Modify templates in the `template/` directory

## 📊 API Endpoints

The system provides several endpoints for data management:

- `/action/login_validate.php` - User authentication
- `/action/new_bug.php` - Create new bug reports
- `/action/update_bug_status.php` - Update bug status
- `/action/new_message.php` - Send internal messages

## 🐛 Bug Reports

If you encounter any issues:

1. Check the error logs
2. Verify database connectivity
3. Ensure proper file permissions
4. Create an issue in the repository

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Check the documentation
- Review the code comments

## 🔄 Version History

- **v1.0.0** - Initial release with core bug tracking functionality
- **v1.1.0** - Added performance tracking and enhanced UI
- **v1.2.0** - Improved security and code structure

---

**Note**: This is a development version. For production use, ensure proper security measures are implemented and tested thoroughly.