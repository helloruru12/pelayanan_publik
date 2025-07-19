<?php
// Koneksi ke database
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_petugas = $_POST['id_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $telp = $_POST['telp'];
    $level = $_POST['level'];
    
    // Query update data petugas
    $sql = "UPDATE petugas SET nama_petugas='$nama_petugas', telp='$telp', level='$level' WHERE id_petugas='$id_petugas'";

    if (mysqli_query($koneksi, $sql)) {
        // Jika berhasil diupdate, redirect ke halaman profil dengan pesan sukses
        mysqli_close($koneksi);
        header("Location: admin.php?url=profil");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Menutup koneksi
mysqli_close($koneksi);
?>
