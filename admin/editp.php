<?php

// Koneksi ke database
include '../koneksi.php';

// Query to fetch petugas data based on session ID
$sql = "SELECT * FROM petugas WHERE id_petugas";
$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_petugas = $row['id_petugas'];
    $nama_petugas = htmlspecialchars($row['nama_petugas']);
    $username = htmlspecialchars($row['username']);
    $telp = htmlspecialchars($row['telp']);
    $level = htmlspecialchars($row['level']); // Assuming 'level' is a field in your 'petugas' table
} else {
    echo "Data petugas tidak ditemukan.";
    exit();
}

// Menutup koneksi
mysqli_close($koneksi);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card small">
                <div class="card-header text-center">
                <div class="d-flex justify-content-between align-items-center">
                <div class="col-3 p-0">
                    <div class="d-flex justify-content-start">
                        <a href="?url=profil" class="btn btn-primary btn-icon-split text-left">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Kembali</span>
                            </a>
                        </div>
                    </div>

                    <h4 class="m-0 font-weight-bold text-primary mx-auto">Edit Profil</h4>
                    <div class="col-3"></div> <!-- Placeholder untuk menjaga space -->
                </div>
                </div>
                <div class="card-body">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id_petugas" value="<?= $id_petugas; ?>">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $username; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_petugas">Nama Petugas</label>
                            <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" value="<?= $nama_petugas; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telp">Telepon</label>
                            <input type="int" class="form-control" id="telp" name="telp" value="<?= $telp; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="level">Status</label>
                            <input type="text" class="form-control" id="level" name="level" value="<?= $level; ?>" readonly>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
