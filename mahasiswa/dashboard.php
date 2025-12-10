<?php
$title = "Mahasiswa Dashboard";
require '../includes/db.php';
require '../includes/header.php';

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}
?>

<div class="col-md-2">
    <div class="sidebar">
        <h5 class="text-white px-3 mb-4">Mahasiswa Menu</h5>
        <a href="mahasiswa/dashboard.php" style="background-color: #495057;">Dashboard</a>
        <a href="mahasiswa/pengajuan.php">Pengajuan Magang</a>
        <a href="mahasiswa/profil.php">Profil</a>
    </div>
</div>

<div class="col-md-10">
    <div class="main-content">
        <h2>Dashboard Mahasiswa</h2>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengajuan Magang Saya</h5>
                        <?php
                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengajuan WHERE mahasiswa_id = " . $_SESSION['user_id']);
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <p class="card-text fs-3"><?php echo $data['total']; ?></p>
                        <a href="mahasiswa/pengajuan.php" class="btn btn-primary btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Status Pengajuan</h5>
                        <?php
                        $result = mysqli_query($conn, "SELECT status, COUNT(*) as total FROM pengajuan WHERE mahasiswa_id = " . $_SESSION['user_id'] . " GROUP BY status");
                        $approved = 0;
                        $pending = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['status'] == 'approved') $approved = $row['total'];
                            else if ($row['status'] == 'pending') $pending = $row['total'];
                        }
                        ?>
                        <p class="card-text">
                            <span class="badge bg-success">Disetujui: <?php echo $approved; ?></span>
                            <span class="badge bg-warning text-dark">Menunggu: <?php echo $pending; ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <h4>Lowongan Magang Terbaru</h4>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Lowongan</th>
                    <th>Kuota</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM lowongan ORDER BY id DESC LIMIT 5";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nama_lowongan']) . "</td>";
                    echo "<td>" . $row['kuota'] . "</td>";
                    echo "<td>" . $row['periode_mulai'] . " s/d " . $row['periode_selesai'] . "</td>";
                    echo "<td>";
                    echo "<a href='/mahasiswa/pengajuan_buat.php?lowongan_id=" . $row['id'] . "' class='btn btn-sm btn-primary'>Ajukan</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require '../includes/footer.php'; ?>