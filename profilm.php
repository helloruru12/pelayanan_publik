<?php
// Cek login
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('index.php');</script>";
    exit();
}

// Koneksi ke database
include 'koneksi.php';

// Ambil data masyarakat berdasarkan NIK
$nik = $_SESSION['nik'];
$sql = "SELECT * FROM masyarakat WHERE nik = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $nik);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nik = $row['nik'];
    $nama = $row['nama'];
    $username = $row['username'];
    $telp = $row['telp'];
    $password = $row['password'];
    $foto_path = $row['foto'] ? "img/profil/" . $row['foto'] : "img/profil/pp.jpg";
} else {
    echo "Data masyarakat tidak ditemukan.";
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>

<div class="container mt-5" style="font-size: 0.85rem;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Profil Data Diri</h4>
                </div>
                <div class="card-body px-4 py-4">

                    <!-- Foto Profil -->
                    <div class="text-center mb-4 position-relative">
                        <img src="<?= $foto_path ?>" class="rounded-circle border bg-secondary shadow-sm" alt="Foto Profil"
                             style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                             data-toggle="modal" data-target="#fotoModal">

                        <button class="btn btn-sm btn-light shadow rounded-circle position-absolute"
                                style="top: 0; right: 30%; transform: translate(50%, -50%);"
                                data-toggle="modal" data-target="#uploadModal">
                            <i class="fas fa-camera text-primary"></i>
                        </button>
                    </div>

                    <!-- Modal Preview -->
                    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Preview Foto</h6>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="<?= $foto_path ?>" class="img-fluid rounded shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Upload -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Unggah Foto Baru</h6>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="upft.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="nik" value="<?= $nik; ?>">
                                        <div class="form-group">
                                            <label class="small">Pilih Foto</label>
                                            <input type="file" name="foto" class="form-control-file" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-sm btn-primary px-4 rounded-pill">
                                                Upload
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Profil -->
                    <table class="table table-bordered mt-4">
                        <tbody>
                            <tr>
                                <th scope="row" class="col-4">ID Masyarakat</th>
                                <td><?= $nik; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Username</th>
                                <td><?= $username; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Nama</th>
                                <td><?= $nama; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Telepon</th>
                                <td><?= $telp; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Password</th>
                                <td><?= $password; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Quote -->
                    <div class="text-center text-muted small mt-3">
                        "Mari bersama ciptakan lingkungan yang nyaman dan tentram."
                    </div>

                    <!-- Tombol Navigasi -->
                    <div class="text-center mt-4">
                        <a href="masyarakat.php" class="btn btn-sm btn-outline-secondary rounded-pill px-4 mr-2">Kembali</a>
                        <a href="?url=edit" class="btn btn-sm btn-success rounded-pill px-4">Edit Profil</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
