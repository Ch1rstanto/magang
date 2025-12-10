<?php
$title = "Pengajuan Magang";
require '../includes/db.php';
require '../includes/header.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Proses approve/reject
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pengajuan_id = $_POST['pengajuan_id'];
    $status = $_POST['status'];
    $query = "UPDATE pengajuan SET status = '$status' WHERE id = $pengajuan_id";
    mysqli_query($conn, $query);
    header("Location: admin/pengajuan.php");
    exit;
}
?>

<div class="col-md-2">
    <div class="sidebar">
        <h5 class="text-white px-3 mb-4">Admin Menu</h5>
        <a href="admin/dashboard.php">Dashboard</a>
        <a href="admin/pengajuan.php" style="background-color: #495057;">Pengajuan Magang</a>
        <a href="admin/lowongan.php">Kelola Lowongan</a>
        <a href="admin/users.php">Kelola User</a>
    </div>
</div>

<div class="col-md-10">
    <div class="main-content">
        <h2>Pengajuan Magang</h2>
        <hr>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Lowongan</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.*, u.nama, l.nama_lowongan 
                         FROM pengajuan p 
                         JOIN users u ON p.mahasiswa_id = u.id 
                         JOIN lowongan l ON p.lowongan_id = l.id
                         ORDER BY p.tanggal_pengajuan DESC";
                $result = mysqli_query($conn, $query);
                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    $status_badge = $row['status'] == 'pending' ? 'warning' : ($row['status'] == 'approved' ? 'success' : 'danger');
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_lowongan']) . "</td>";
                    echo "<td>" . $row['tanggal_pengajuan'] . "</td>";
                    echo "<td><span class='badge bg-" . $status_badge . "'>" . ucfirst($row['status']) . "</span></td>";
                    echo "<td>";
                    if ($row['status'] == 'pending') {
                        echo "<form method='POST' style='display:inline;'>";
                        echo "<input type='hidden' name='pengajuan_id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='status' value='approved'>";
                        echo "<button type='submit' class='btn btn-sm btn-success'>Approve</button>";
                        echo "</form>";
                        echo "<form method='POST' style='display:inline;'>";
                        echo "<input type='hidden' name='pengajuan_id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='status' value='rejected'>";
                        echo "<button type='submit' class='btn btn-sm btn-danger'>Reject</button>";
                        echo "</form>";
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