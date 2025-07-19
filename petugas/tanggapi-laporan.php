<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];

    // Ambil data pengaduan
    $sql_detail = "SELECT * FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'";
    $query_detail = mysqli_query($koneksi, $sql_detail);
    $data_detail = mysqli_fetch_assoc($query_detail);

    // Cek apakah sudah ada tanggapan
    $cek_tanggapan = mysqli_query($koneksi, "SELECT * FROM tanggapan WHERE id_pengaduan = '$id_pengaduan'");
    $data_tanggapan = mysqli_fetch_assoc($cek_tanggapan);

    // Tangani form submit
    if (isset($_POST['tanggapan'])) {
        $tanggapan = $_POST['tanggapan'];
        $status = $_POST['status'];
        $tgl_tanggapan = date('Y-m-d H:i:s');
        $id_petugas = $_SESSION['id_petugas']; // pastikan session login ada

        // Update status pengaduan
        $update_pengaduan = mysqli_query($koneksi, "UPDATE pengaduan SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'");

        if ($data_tanggapan) {
            // Edit tanggapan jika sudah ada
            $update_tanggapan = mysqli_query($koneksi, "UPDATE tanggapan SET tanggapan='$tanggapan', tgl_tanggapan='$tgl_tanggapan', id_petugas='$id_petugas' WHERE id_pengaduan='$id_pengaduan'");
        } else {
            // Simpan tanggapan baru
            $insert_tanggapan = mysqli_query($koneksi, "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas)
                VALUES ('$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')");
        }

        echo "<script>alert('Tanggapan berhasil disimpan.'); window.location.href='?url=lihat-laporan';</script>";
        exit;
    }
}
?>

<!-- Form Tanggapan -->
<div class="card shadow my-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="?url=lihat-laporan" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50"><i class="fa fa-arrow-left"></i></span>
                <span class="text"> Kembali </span>
            </a>
            <h4 class="m-0 font-weight-bold text-primary mx-auto">Tanggapan Pengaduan</h4>
            <div></div>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="">
            <div class="form-group">
                <label for="isi_laporan" class="small">Isi Laporan:</label>
                <textarea class="form-control" id="isi_laporan" rows="3" readonly><?= $data_detail['isi_laporan']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="tanggapan" class="small">Tanggapan:</label>
                <textarea class="form-control" id="tanggapan" name="tanggapan" rows="3" required><?= $data_tanggapan['tanggapan'] ?? ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="status" class="small">Status Pengaduan:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="proses" <?= ($data_detail['status'] == 'proses' ? 'selected' : '') ?>>Proses</option>
                    <option value="selesai" <?= ($data_detail['status'] == 'selesai' ? 'selected' : '') ?>>Selesai</option>
                    <option value="tolak" <?= ($data_detail['status'] == 'tolak' ? 'selected' : '') ?>>Tolak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Tanggapan</button>
        </form>
    </div>
</div>
