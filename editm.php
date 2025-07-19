<?php
include 'koneksi.php';

if (!isset($_SESSION['nik'])) {
    echo "Anda belum login. Silakan login terlebih dahulu.";
    exit();
}

$nik = $_SESSION['nik'];
$sql = "SELECT * FROM masyarakat WHERE nik = '$nik'";
$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama = htmlspecialchars($row['nama']);
    $username = htmlspecialchars($row['username']);
    $telp = htmlspecialchars($row['telp']);
} else {
    echo "Data petugas tidak ditemukan.";
    exit();
}

mysqli_close($koneksi);
?>

<div class="container mt-5" style="font-size: 0.85rem;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="?url=profil" class="btn btn-sm btn-outline-secondary px-3 rounded-pill shadow-sm">
                            ← Kembali
                        </a>
                        <h5 class="text-primary mb-0">Edit Profil</h5>
                        <div style="width: 85px;"></div> <!-- Empty space to balance -->
                    </div>
                </div>
                <div class="card-body px-4 py-4">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="nik" value="<?= $nik; ?>">

                        <div class="form-group mb-3">
                            <label for="username" class="text-muted">Username</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="username" name="username" value="<?= $username; ?>" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama" class="text-muted">Nama</label>
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama" value="<?= $nama; ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="telp" class="text-muted">Telepon</label>
                            <input type="text" class="form-control form-control-sm" id="telp" name="telp" value="<?= $telp; ?>" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-primary px-4 rounded-pill shadow-sm">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
