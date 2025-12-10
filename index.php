<?php
session_start();

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: mahasiswa/dashboard.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengelolaan Magang Mahasiswa</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .home-container {
            text-align: center;
            color: white;
            max-width: 600px;
        }

        .home-container h1 {
            font-size: 3em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .home-container p {
            font-size: 1.2em;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-container {
            margin-top: 40px;
        }

        .btn-container a {
            margin: 10px;
            padding: 12px 30px;
            font-size: 1.1em;
            min-width: 150px;
        }

        .feature-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            backdrop-filter: blur(10px);
        }

        .feature-box h3 {
            color: #fff;
            margin-bottom: 10px;
        }

        .feature-box p {
            color: #eee;
            font-size: 0.95em;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="home-container">
        <h1>Sistem Pengelolaan Magang</h1>
        <p>Kelola pengajuan magang mahasiswa dengan mudah dan efisien</p>

        <div class="feature-box">
            <div class="row">
                <div class="col-md-6">
                    <h3>Untuk Admin</h3>
                    <p>✓ Kelola pengajuan magang</p>
                    <p>✓ Tambah/hapus lowongan</p>
                    <p>✓ Kelola data user</p>
                </div>
                <div class="col-md-6">
                    <h3>Untuk Mahasiswa</h3>
                    <p>✓ Ajukan magang</p>
                    <p>✓ Kelola profil</p>
                    <p>✓ Cek status pengajuan</p>
                </div>
            </div>
        </div>

        <div class="btn-container">
            <a href="login.php" class="btn btn-primary btn-lg">Masuk Sistem</a>
        </div>

        <p style="margin-top: 50px; font-size: 0.9em; opacity: 0.8;">
            Teknologi: PHP Native | MySQL | Bootstrap 5
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>