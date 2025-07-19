<?php
include '../koneksi.php';

if (!isset($_GET['nik'])) {
    echo "<script>alert('NIK tidak ditemukan!'); window.location.href='petugas.php?url=lihat-pengajuan';</script>";
    exit;
}

$nik = $_GET['nik'];

// Ambil data user untuk mendapatkan nama file foto
$query = mysqli_query($koneksi, "SELECT * FROM masyarakat WHERE nik='$nik'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data user tidak ditemukan!'); window.location.href='petugas.php?url=lihat-pengajuan';</script>";
    exit;
}

// Hapus foto jika ada
if (!empty($data['foto']) && file_exists("../profil/" . $data['foto'])) {
    unlink("../profil/" . $data['foto']);
}

// Hapus data dari database
$hapus = mysqli_query($koneksi, "DELETE FROM masyarakat WHERE nik='$nik'");

if ($hapus) {
    echo "<script>alert('Data berhasil dihapus'); window.location.href='petugas.php?url=lihat-user';</script>";
} else {
    echo "<script>alert('Gagal menghapus data'); window.location.href='petugas.php?url=lihat-user';</script>";
}
?>
