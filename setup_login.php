<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup & Fix Login Issue</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container-setup {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .step {
            margin-bottom: 20px;
            padding: 20px;
            border-left: 4px solid #667eea;
            background-color: #f8f9fa;
        }

        .step.done {
            border-left-color: #28a745;
            background-color: #d4edda;
        }

        .step.error {
            border-left-color: #dc3545;
            background-color: #f8d7da;
        }

        .btn-run {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container-setup">
        <h1 class="mb-4">🔧 Setup Database & Fix Login</h1>

        <div class="alert alert-info" role="alert">
            <strong>Jika Anda gagal login dengan email admin@magang.local dan password admin123, ikuti langkah-langkah di bawah ini.</strong>
        </div>

        <div class="step">
            <h3>📋 Step 1: Setup Database</h3>
            <p>Jalankan script setup untuk membuat database dan admin user:</p>
            <a href="setup.php" target="_blank" class="btn btn-primary btn-run">
                ▶ Jalankan Setup Database
            </a>
            <p class="mt-3 small text-muted">
                <strong>Apa yang dilakukan:</strong>
                ✅ Membuat database 'magangpolmed'<br>
                ✅ Membuat 3 tabel (users, lowongan, pengajuan)<br>
                ✅ Membuat admin user dengan password terenkripsi<br>
                ✅ Membuat indexes untuk performa
            </p>
        </div>

        <div class="step">
            <h3>🔍 Step 2: Diagnosa Masalah</h3>
            <p>Jalankan debug script untuk mengecek status database dan password:</p>
            <a href="debug_login.php" target="_blank" class="btn btn-info btn-run">
                ▶ Jalankan Debug Login
            </a>
            <p class="mt-3 small text-muted">
                <strong>Apa yang dilakukan:</strong>
                ✅ Mengecek koneksi database<br>
                ✅ Mengecek keberadaan tabel users<br>
                ✅ Mengecek admin user<br>
                ✅ Memverifikasi password<br>
                ✅ Memperbaiki otomatis jika ada masalah
            </p>
        </div>

        <div class="step">
            <h3>🚀 Step 3: Login</h3>
            <p>Setelah menjalankan kedua script di atas, silakan login dengan kredensial:</p>
            <div class="alert alert-success">
                <strong>Email:</strong> admin@magang.local<br>
                <strong>Password:</strong> admin123<br>
                <strong>Role:</strong> admin
            </div>
            <a href="login.php" class="btn btn-success btn-lg">
                ▶ Pergi ke Login
            </a>
        </div>

        <hr>

        <h3 class="mt-4">📝 Daftar Masalah & Solusi</h3>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Error</th>
                    <th>Penyebab</th>
                    <th>Solusi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>User tidak ditemukan!</td>
                    <td>Database kosong atau admin belum dibuat</td>
                    <td>Jalankan Setup Database (Step 1)</td>
                </tr>
                <tr>
                    <td>Password salah!</td>
                    <td>Password hash di database tidak cocok</td>
                    <td>Jalankan Debug Login (Step 2)</td>
                </tr>
                <tr>
                    <td>Koneksi database gagal</td>
                    <td>MySQL tidak running atau konfigurasi salah</td>
                    <td>
                        1. Pastikan XAMPP running<br>
                        2. Cek config.php<br>
                        3. Jalankan Debug Login
                    </td>
                </tr>
            </tbody>
        </table>

        <hr>

        <h3 class="mt-4">🎯 Ringkas Proses</h3>
        <ol>
            <li>Buka browser: <strong>http://localhost/webmagang2/setup_login.php</strong> (halaman ini)</li>
            <li>Klik <strong>"Jalankan Setup Database"</strong></li>
            <li>Klik <strong>"Jalankan Debug Login"</strong></li>
            <li>Buka <strong>http://localhost/webmagang2/login.php</strong></li>
            <li>Login dengan: <code>admin@magang.local / admin123</code></li>
        </ol>

        <div class="alert alert-warning mt-4">
            <strong>⚠️ Penting:</strong> Jika masih gagal setelah menjalankan kedua script,
            pastikan:<br>
            ✅ XAMPP (Apache & MySQL) sudah running<br>
            ✅ Port 3306 (MySQL) tidak blocked<br>
            ✅ Tidak ada database lain dengan nama 'magangpolmed'
        </div>

        <div class="mt-4 text-center text-muted">
            <small>Dibuat: Desember 2025 | Sistem Pengelolaan Magang v1.0</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>