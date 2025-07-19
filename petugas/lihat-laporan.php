<div class="m-4 small" style="font-size: 0.85rem;">
    <!-- Data Pengaduan -->
    <div class="card shadow border-0 rounded-lg mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2 px-3">
            <h6 class="m-0 font-weight-bold text-sm">
                <i class="fas fa-bullhorn mr-2"></i> Data Pengaduan
            </h6>
        </div>

        <div class="card-body bg-white px-3 py-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered align-middle mb-0 text-center" id="dataTable" width="100%">
                    <thead class="bg-light text-primary text-sm">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th style="width: 100px;">Tanggal</th>
                            <th>Isi Laporan</th>
                            <th style="width: 110px;">Foto</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 130px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-secondary text-sm">
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
                            <td class="text-left"><?= $data['isi_laporan']; ?></td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#modalFoto<?= $data['id_pengaduan']; ?>">
                                    <img src="../foto/<?= $data['foto']?>" class="img-thumbnail rounded shadow-sm" style="width: 85px;">
                                </a>
                            </td>
                            <td>
                                <?php
                                switch ($data['status']) {
                                    case 0:
                                        echo '<span class="badge badge-light border text-muted px-2 py-1 text-sm">Belum diproses</span>';
                                        break;
                                    case 1:
                                        echo '<span class="badge badge-warning text-dark px-2 py-1 text-sm">Sedang diproses</span>';
                                        break;
                                    case 2:
                                        echo '<span class="badge badge-success text-white px-2 py-1 text-sm">Selesai</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-danger text-sm">Tidak valid</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($data['status'] == 0) { ?>
                                    <a href="?url=tanggapi-laporan&id=<?= $data['id_pengaduan'] ?>" class="btn btn-sm btn-outline-success rounded-pill shadow-sm w-100 mb-1 text-sm">
                                        <i class="fas fa-comment"></i> Tanggapi
                                    </a>
                                <?php } elseif ($data['status'] == 1 || $data['status'] == 2) { ?>
                                    <a href="?url=lihat-tanggapan&id=<?= $data['id_pengaduan'] ?>" class="btn btn-sm btn-outline-primary rounded-pill shadow-sm w-100 text-sm">
                                        <i class="fas fa-comments"></i> Tanggapan
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>

                        <!-- Modal Foto -->
                        <div class="modal fade" id="modalFoto<?= $data['id_pengaduan']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalFotoLabel<?= $data['id_pengaduan']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white py-2 px-3">
                                        <h6 class="modal-title text-sm" id="modalFotoLabel<?= $data['id_pengaduan']; ?>">Preview Foto</h6>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body bg-light text-center">
                                        <img src="../foto/<?= $data['foto']; ?>" class="img-fluid rounded shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Foto -->

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
