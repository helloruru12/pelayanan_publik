<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];

    // Ambil data pengaduan
    $sql_pengaduan = mysqli_query($koneksi, "SELECT * FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'");
    $data_pengaduan = mysqli_fetch_assoc($sql_pengaduan);

    // Ambil data tanggapan
    $sql_tanggapan = mysqli_query($koneksi, "SELECT * FROM tanggapan WHERE id_pengaduan = '$id_pengaduan'");
    $data_tanggapan = mysqli_fetch_assoc($sql_tanggapan);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tanggapan = $_POST['tanggapan'];
        $status = $_POST['status'];
        $tgl = date('Y-m-d H:i:s');
        $id_petugas = $_SESSION['id_petugas'];

        // Update tanggapan
        mysqli_query($koneksi, "UPDATE tanggapan SET tanggapan='$tanggapan', tgl_tanggapan='$tgl', id_petugas='$id_petugas' WHERE id_pengaduan='$id_pengaduan'");

        // Update status pengaduan
        mysqli_query($koneksi, "UPDATE pengaduan SET status='$status' WHERE id_pengaduan='$id_pengaduan'");

        echo "<script>alert('Tanggapan berhasil diperbarui'); window.location.href='?url=lihat-laporan';</script>";
        exit;
    }
}
?>

<!-- Form Edit Tanggapan -->
<div class="card shadow my-4">
    <div class="card-header d-flex justify-content-between align-items-center py-2 px-3 bg-primary text-white">
        <a href="?url=lihat-laporan" class="btn btn-sm btn-light text-primary rounded-pill px-3 shadow-sm">
            ← Kembali
        </a>
        <h5 class="mb-0 font-weight-bold">Edit Tanggapan</h5>
        <div></div>
    </div>

    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label class="small">Isi Laporan:</label>
                <textarea class="form-control" rows="3" readonly><?= $data_pengaduan['isi_laporan']; ?></textarea>
            </div>

            <div class="form-group">
                <label class="small">Tanggapan:</label>
                <textarea name="tanggapan" class="form-control" rows="3" required><?= $data_tanggapan['tanggapan']; ?></textarea>
            </div>

            <div class="form-group">
                <label class="small">Status Pengaduan:</label>
                <select name="status" class="form-control" required>
                    <option value="proses" <?= $data_pengaduan['status'] == 'proses' ? 'selected' : '' ?>>Proses</option>
                    <option value="selesai" <?= $data_pengaduan['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="tolak" <?= $data_pengaduan['status'] == 'tolak' ? 'selected' : '' ?>>Tolak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
