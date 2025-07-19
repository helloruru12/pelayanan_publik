<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];

    // Query untuk menghapus data pengaduan
    $sql = "DELETE FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'";
    if (mysqli_query($koneksi, $sql)) {
        // Berhasil dihapus, redirect ke halaman data pengaduan
        header("Location: admin.php?url=lihat-laporan");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
} else {
    echo "ID pengaduan tidak ditemukan.";
}

// Menutup koneksi
mysqli_close($koneksi);
?>
