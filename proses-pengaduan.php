<?php
session_start();
include 'koneksi.php';

// Ambil data dari form
$tgl_pengaduan   = $_POST['tgl_pengaduan'];
$nik             = $_SESSION['nik'];
$jenis_pengaduan = $_POST['jenis_pengaduan'];
$isi_laporan     = $_POST['isi_laporan'];
$estimasi        = $_POST['estimasi_penanganan']; // ✅ Ambil estimasi dari form
$lokasi_foto     = $_FILES['foto']['tmp_name'];
$nama_foto       = $_FILES['foto']['name'];
$status          = 0;

// Simpan ke database (sementara foto dikosongkan)
$sql = "INSERT INTO pengaduan (tgl_pengaduan, nik, jenis_pengaduan, isi_laporan, foto, status, estimasi_penanganan) 
        VALUES ('$tgl_pengaduan', '$nik', '$jenis_pengaduan', '$isi_laporan', '', '$status', '$estimasi')";

if (mysqli_query($koneksi, $sql)) {
    $id_pengaduan = mysqli_insert_id($koneksi); // Ambil ID baru

    // Rename foto agar unik berdasarkan ID
    $ekstensi = pathinfo($nama_foto, PATHINFO_EXTENSION);
    $nama_foto_baru = 'd' . $id_pengaduan . '.' . $ekstensi;

    // Pindahkan file
    if (move_uploaded_file($lokasi_foto, 'img/doc/' . $nama_foto_baru)) {
        // Update nama file di database
        $sql_update = "UPDATE pengaduan SET foto='$nama_foto_baru' WHERE id_pengaduan='$id_pengaduan'";
        mysqli_query($koneksi, $sql_update);

        echo "<script>alert('Pengaduan Sudah Tersimpan'); window.location.assign('masyarakat.php?url=lihat-pengaduan');</script>";
    } else {
        echo "<script>alert('Upload foto gagal'); window.location.assign('masyarakat.php?url=tulis-pengaduan');</script>";
    }
} else {
    echo "<script>alert('Pengaduan Gagal Tersimpan'); window.location.assign('masyarakat.php?url=tulis-pengaduan');</script>";
}
?>