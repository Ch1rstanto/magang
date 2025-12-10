<?php

/**
 * Login Debugger
 * Gunakan untuk diagnosa masalah login
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'magangpolmed';

echo "🔍 LOGIN DEBUGGER\n";
echo str_repeat("=", 60) . "\n\n";

// Connect to database
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo "❌ Database Connection Failed: " . mysqli_connect_error() . "\n";
    die();
}

echo "✅ Connected to database\n\n";

// Check users table
echo "📋 Checking Users Table:\n";
echo str_repeat("-", 60) . "\n";

$result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
if (mysqli_num_rows($result) == 0) {
    echo "❌ Users table does NOT exist!\n";
    echo "   Solution: Run setup.php first\n";
    die();
}
echo "✅ Users table exists\n\n";

// Get all users
$users_query = mysqli_query($conn, "SELECT id, nama, email, role FROM users");
$users_count = mysqli_num_rows($users_query);

echo "Total Users in Database: $users_count\n";

if ($users_count == 0) {
    echo "❌ No users found in database!\n";
    echo "   Solution: Run setup.php to create admin user\n";
} else {
    echo "\nUsers List:\n";
    while ($user = mysqli_fetch_assoc($users_query)) {
        echo "  - " . $user['email'] . " (Role: " . $user['role'] . ")\n";
    }
}

echo "\n";
echo str_repeat("=", 60) . "\n";
echo "🔐 Admin User Check:\n";
echo str_repeat("-", 60) . "\n";

$admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email='admin@magang.local'"));

if (!$admin) {
    echo "❌ Admin user NOT found!\n";
    echo "   Email: admin@magang.local\n";
    echo "   Solution: Run setup.php to create admin user\n";
} else {
    echo "✅ Admin user found:\n";
    echo "  ID: " . $admin['id'] . "\n";
    echo "  Nama: " . $admin['nama'] . "\n";
    echo "  Email: " . $admin['email'] . "\n";
    echo "  Role: " . $admin['role'] . "\n";

    // Test password
    $test_password = 'admin123';
    echo "\n🔑 Testing Password:\n";
    echo "  Test Password: " . $test_password . "\n";

    $password_hash = $admin['password'];
    echo "  Stored Hash: " . substr($password_hash, 0, 50) . "...\n";

    if (password_verify($test_password, $password_hash)) {
        echo "  ✅ Password is CORRECT!\n";
        echo "\n💡 You should be able to login now.\n";
    } else {
        echo "  ❌ Password is INCORRECT!\n";
        echo "  The password hash in database does not match.\n";
        echo "\n  Solution: Deleting old admin and creating new one...\n";

        // Delete old admin
        mysqli_query($conn, "DELETE FROM users WHERE email='admin@magang.local'");
        echo "  ✅ Old admin deleted\n";

        // Create new admin with current password
        $new_hash = password_hash($test_password, PASSWORD_DEFAULT);
        $insert_result = mysqli_query(
            $conn,
            "INSERT INTO users (nama, email, password, role) 
             VALUES ('Admin', 'admin@magang.local', '$new_hash', 'admin')"
        );

        if ($insert_result) {
            echo "  ✅ New admin created with fresh password\n";
            echo "  Email: admin@magang.local\n";
            echo "  Password: admin123\n";
            echo "  ✅ Please refresh the page and login again\n";
        } else {
            echo "  ❌ Failed to create new admin: " . mysqli_error($conn) . "\n";
        }
    }
}

echo "\n";
echo str_repeat("=", 60) . "\n";
echo "✅ DIAGNOSIS COMPLETE\n";
echo str_repeat("=", 60) . "\n";

mysqli_close($conn);
