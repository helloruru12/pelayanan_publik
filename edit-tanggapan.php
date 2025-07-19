<?php
include 'koneksi.php';

if (!isset($_SESSION['nik']) || !isset($_GET['id'])) {
    echo "<script>alert('Anda harus login terlebih dahulu.'); window.location = 'login.php';</script>";
    exit();
}

$id_pengaduan = $_GET['id'];
$sql = "SELECT * FROM pengaduan WHERE id_pengaduan = '$id_pengaduan' AND nik = '{$_SESSION['nik']}'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Pengaduan tidak ditemukan.'); window.location = 'masyarakat.php?url=lihat-pengaduan';</script>";
    exit();
}
?>

<div class="container mt-4" style="font-size: 0.85rem;">
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
            <a href="?url=lihat-pengaduan" class="btn btn-sm btn-light text-primary rounded-pill px-3 shadow-sm">
                ← Kembali
            </a>
            <span class="font-weight-bold">Edit Pengaduan</span>
        </div>
        <div class="card-body bg-white px-4 py-3">

            <form method="post" action="proses-edit-tanggapan.php">
                <input type="hidden" name="id_pengaduan" value="<?= $data['id_pengaduan']; ?>">

                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Tanggal Pengaduan</label>
                    <input type="text" name="tgl_pengaduan" class="form-control form-control-sm bg-light" value="<?= $data['tgl_pengaduan']; ?>" readonly>
                </div>

                <!-- ✅ Jenis Pengaduan -->
                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Jenis Pengaduan</label>
                    <select name="jenis_pengaduan" class="form-control form-control-sm bg-light" required>
                        <option value="Keamanan" <?= $data['jenis_pengaduan'] == 'Keamanan' ? 'selected' : ''; ?>>Keamanan</option>
                        <option value="Kesehatan" <?= $data['jenis_pengaduan'] == 'Kesehatan' ? 'selected' : ''; ?>>Kesehatan</option>
                        <option value="Fasilitas" <?= $data['jenis_pengaduan'] == 'Fasilitas' ? 'selected' : ''; ?>>Fasilitas</option>
                        <option value="Kebersihan" <?= $data['jenis_pengaduan'] == 'Kebersihan' ? 'selected' : ''; ?>>Kebersihan</option>
                        <option value="Sosial" <?= $data['jenis_pengaduan'] == 'Sosial' ? 'selected' : ''; ?>>Sosial</option>
                        <option value="Kesejahteraan" <?= $data['jenis_pengaduan'] == 'Kesejahteraan' ? 'selected' : ''; ?>>Kesejahteraan</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="text-muted font-weight-semibold mb-1">Isi Laporan</label>
                    <textarea name="isi_laporan" class="form-control form-control-sm bg-light" rows="4" required><?= $data['isi_laporan']; ?></textarea>
                </div>

                <div class="form-group text-right mb-0">
                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

