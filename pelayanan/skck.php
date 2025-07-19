<?php
session_start();
include '../koneksi.php';

$tgl_pengaduan = date('Y-m-d'); // Tanggal pengaduan diambil dari waktu saat ini
$nik           = $_POST['nik']; // Mengambil NIK dari session yang sudah diset saat login
$nama          = $_POST['nama'];
$alamat        = $_POST['alamat'];
$nomor         = $_POST['nomor'];
$lokasi_fc_kk  = $_FILES['fc_kk']['tmp_name'];
$nama_fc_kk    = $_FILES['fc_kk']['name'];
$lokasi_fc_ktp = $_FILES['fc_ktp']['tmp_name'];
$nama_fc_ktp   = $_FILES['fc_ktp']['name'];
$lokasi_fc_akte = $_FILES['fc_akte']['tmp_name'];
$nama_fc_akte   = $_FILES['fc_akte']['name'];
$lokasi_pas_foto = $_FILES['pas_foto']['tmp_name'];
$nama_pas_foto   = $_FILES['pas_foto']['name'];

// Simpan data pengaduan ke tabel skck
$sql = "INSERT INTO skck (tgl_pengaduan, nik, nama, alamat, nomor, fc_kk, fc_ktp, fc_akte, pas_foto)
        VALUES ('$tgl_pengaduan', '$nik', '$nama', '$alamat', '$nomor', '', '', '', '')";

if (mysqli_query($koneksi, $sql)) {
    // Ambil ID pengaduan yang baru saja dimasukkan
    $id_skck = mysqli_insert_id($koneksi);

    // Buat nama file baru untuk FC KK, FC KTP, FC Akte, dan Pas Foto berdasarkan ID skck dan NIK
    $nama_fc_kk_baru = 'fc_kk_' . $id_skck . '_' . $nik . '.jpg';
    $nama_fc_ktp_baru = 'fc_ktp_' . $id_skck . '_' . $nik . '.jpg';
    $nama_fc_akte_baru = 'fc_akte_' . $id_skck . '_' . $nik . '.jpg';
    $nama_pas_foto_baru = 'pas_foto_' . $id_skck . '_' . $nik . '.jpg';

    // Pindahkan file FC KK, FC KTP, FC Akte, dan Pas Foto ke folder 'img/data/'
    if (move_uploaded_file($lokasi_fc_kk, '../img/data/' . $nama_fc_kk_baru) &&
        move_uploaded_file($lokasi_fc_ktp, '../img/data/' . $nama_fc_ktp_baru) &&
        move_uploaded_file($lokasi_fc_akte, '../img/data/' . $nama_fc_akte_baru) &&
        move_uploaded_file($lokasi_pas_foto, '../img/data/' . $nama_pas_foto_baru)) {

        // Update nama file FC KK, FC KTP, FC Akte, dan Pas Foto di database
        $sql_update = "UPDATE skck SET fc_kk='$nama_fc_kk_baru', fc_ktp='$nama_fc_ktp_baru', fc_akte='$nama_fc_akte_baru', pas_foto='$nama_pas_foto_baru' WHERE id='$id_skck'";
        mysqli_query($koneksi, $sql_update);
        
        // Redirect ke halaman masyarakat.php dengan pesan sukses
        echo "<script>alert('Formulir SKCK berhasil diajukan, untuk info lebih lanjut akan kami infokan melalui whatsapp. Terimakasih.'); window.location.href = '/pelayanan_publik/masyarakat.php';</script>";
        exit();
    } else {
        // Jika gagal mengunggah salah satu file, tampilkan pesan error dan redirect ke halaman tulis-skck
        echo "<script>alert('Gagal mengunggah file FC KK, FC KTP, FC Akte, atau Pas Foto'); window.location.href = '/pelayanan_publik/masyarakat.php';</script>";
    }
} else {
    // Jika gagal menyimpan data ke database, tampilkan pesan error dan redirect ke halaman tulis-skck
    echo "<script>alert('Gagal menyimpan data pengaduan'); window.location.href = '/pelayanan_publik/masyarakat.php';</script>";
}
?>
