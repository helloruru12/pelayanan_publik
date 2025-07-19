<div class="">
    <div class="card shadow-sm border-0 rounded-lg m-4 small" style="font-size: 0.85rem;">
        <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
            <a href="masyarakat.php" class="btn btn-sm btn-light text-primary rounded-pill px-3 shadow-sm">
                ← Kembali
            </a>
            <span class="font-weight-bold">Form Pengaduan</span>
        </div>

        <div class="card-body bg-white px-4 py-3">

            <form method="post" action="proses-pengaduan.php" enctype="multipart/form-data">

                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Tanggal Pengaduan</label>
                    <input type="text" name="tgl_pengaduan" class="form-control form-control-sm bg-light" readonly value="<?= date('Y-m-d'); ?>">
                </div>

                <!-- ✅ Tambahan: Jenis Laporan -->
                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Jenis Laporan</label>
                    <select name="jenis_pengaduan" class="form-control form-control-sm bg-light" required>
                        <option value="" disabled selected>-- Pilih Jenis Laporan --</option>
                        <option value="Keamanan">Keamanan</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Fasilitas">Fasilitas</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Sosial">Sosial</option>
                        <option value="Kesejahteraan">Kesejahteraan</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="text-muted font-weight-semibold mb-1">Isi Laporan</label>
                    <textarea name="isi_laporan" class="form-control form-control-sm bg-light" rows="3" required></textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="foto" class="text-muted font-weight-semibold mb-1">Foto</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*" required>
                        <label class="custom-file-label" for="foto">Pilih file...</label>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const fileInput = document.querySelector('.custom-file-input');
                        fileInput.addEventListener('change', function () {
                            const fileName = this.files[0]?.name || 'Pilih file...';
                            this.nextElementSibling.innerText = fileName;
                        });
                    });
                </script>

                <div class="form-group text-right mb-0">
                    <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
