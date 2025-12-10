<?php

/**
 * Database Setup Helper
 * Jalankan script ini sekali untuk setup database
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'magangpolmed';

// Koneksi ke MySQL (tanpa database dulu)
$conn_temp = mysqli_connect($host, $user, $pass);

if (!$conn_temp) {
    echo "❌ Gagal connect ke MySQL: " . mysqli_connect_error();
    die();
}

echo "✅ Terhubung ke MySQL\n\n";

// Buat database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS magangpolmed";
if (mysqli_query($conn_temp, $sql_create_db)) {
    echo "✅ Database 'magangpolmed' siap\n";
} else {
    echo "❌ Gagal membuat database: " . mysqli_error($conn_temp) . "\n";
    die();
}

// Sekarang connect ke database yang spesifik
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    echo "❌ Gagal connect ke database: " . mysqli_connect_error();
    die();
}

mysqli_set_charset($conn, "utf8");
echo "✅ Terhubung ke database 'magangpolmed'\n\n";

// Buat tabel users
$sql_users = "CREATE TABLE IF NOT EXISTS users (
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

if (mysqli_query($conn, $sql_users)) {
    echo "✅ Tabel 'users' siap\n";
} else {
    echo "❌ Gagal membuat tabel users: " . mysqli_error($conn) . "\n";
}

// Buat tabel lowongan
$sql_lowongan = "CREATE TABLE IF NOT EXISTS lowongan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_lowongan VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    kuota INT NOT NULL,
    periode_mulai DATE NOT NULL,
    periode_selesai DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql_lowongan)) {
    echo "✅ Tabel 'lowongan' siap\n";
} else {
    echo "❌ Gagal membuat tabel lowongan: " . mysqli_error($conn) . "\n";
}

// Buat tabel pengajuan
$sql_pengajuan = "CREATE TABLE IF NOT EXISTS pengajuan (
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

if (mysqli_query($conn, $sql_pengajuan)) {
    echo "✅ Tabel 'pengajuan' siap\n";
} else {
    echo "❌ Gagal membuat tabel pengajuan: " . mysqli_error($conn) . "\n";
}

// Cek apakah admin sudah ada
$check_admin = mysqli_query($conn, "SELECT * FROM users WHERE email='admin@magang.local'");

if (mysqli_num_rows($check_admin) > 0) {
    echo "\n✅ Admin user sudah ada\n";
} else {
    // Insert admin user
    $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
    $sql_insert = "INSERT INTO users (nama, email, password, role) 
                   VALUES ('Admin', 'admin@magang.local', '$password_hash', 'admin')";

    if (mysqli_query($conn, $sql_insert)) {
        echo "\n✅ Admin user berhasil ditambahkan\n";
        echo "   Email: admin@magang.local\n";
        echo "   Password: admin123\n";
    } else {
        echo "\n❌ Gagal menambahkan admin user: " . mysqli_error($conn) . "\n";
    }
}

// Create indexes
mysqli_query($conn, "CREATE INDEX IF NOT EXISTS idx_mahasiswa_id ON pengajuan(mahasiswa_id)");
mysqli_query($conn, "CREATE INDEX IF NOT EXISTS idx_lowongan_id ON pengajuan(lowongan_id)");
mysqli_query($conn, "CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)");

echo "\n✅ Indexes dibuat\n";

// Verifikasi data
echo "\n" . str_repeat("=", 50) . "\n";
echo "📊 DATA YANG TERSEDIA:\n";
echo str_repeat("=", 50) . "\n";

$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"));
echo "Total Users: " . $users_count['count'] . "\n";

$admin_check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email='admin@magang.local' LIMIT 1"));
if ($admin_check) {
    echo "\n✅ Admin Account Found:\n";
    echo "   ID: " . $admin_check['id'] . "\n";
    echo "   Nama: " . $admin_check['nama'] . "\n";
    echo "   Email: " . $admin_check['email'] . "\n";
    echo "   Role: " . $admin_check['role'] . "\n";

    // Test password
    if (password_verify('admin123', $admin_check['password'])) {
        echo "   ✅ Password Verified: YES\n";
    } else {
        echo "   ❌ Password Verified: NO (Password di database tidak cocok!)\n";
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "✅ DATABASE SETUP COMPLETE!\n";
echo str_repeat("=", 50) . "\n";
echo "\n🚀 Silakan login dengan:\n";
echo "   Email: admin@magang.local\n";
echo "   Password: admin123\n";
echo "   Role: admin\n";

mysqli_close($conn);
mysqli_close($conn_temp);
