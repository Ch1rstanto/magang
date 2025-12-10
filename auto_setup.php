#!/usr/bin/env php
<?php
/**
 * Command Line Database Setup
 * Jalankan dari terminal dengan: php auto_setup.php
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║  Sistem Pengelolaan Magang - Auto Setup Database          ║\n";
echo "║  Version: 1.0.0                                            ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'magangpolmed';

echo "🔌 Connecting to MySQL...\n";
$conn_temp = @mysqli_connect($host, $user, $pass);

if (!$conn_temp) {
    echo "❌ ERROR: Could not connect to MySQL\n";
    echo "   Error: " . mysqli_connect_error() . "\n\n";
    echo "   Solution:\n";
    echo "   1. Make sure XAMPP is running\n";
    echo "   2. Check MySQL is enabled\n";
    echo "   3. Try again\n\n";
    die();
}

echo "✅ Connected to MySQL\n\n";

// Create database
echo "📦 Creating database 'magangpolmed'...\n";
$sql = "CREATE DATABASE IF NOT EXISTS $db";
if (mysqli_query($conn_temp, $sql)) {
    echo "✅ Database created/verified\n\n";
} else {
    echo "❌ Failed: " . mysqli_error($conn_temp) . "\n";
    die();
}

// Connect to database
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    echo "❌ Failed to select database\n";
    die();
}
mysqli_set_charset($conn, "utf8");

// Create users table
echo "📋 Creating 'users' table...\n";
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'mahasiswa') NOT NULL,
    no_telepon VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    echo "✅ Table 'users' created/verified\n";
} else {
    echo "⚠️  Warning: " . mysqli_error($conn) . "\n";
}

// Create lowongan table
echo "📋 Creating 'lowongan' table...\n";
$sql = "CREATE TABLE IF NOT EXISTS lowongan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_lowongan VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    kuota INT NOT NULL,
    periode_mulai DATE NOT NULL,
    periode_selesai DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    echo "✅ Table 'lowongan' created/verified\n";
} else {
    echo "⚠️  Warning: " . mysqli_error($conn) . "\n";
}

// Create pengajuan table
echo "📋 Creating 'pengajuan' table...\n";
$sql = "CREATE TABLE IF NOT EXISTS pengajuan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mahasiswa_id INT NOT NULL,
    lowongan_id INT NOT NULL,
    alasan TEXT,
    tanggal_pengajuan DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (lowongan_id) REFERENCES lowongan(id) ON DELETE CASCADE
)";
if (mysqli_query($conn, $sql)) {
    echo "✅ Table 'pengajuan' created/verified\n";
} else {
    echo "⚠️  Warning: " . mysqli_error($conn) . "\n";
}

echo "\n";

// Check if admin exists
$check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE email='admin@magang.local'"));

if ($check['count'] > 0) {
    echo "👤 Admin user already exists\n";

    // Verify password
    $admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email='admin@magang.local'"));
    if (password_verify('admin123', $admin['password'])) {
        echo "✅ Password is correct\n\n";
    } else {
        echo "⚠️  Password mismatch - fixing...\n";
        $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$new_hash' WHERE email='admin@magang.local'");
        echo "✅ Password updated\n\n";
    }
} else {
    echo "👤 Creating admin user...\n";
    $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (nama, email, password, role) 
            VALUES ('Admin', 'admin@magang.local', '$password_hash', 'admin')";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Admin user created\n\n";
    } else {
        echo "❌ Failed to create admin: " . mysqli_error($conn) . "\n\n";
    }
}

// Create indexes
echo "⚡ Creating indexes...\n";
mysqli_query($conn, "CREATE INDEX IF NOT EXISTS idx_mahasiswa_id ON pengajuan(mahasiswa_id)");
mysqli_query($conn, "CREATE INDEX IF NOT EXISTS idx_lowongan_id ON pengajuan(lowongan_id)");
mysqli_query($conn, "CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)");
echo "✅ Indexes created\n\n";

// Summary
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║  ✅ DATABASE SETUP COMPLETE!                              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "📊 INFORMATION:\n";
echo "   Database Name: magangpolmed\n";
echo "   Host: localhost\n";
echo "   Tables: 3 (users, lowongan, pengajuan)\n\n";

echo "👤 ADMIN CREDENTIALS:\n";
echo "   Email: admin@magang.local\n";
echo "   Password: admin123\n";
echo "   Role: admin\n\n";

echo "🌐 ACCESS APPLICATION:\n";
echo "   http://localhost/webmagang2/login.php\n\n";

$users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"));
echo "📈 Current Users: " . $users['count'] . "\n\n";

mysqli_close($conn);
mysqli_close($conn_temp);

echo "Done! ✨\n\n";
?>