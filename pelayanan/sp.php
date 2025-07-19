<?php
session_start();
include '../koneksi.php';

// Ambil data dari formulir
$tgl_pengaduan = date('Y-m-d');
$nik           = $_POST['nik'];
$nama          = $_POST['nama'];
$alamat        = $_POST['alamat'];
$urusan        = $_POST['urusan'];
$nomor         = $_POST['nomor'];
$lokasi_fc_kk  = $_FILES['foto_kk']['tmp_name'];
$nama_fc_kk    = $_FILES['foto_kk']['name'];
$lokasi_fc_ktp = $_FILES['foto_ktp']['tmp_name'];
$nama_fc_ktp   = $_FILES['foto_ktp']['name'];

// Simpan data surat pengantar ke tabel pengantar
$sql = "INSERT INTO pengantar (tgl_pengaduan, nik, nama, alamat, urusan, nomor, fc_kk, fc_ktp)
        VALUES ('$tgl_pengaduan', '$nik', '$nama', '$alamat', '$urusan', '$nomor', '', '')";

if (mysqli_query($koneksi, $sql)) {
    // Ambil ID pengaduan yang baru saja dimasukkan
    $id_pengantar = mysqli_insert_id($koneksi);

    // Buat nama file baru untuk FC KK dan FC KTP berdasarkan ID pengantar
    $nama_fc_kk_baru = 'fc_kk_' . $id_pengantar . '_' . $nik . '.jpg';
    $nama_fc_ktp_baru = 'fc_ktp_' . $id_pengantar . '_' . $nik . '.jpg';

    // Pindahkan file FC KK dan FC KTP ke folder 'img/data/'
    if (move_uploaded_file($lokasi_fc_kk, '../img/data/' . $nama_fc_kk_baru) &&
        move_uploaded_file($lokasi_fc_ktp, '../img/data/' . $nama_fc_ktp_baru)) {

        // Update nama file FC KK dan FC KTP di database
        $sql_update = "UPDATE pengantar SET fc_kk='$nama_fc_kk_baru', fc_ktp='$nama_fc_ktp_baru' WHERE id='$id_pengantar'";
        mysqli_query($koneksi, $sql_update);
        
        // Redirect ke halaman masyarakat.php dengan pesan sukses
        echo "<script>alert('Formulir surat pengantar berhasil diajukan, untuk info lebih lanjut akan kami infokan melalui whatsapp. Terimakasih.'); window.location.href = '/pelayanan_publik/masyarakat.php';</script>";
        exit();
    } else {
        // Jika gagal mengunggah file, tampilkan pesan error dan redirect ke halaman masyarakat.php
        echo "<script>alert('Gagal mengunggah file FC KK atau FC KTP'); window.location.href = '/pelayanan_publik/masyarakat.php';</script>";
    }
} else {
    // Jika gagal menyimpan data ke database, tampilkan pesan error dan redirect ke halaman masyarakat.php
    echo "<script>alert('Gagal menyimpan data pengaduan'); window.location.href = '/pelayanan_publik/masyarakat.php';</script>";
}
?>
