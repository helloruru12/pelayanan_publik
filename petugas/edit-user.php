<?php
include '../koneksi.php';

if (!isset($_GET['nik'])) {
    echo "<script>alert('NIK tidak ditemukan!'); window.location.href='petugas.php?url=lihat-pengajuan';</script>";
    exit;
}

$nik = $_GET['nik'];
$query = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE nik='$nik'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data user tidak ditemukan!'); window.location.href='petugas.php?url=lihat-pengajuan';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $telp = $_POST['telp'];

    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "../foto_user/" . $foto);
    } else {
        $foto = $data['foto'];
    }

    $update = mysqli_query($koneksi, "UPDATE masyarakat SET 
        nama='$nama', 
        username='$username', 
        password='$password', 
        telp='$telp', 
        foto='$foto' 
        WHERE nik='$nik'");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href='petugas.php?url=lihat-pengajuan';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-size: 0.95rem;
        }

        .card {
            max-width: 600px;
            margin: 30px auto;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.1rem rgba(0,123,255,.25);
        }

        .custom-file-input ~ .custom-file-label::after {
            content: "Browse";
        }

        .btn-success, .btn-secondary {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="card shadow border-0 rounded-lg">
    <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
        <a href="petugas.php?url=lihat-pengajuan" class="btn btn-sm btn-light text-primary rounded-pill px-3 shadow-sm">
            ← Kembali
        </a>
        <span class="font-weight-bold">Edit Data User</span>
    </div>

    <div class="card-body bg-white px-4 py-3">
        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="text-muted">NIK</label>
                <input type="text" class="form-control form-control-sm bg-light" value="<?= $data['nik']; ?>" readonly>
            </div>

            <div class="form-group">
                <label class="text-muted">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control form-control-sm bg-light" value="<?= $data['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label class="text-muted">Username</label>
                <input type="text" name="username" class="form-control form-control-sm bg-light" value="<?= $data['username']; ?>" required>
            </div>

            <div class="form-group">
                <label class="text-muted">Password</label>
                <input type="text" name="password" class="form-control form-control-sm bg-light" value="<?= $data['password']; ?>" required>
            </div>

            <div class="form-group">
                <label class="text-muted">No. Telepon</label>
                <input type="text" name="telp" class="form-control form-control-sm bg-light" value="<?= $data['telp']; ?>" required>
            </div>

            <div class="form-group">
                <label class="text-muted">Foto</label><br>
                <?php if ($data['foto']) { ?>
                    <img src="../foto_user/<?= $data['foto']; ?>" class="img-thumbnail mb-2" width="100"><br>
                <?php } ?>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                    <label class="custom-file-label" for="foto">Pilih file...</label>
                </div>
            </div>

            <div class="form-group text-right mb-0 mt-4">
                <button type="submit" name="update" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
                <a href="petugas.php?url=lihat-pengajuan" class="btn btn-secondary btn-sm px-4 rounded-pill shadow-sm">
                    <i class="fas fa-times mr-1"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>

<!-- Script agar nama file muncul -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.querySelector('.custom-file-input');
        fileInput.addEventListener('change', function () {
            const fileName = this.files[0]?.name || 'Pilih file...';
            this.nextElementSibling.innerText = fileName;
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
