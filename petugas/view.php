<?php
include '../koneksi.php';
require_once('tcpdf/tcpdf.php');

$id = $_GET['id'];
$jenis = $_GET['jenis'];

if ($jenis == 'skck') {
    $query = "SELECT * FROM skck WHERE id='$id'";
    $fotoFields = ['fc_kk', 'fc_ktp', 'fc_akte', 'pas_foto'];
} else {
    $query = "SELECT * FROM pengantar WHERE id='$id'";
    $fotoFields = ['fc_kk', 'fc_ktp'];
}

$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

// Membuat file PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Detail Pengaduan');
$pdf->SetSubject('Detail Pengaduan');
$pdf->SetKeywords('TCPDF, PDF, pengaduan, detail');

$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Detail Pengaduan', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 10);

foreach ($data as $key => $value) {
    if (in_array($key, $fotoFields)) {
        // Jika field merupakan field foto, tambahkan gambar ke halaman PDF
        $pdf->AddPage(); // Buat halaman baru untuk setiap foto
        $pdf->Cell(0, 10, ucwords(str_replace('_', ' ', $key)), 0, 1, 'C');
        $pdf->Image('../img/data/' . $value, 15, 30, 180, 180); // Atur posisi dan dimensi gambar sesuai kebutuhan
    } else {
        // Jika bukan field foto, tampilkan sebagai teks biasa
        $pdf->Cell(40, 10, ucwords(str_replace('_', ' ', $key)), 1);
        $pdf->Cell(150, 10, $value, 1, 1);
    }
}

$pdf->Output('pengaduan_' . $id . '.pdf', 'I');

?>
