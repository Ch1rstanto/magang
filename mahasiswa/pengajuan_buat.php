<?php
$title = "Buat Pengajuan Magang";
require '../includes/db.php';
require '../includes/header.php';

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lowongan_id = $_POST['lowongan_id'];
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan']);
    $tanggal_pengajuan = date('Y-m-d H:i:s');

    // Check if already applied
    $check = mysqli_query($conn, "SELECT * FROM pengajuan WHERE mahasiswa_id = " . $_SESSION['user_id'] . " AND lowongan_id = $lowongan_id");

    if (mysqli_num_rows($check) > 0) {
        $error = "Anda sudah mengajukan lowongan ini!";
    } else {
        $query = "INSERT INTO pengajuan (mahasiswa_id, lowongan_id, alasan, tanggal_pengajuan, status) 
                 VALUES (" . $_SESSION['user_id'] . ", $lowongan_id, '$alasan', '$tanggal_pengajuan', 'pending')";
        if (mysqli_query($conn, $query)) {
            $success = "Pengajuan berhasil dibuat!";
            header("Refresh: 2; url=/mahasiswa/pengajuan.php");
        } else {
            $error = "Gagal membuat pengajuan!";
        }
    }
}

$lowongan_id = $_GET['lowongan_id'] ?? '';
$lowongan = null;
if ($lowongan_id) {
    $result = mysqli_query($conn, "SELECT * FROM lowongan WHERE id = $lowongan_id");
    $lowongan = mysqli_fetch_assoc($result);
}
?>

<div class="col-md-2">
    <div class="sidebar">
        <h5 class="text-white px-3 mb-4">Mahasiswa Menu</h5>
        <a href="mahasiswa/dashboard.php">Dashboard</a>
        <a href="mahasiswa/pengajuan.php" style="background-color: #495057;">Pengajuan Magang</a>
        <a href="mahasiswa/profil.php">Profil</a>
    </div>
</div>

<div class="col-md-10">
    <div class="main-content">
        <h2>Buat Pengajuan Magang</h2>
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
                        <label for="lowongan" class="form-label">Pilih Lowongan</label>
                        <select class="form-control" name="lowongan_id" id="lowongan" required>
                            <option value="">-- Pilih Lowongan --</option>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM lowongan ORDER BY nama_lowongan");
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($lowongan_id == $row['id']) ? 'selected' : '';
                                echo "<option value='" . $row['id'] . "' $selected>" . htmlspecialchars($row['nama_lowongan']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <?php if ($lowongan): ?>
                        <div class="mb-3">
                            <label class="form-label">Informasi Lowongan</label>
                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Deskripsi:</strong></p>
                                    <p><?php echo htmlspecialchars($lowongan['deskripsi']); ?></p>
                                    <p><strong>Kuota:</strong> <?php echo $lowongan['kuota']; ?></p>
                                    <p><strong>Periode:</strong> <?php echo $lowongan['periode_mulai'] . " s/d " . $lowongan['periode_selesai']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Pengajuan</label>
                        <textarea class="form-control" id="alasan" name="alasan" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                    <a href="mahasiswa/pengajuan.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php'; ?>