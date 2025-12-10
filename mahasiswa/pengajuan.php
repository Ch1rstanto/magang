<?php
$title = "Pengajuan Magang Saya";
require '../includes/db.php';
require '../includes/header.php';

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}

// Hapus pengajuan
if ($_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pengajuan WHERE id = $id AND mahasiswa_id = " . $_SESSION['user_id'];
    mysqli_query($conn, $query);
    header("Location: mahasiswa/pengajuan.php");
    exit;
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
        <h2>Pengajuan Magang Saya</h2>
        <hr>

        <a href="mahasiswa/pengajuan_buat.php" class="btn btn-primary mb-3">Buat Pengajuan Baru</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lowongan</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.*, l.nama_lowongan 
                         FROM pengajuan p 
                         JOIN lowongan l ON p.lowongan_id = l.id
                         WHERE p.mahasiswa_id = " . $_SESSION['user_id'] . "
                         ORDER BY p.tanggal_pengajuan DESC";
                $result = mysqli_query($conn, $query);
                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    $status_badge = $row['status'] == 'pending' ? 'warning' : ($row['status'] == 'approved' ? 'success' : 'danger');
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_lowongan']) . "</td>";
                    echo "<td>" . $row['tanggal_pengajuan'] . "</td>";
                    echo "<td><span class='badge bg-" . $status_badge . "'>" . ucfirst($row['status']) . "</span></td>";
                    echo "<td>";
                    if ($row['status'] == 'pending') {
                        echo "<a href='/mahasiswa/pengajuan.php?action=hapus&id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require '../includes/footer.php'; ?>