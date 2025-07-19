<div class="container mt-4">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Pengaduan</h6>
        </div>
        <div class="card-body" style="font-size: 14px">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Isi Laporan</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../koneksi.php';
                        $sql = "SELECT * FROM pengaduan ORDER BY id_pengaduan DESC";
                        $query = mysqli_query($koneksi, $sql);
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['tgl_pengaduan']; ?></td>
                            <td><?= $data['isi_laporan']; ?></td>
                            <td class="col-2">
                                <a href="#" data-toggle="modal" data-target="#modalFoto<?= $data['id_pengaduan']; ?>">
                                    <img class="img-thumbnail" src="../img/doc/<?= $data['foto']?>" width="600">
                                </a>
                            </td>
                            <td>
                                <?php
                                switch ($data['status']) {
                                    case 0:
                                        echo "Belum diproses";
                                        break;
                                    case 1:
                                        echo "Sedang diproses";
                                        break;
                                    case 2:
                                        echo "Selesai";
                                        break;
                                    default:
                                        echo "Status tidak valid";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($data['status'] == 1 || $data['status'] == 2) { ?>
                                    <!-- Tombol Tanggapan -->
                                    <a href="?url=lihat-tanggapan&id=<?= $data['id_pengaduan'] ?>" class="btn btn-primary btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-comments"></i>
                                        </span>
                                        <span class="text">Tanggapan</span>
                                    </a>
                                <?php } ?>
                                
                                <!-- Tombol Hapus -->
                                <a href="#" data-toggle="modal" data-target="#modalHapus<?= $data['id_pengaduan']; ?>" class="btn btn-danger btn-icon-split mt-2 btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Hapus</span>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Foto -->
                        <div class="modal fade" id="modalFoto<?= $data['id_pengaduan']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalFotoLabel<?= $data['id_pengaduan']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalFotoLabel<?= $data['id_pengaduan']; ?>">Preview Foto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="../img/doc/<?= $data['foto']; ?>" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Foto -->

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus<?= $data['id_pengaduan']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel<?= $data['id_pengaduan']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalHapusLabel<?= $data['id_pengaduan']; ?>">Konfirmasi Hapus</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus pengaduan ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a href="hapus.php?id=<?= $data['id_pengaduan']; ?>" class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Hapus -->

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
