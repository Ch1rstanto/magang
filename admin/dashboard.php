<?php
$title = "Admin Dashboard";
require '../includes/db.php';
require '../includes/header.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
?>

<div class="col-md-2">
    <div class="sidebar">
        <h5 class="text-white px-3 mb-4">Admin Menu</h5>
        <a href="../admin/dashboard.php">Dashboard</a>
        <a href="../admin/lowongan.php">Pengajuan Magang</a>
        <a href="../admin/pengajuan.php">Kelola Lowongan</a>
        <a href="../admin/users.php">Kelola User</a>
    </div>
</div>

<div class="col-md-10">
    <div class="main-content">
        <h2>Dashboard Admin</h2>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengajuan</h5>
                        <?php
                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengajuan");
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <p class="card-text fs-3"><?php echo $data['total']; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Lowongan</h5>
                        <?php
                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM lowongan");
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <p class="card-text fs-3"><?php echo $data['total']; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Mahasiswa</h5>
                        <?php
                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'mahasiswa'");
                        $data = mysqli_fetch_assoc($result);
                        ?>
                        <p class="card-text fs-3"><?php echo $data['total']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../includes/footer.php'; ?>