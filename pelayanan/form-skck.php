<div class="card shadow m-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pelayanan Masyarakat - Formulir SKCK</h6>
    </div>
    <div class="card-body" style="font-size: 14px;">
        <div class="">
            <div class="col-md-6 mb-4">
                <a href="masyarakat.php" class="btn-icon-split ">
                    <span class="text p-0">Kembali</span>
                </a>
            </div>
            <h3 class="text-center mb-4 h5 col-md-6">Formulir SKCK</h3>
            <div class="col-md-6">
                <form id="formSKCK" method="POST" action="pelayanan/skck.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nik">NIK (Nomor Induk Kependudukan) :</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $_SESSION['nik']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap :</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat :</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Nomor Telpon :</label>
                        <input type="tel" class="form-control" id="nomor" name="nomor" required>
                    </div>
                    <div class="form-group">
                        <label for="fc_kk">FC KK (Fotocopy Kartu Keluarga):</label>
                        <input type="file" class="form-control-file" id="fc_kk" name="fc_kk" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group">
                        <label for="fc_ktp">FC KTP (Fotocopy KTP):</label>
                        <input type="file" class="form-control-file" id="fc_ktp" name="fc_ktp" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group">
                        <label for="fc_akte">FC Akte/Ijazah Terakhir:</label>
                        <input type="file" class="form-control-file" id="fc_akte" name="fc_akte" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group">
                        <label for="pas_foto">Pas Foto 4x6 (Background Merah, 4 Lembar):</label>
                        <input type="file" class="form-control-file" id="pas_foto" name="pas_foto" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary">Ajukan SKCK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
