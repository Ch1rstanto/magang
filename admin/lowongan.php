<?php
$title = "Kelola Lowongan";
require '../includes/db.php';
require '../includes/header.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$success = '';
$error = '';

// Tambah lowongan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $nama_lowongan = mysqli_real_escape_string($conn, $_POST['nama_lowongan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kuota = $_POST['kuota'];
    $periode_mulai = $_POST['periode_mulai'];
    $periode_selesai = $_POST['periode_selesai'];

    $query = "INSERT INTO lowongan (nama_lowongan, deskripsi, kuota, periode_mulai, periode_selesai) 
             VALUES ('$nama_lowongan', '$deskripsi', $kuota, '$periode_mulai', '$periode_selesai')";
    if (mysqli_query($conn, $query)) {
        $success = "Lowongan berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan lowongan!";
    }
}

// Hapus lowongan
if ($_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM lowongan WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $success = "Lowongan berhasil dihapus!";
    } else {
        $error = "Gagal menghapus lowongan!";
    }
}
?>

<div class="col-md-2">
    <div class="sidebar">
        <h5 class="text-white px-3 mb-4">Admin Menu</h5>
        <a href="admin/dashboard.php">Dashboard</a>
        <a href="admin/pengajuan.php">Pengajuan Magang</a>
        <a href="admin/lowongan.php" style="background-color: #495057;">Kelola Lowongan</a>
        <a href="admin/users.php">Kelola User</a>
    </div>
</div>

<div class="col-md-10">
    <div class="main-content">
        <h2>Kelola Lowongan Magang</h2>
        <hr>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahLowonganModal">Tambah Lowongan</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lowongan</th>
                    <th>Kuota</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM lowongan";
                $result = mysqli_query($conn, $query);
                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_lowongan']) . "</td>";
                    echo "<td>" . $row['kuota'] . "</td>";
                    echo "<td>" . $row['periode_mulai'] . " s/d " . $row['periode_selesai'] . "</td>";
                    echo "<td>";
                    echo "<a href='/admin/lowongan.php?action=hapus&id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Lowongan -->
<div class="modal fade" id="tambahLowonganModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Lowongan Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="tambah">
                    <div class="mb-3">
                        <label for="nama_lowongan" class="form-label">Nama Lowongan</label>
                        <input type="text" class="form-control" id="nama_lowongan" name="nama_lowongan" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kuota" class="form-label">Kuota</label>
                        <input type="number" class="form-control" id="kuota" name="kuota" required>
                    </div>
                    <div class="mb-3">
                        <label for="periode_mulai" class="form-label">Periode Mulai</label>
                        <input type="date" class="form-control" id="periode_mulai" name="periode_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="periode_selesai" class="form-label">Periode Selesai</label>
                        <input type="date" class="form-control" id="periode_selesai" name="periode_selesai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require '../includes/footer.php'; ?>