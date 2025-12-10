<?php
$title = "Profil Mahasiswa";
require '../includes/db.php';
require '../includes/header.php';

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}

$success = '';
$error = '';

// Get user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = " . $_SESSION['user_id']);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = "UPDATE users SET nama = '$nama', email = '$email', no_telepon = '$no_telepon', alamat = '$alamat' 
             WHERE id = " . $_SESSION['user_id'];
    if (mysqli_query($conn, $query)) {
        $success = "Profil berhasil diperbarui!";
        $_SESSION['nama'] = $nama;
        $user['nama'] = $nama;
        $user['email'] = $email;
        $user['no_telepon'] = $no_telepon;
        $user['alamat'] = $alamat;
    } else {
        $error = "Gagal memperbarui profil!";
    }
}
?>

<div class="col-md-2">
    <div class="sidebar">
        <h5 class="text-white px-3 mb-4">Mahasiswa Menu</h5>
        <a href="mahasiswa/dashboard.php">Dashboard</a>
        <a href="mahasiswa/pengajuan.php">Pengajuan Magang</a>
        <a href="mahasiswa/profil.php" style="background-color: #495057;">Profil</a>
    </div>
</div>

<div class="col-md-10">
    <div class="main-content">
        <h2>Profil Mahasiswa</h2>
        <hr>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="card" style="max-width: 600px;">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($user['no_telepon'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4"><?php echo htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php'; ?>