<?php
// Check if session variables are set
if (!isset($_SESSION['id_petugas'])) {
    echo "Session id_petugas not set.";
    exit();
}

// Koneksi ke database
include '../koneksi.php';

// Ambil data petugas dari database berdasarkan id_petugas dari session
$id_petugas = $_SESSION['id_petugas'];
$sql = "SELECT * FROM petugas WHERE id_petugas = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_petugas);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_petugas = $row['id_petugas'];
    $nama_petugas = $row['nama_petugas'];
    $username = $row['username'];
    $telp = $row['telp'];
    $level = $row['level'];

    // Ambil foto profil
    if ($row['foto']) {
        $foto_path = "../img/profil/" . $row['foto'];
    } else {
        $foto_path = "../img/profil/pp.jpg"; // Foto default jika tidak ada foto profil
    }
} else {
    echo "Data petugas tidak ditemukan.";
    exit();
}

// Menutup koneksi
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>

<!-- Your HTML content with PHP variables -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card small">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Profil Data Diri</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="profile-picture-wrapper">
                            <img src="<?= $foto_path ?>" class="rounded-circle border bg-secondary" alt="Foto Profil" style="width: 150px; height: 150px; cursor: pointer;" data-toggle="modal" data-target="#fotoModal">
                            <button class="btn btn-upload btn-outline-light shadow" style="width: 30px; height: 30px;" data-toggle="modal" data-target="#uploadModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <!-- Modal for previewing profile picture -->
                        <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="fotoModalLabel">Preview Foto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="<?= $foto_path ?>" class="img-fluid rounded" alt="Pratinjau Foto Profil">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for uploading profile picture -->
                        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploadModalLabel">Unggah Foto Profil</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" data-placement="top" title="Ganti foto">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="upft.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="id_petugas" value="<?= $id_petugas; ?>">
                                            <div class="form-group">
                                                <label for="foto">Pilih Foto</label>
                                                <input type="file" class="form-control-file" id="foto" name="foto" required>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary" name="submit">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display profile information -->
                    <div class="profile-info">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" class="col-4">ID Petugas</th>
                                    <td><?= $id_petugas; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Username</th>
                                    <td><?= $username; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Petugas</th>
                                    <td><?= $nama_petugas; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Telepon</th>
                                    <td><?= $telp; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td><?= $level; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <p>"Bekerja dengan tekad dan keikhlasan untuk menciptakan keamanan dan kenyamanan bagi masyarakat."</p>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="petugas.php" class="btn btn-primary mr-2">Kembali</a>
                        <a href="?url=edit" class="btn btn-success mr-2">Edit Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
