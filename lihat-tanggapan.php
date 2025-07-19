<?php
$id = $_GET['id'];
if (empty($id)) {
    header("Location: masyarakat.php");
    exit;
}

include 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM pengaduan, tanggapan WHERE tanggapan.id_pengaduan='$id' AND tanggapan.id_pengaduan=pengaduan.id_pengaduan");
?>

<div class="card shadow-sm border-0 rounded-lg m-4 small" style="font-size: 0.85rem;">
    <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
        <a href="?url=lihat-pengaduan" class="btn btn-sm btn-light text-primary rounded-pill px-3 shadow-sm">
            ← Kembali
        </a>
        <span class="font-weight-bold">Detail Tanggapan</span>
    </div>

    <div class="card-body bg-white px-4 py-3">
        <?php if (mysqli_num_rows($query) == 0): ?>
            <div class="alert alert-warning text-center mb-0">
                <i class="fas fa-exclamation-circle mr-2"></i> Maaf, tanggapan Anda belum tersedia.
            </div>
        <?php else:
            $data = mysqli_fetch_array($query); ?>

            <form method="post" action="proses-pengaduan.php" enctype="multipart/form-data">

                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Tanggal Tanggapan</label>
                    <input type="text" name="tgl_tanggapan" class="form-control form-control-sm bg-light" readonly
                           value="<?= $data['tgl_tanggapan']; ?>">
                </div>

                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Tanggapan</label>
                    <textarea name="tanggapan" class="form-control form-control-sm bg-light" rows="3" readonly><?= $data['tanggapan']; ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Isi Laporan</label>
                    <textarea name="isi_laporan" class="form-control form-control-sm bg-light" rows="3" readonly><?= $data['isi_laporan']; ?></textarea>
                </div>

                <div class="form-group mb-0">
                    <label class="text-muted font-weight-semibold mb-1">Foto</label><br>
                    <?php if (!empty($data['foto'])): ?>
                        <img src="img/doc/<?= $data['foto']; ?>" class="img-fluid rounded shadow-sm mt-2" style="max-width: 300px;" alt="Foto Pengaduan">
                    <?php else: ?>
                        <p class="text-muted mt-2">Foto tidak tersedia</p>
                    <?php endif; ?>
                </div>

            </form>
        <?php endif; ?>
    </div>
</div>
