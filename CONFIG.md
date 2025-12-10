# Configuration & Best Practices

## ⚙️ Server Configuration

### XAMPP Requirements

```
- Apache 2.4+
- PHP 7.4+
- MySQL 5.7+
- mod_rewrite enabled
```

### Enable mod_rewrite

Edit `C:\xampp\apache\conf\httpd.conf`:

```
Uncomment: LoadModule rewrite_module modules/mod_rewrite.so
```

### PHP Configuration

Edit `C:\xampp\php\php.ini`:

```ini
[PHP]
display_errors = Off
log_errors = On
error_log = "C:\xampp\php\php_error.log"

[Session]
session.name = PHPSESSID
session.gc_maxlifetime = 1440
session.cookie_httponly = 1
```

---

## 🔐 Security Configuration

### 1. Database Security

```sql
-- Create database user dengan limited privilege (production)
CREATE USER 'magang_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON magangpolmed.* TO 'magang_user'@'localhost';
FLUSH PRIVILEGES;

-- Update config.php
$user = 'magang_user';
$pass = 'strong_password';
```

### 2. File Permissions

```bash
# Windows (Command Prompt as Admin)
icacls "C:\xampp\htdocs\webmagang2" /grant Everyone:(OI)(CI)F /T

# Linux/Mac
chmod -R 755 /var/www/webmagang2
chmod -R 644 /var/www/webmagang2/*.php
```

### 3. config.php Permissions

```bash
# Restrict access ke config.php
# Sudah handled di .htaccess
```

### 4. HTTPS Configuration (Production)

Edit `.htaccess`:

```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 📋 Database Configuration

### config.php

```php
<?php
session_start();

// Database Configuration
$host = 'localhost';      // MySQL host
$user = 'root';           // MySQL user
$pass = '';               // MySQL password
$db = 'magangpolmed';     // Database name

// Connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Error Handling
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set Character Set
mysqli_set_charset($conn, "utf8");

// Optional: Error Reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
```

### Alternative: Using constants

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'magangpolmed');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>
```

---

## 🚀 Production Deployment

### 1. Pre-Deployment Checklist

- [ ] Database backup created
- [ ] config.php updated dengan prod credentials
- [ ] SSL certificate installed
- [ ] Error reporting set to Off
- [ ] Logs directory created
- [ ] Backup strategy planned
- [ ] Security headers configured

### 2. Environment Variables (Recommended)

```php
// Create .env file
DB_HOST=production-db-server.com
DB_USER=magang_prod_user
DB_PASS=secure_password_here
DB_NAME=magangpolmed_prod

// Load in config.php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db = getenv('DB_NAME');
```

### 3. Error Logging

```php
// php.ini
display_errors = Off
log_errors = On
error_log = /var/log/php_error.log

// Access log rotation
logrotate configuration needed
```

### 4. CORS Headers (if needed)

```php
header("Access-Control-Allow-Origin: https://yourdomain.com");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
```

---

## 💾 Backup Strategy

### Database Backup

```bash
# Daily backup
mysqldump -u root -p magangpolmed > backup_$(date +%Y%m%d).sql

# Scheduled in Windows Task Scheduler
# or cron job in Linux/Mac
```

### File Backup

```bash
# Backup entire webmagang2 folder
tar -czf webmagang2_backup_$(date +%Y%m%d).tar.gz /var/www/webmagang2

# Upload to cloud storage
# Keep 30 days retention
```

---

## 📊 Performance Optimization

### 1. Database Optimization

```sql
-- Add indexes (sudah di database.sql)
CREATE INDEX idx_mahasiswa_id ON pengajuan(mahasiswa_id);
CREATE INDEX idx_lowongan_id ON pengajuan(lowongan_id);
CREATE INDEX idx_users_email ON users(email);

-- Regular maintenance
OPTIMIZE TABLE users;
OPTIMIZE TABLE lowongan;
OPTIMIZE TABLE pengajuan;
REPAIR TABLE users;
```

### 2. Query Optimization

```php
// Use SELECT specific columns
SELECT id, nama, email FROM users;  // Good
SELECT * FROM users;                // Bad (if not needed all)

// Use LIMIT for large resultsets
SELECT * FROM pengajuan LIMIT 10, 20;

// Use indexes in WHERE clause
WHERE id = 1;           // Good (indexed)
WHERE SUBSTRING(nama, 1, 3) = 'Abu';  // Bad (full scan)
```

### 3. Caching Strategy

```php
// Simple cache untuk data static
$cache_file = 'cache/lowongan_list.json';
if (file_exists($cache_file) && time() - filemtime($cache_file) < 3600) {
    $data = json_decode(file_get_contents($cache_file));
} else {
    $data = mysqli_query($conn, "SELECT * FROM lowongan");
    file_put_contents($cache_file, json_encode($data));
}
```

### 4. Code Optimization

```php
// Avoid N+1 query problem
// Bad:
foreach($pengajuan as $p) {
    $user = mysqli_query($conn, "SELECT * FROM users WHERE id=" . $p['mahasiswa_id']);
}

// Good:
$query = "SELECT p.*, u.* FROM pengajuan p JOIN users u ON p.mahasiswa_id = u.id";
```

---

## 🔍 Monitoring & Logging

### 1. Application Logging

```php
// Create log file
function log_action($action, $user_id, $details) {
    $log = "["  . date('Y-m-d H:i:s') . "] User: $user_id | Action: $action | Details: $details\n";
    file_put_contents('logs/app.log', $log, FILE_APPEND);
}

// Usage
log_action('LOGIN', $_SESSION['user_id'], 'Login successful');
```

### 2. Error Tracking

```php
// Error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $error = "[$errno] $errstr in $errfile:$errline";
    file_put_contents('logs/error.log', $error . "\n", FILE_APPEND);
});
```

### 3. Monitor System

```bash
# Check disk space
df -h

# Check MySQL status
systemctl status mysql

# Check Apache status
systemctl status apache2

# Check logs
tail -f /var/log/php_error.log
tail -f /var/log/apache2/error.log
```

---

## 🛡️ Security Hardening

### 1. SQL Injection Prevention

```php
// Use prepared statements (better than escape)
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
$stmt->bind_param("ss", $email, $role);
$stmt->execute();
$result = $stmt->get_result();
```

### 2. XSS Prevention

```php
// Escape output
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');

// or use
echo htmlentities($user_input);
```

### 3. CSRF Prevention

```php
// Generate token
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check token
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF token validation failed');
}
```

### 4. Password Requirements

```php
// Minimum password requirements
function validate_password($password) {
    return strlen($password) >= 8 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/[0-9]/', $password) &&
           preg_match('/[!@#$%^&*]/', $password);
}
```

### 5. Rate Limiting (Login Attempts)

```php
$max_attempts = 5;
$lockout_time = 15; // minutes

// Check attempts
$attempts_key = 'login_attempts_' . $_SERVER['REMOTE_ADDR'];
$attempts = isset($_SESSION[$attempts_key]) ? $_SESSION[$attempts_key] : 0;

if ($attempts >= $max_attempts) {
    die('Too many login attempts. Try again later.');
}

// Increment on failed attempt
$_SESSION[$attempts_key]++;
```

---

## 📱 Multi-Environment Setup

### Development Environment

```php
define('ENVIRONMENT', 'development');
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Staging Environment

```php
define('ENVIRONMENT', 'staging');
ini_set('display_errors', 0);
error_reporting(E_ALL);
```

### Production Environment

```php
define('ENVIRONMENT', 'production');
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
```

---

## 🔄 Maintenance Tasks

### Weekly

- [ ] Check disk space
- [ ] Review error logs
- [ ] Test backup restoration
- [ ] Check database size

### Monthly

- [ ] Optimize database
- [ ] Clean old logs
- [ ] Update dependencies
- [ ] Security patches

### Quarterly

- [ ] Full backup verification
- [ ] Security audit
- [ ] Performance analysis
- [ ] Capacity planning

---

## 📞 Troubleshooting Guide

### Problem: "Koneksi database gagal"

```
Solution:
1. Verify MySQL service running
2. Check config.php credentials
3. Verify database exists: SHOW DATABASES;
4. Check user privileges: SELECT * FROM mysql.user;
```

### Problem: "Undefined index"

```
Solution:
1. Use isset() or array_key_exists()
2. Enable error reporting in development
3. Check form field names
4. Verify POST/GET data sent
```

### Problem: "Session not working"

```
Solution:
1. Verify session_start() called first
2. Check session directory writable
3. Verify php.ini session settings
4. Clear browser cookies
```

### Problem: "Permission denied"

```
Solution:
1. Check folder permissions (755 for dirs, 644 for files)
2. Check owner:group (should be www-data:www-data)
3. Check SELinux/AppArmor rules
4. Run: chown -R www-data:www-data /var/www/webmagang2
```

---

## 📚 Resources & References

- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [MySQL Best Practices](https://dev.mysql.com/doc/)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)

---

**Last Updated:** Desember 2025
**Version:** 1.0.0
