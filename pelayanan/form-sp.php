<div class="card shadow m-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pelayanan Masyarakat - Formulir Surat Pengantar</h6>
    </div>
    <div class="card-body" style="font-size: 14px;">
        <div class="">
            <div class="col-md-6 mb-4">
                <a href="masyarakat.php" class="btn-icon-split ">
                    <span class="text p-0">Kembali</span>
                </a>
            </div>
            <h3 class="text-center mb-4 h5 col-md-6">Formulir Surat Pengantar</h3>
            <div class="col-md-6">
                <form id="formSKCK" method="POST" action="pelayanan/sp.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nik">NIK (Nomor Induk Kependudukan) :</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik; ?>" readonly required>
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
                        <label for="urusan">Keperluan :</label>
                        <input type="text" class="form-control" id="urusan" name="urusan" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Nomor Telpon :</label>
                        <input type="number" class="form-control" id="nomor" name="nomor" required>
                    </div>
                    <div class="form-group">
                        <label for="foto_ktp">Foto KTP ( terbaru):</label>
                        <input type="file" class="form-control-file" id="foto_ktp" name="foto_ktp" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group">
                        <label for="foto_kk">Foto KK (Kartu Keluarga):</label>
                        <input type="file" class="form-control-file" id="foto_kk" name="foto_kk" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary">Ajukan Surat Pengantar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>