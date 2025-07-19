<div class="m-4 small" style="font-size: 0.85rem;">
    <div class="card shadow border-0 rounded-lg mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2 px-3">
            <h6 class="m-0 font-weight-bold text-sm">
                <i class="fas fa-bullhorn mr-2"></i> Daftar Pengaduan Anda
            </h6>
        </div>

        <div class="card-body bg-white px-3 py-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered align-middle mb-0 text-center" id="dataTable" width="100%">
                    <thead class="bg-light text-primary text-sm">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th style="width: 100px;">Tanggal</th>
                            <th style="width: 120px;">Jenis</th>
                            <th style="width: 150px;">Estimasi Penanganan</th>
                            <th>Isi Laporan</th>
                            <th style="width: 100px;">Foto</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-secondary text-sm">
                        <?php
                        include 'koneksi.php';
                        $nik = $_SESSION['nik'];
                        $sql = "SELECT * FROM pengaduan WHERE nik = '$nik' ORDER BY id_pengaduan DESC";
                        $query = mysqli_query($koneksi, $sql);
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['tgl_pengaduan']; ?></td>
                            <td><span class="badge badge-info px-2 py-1"><?= $data['jenis_pengaduan']; ?></span></td>
                            <td><?= $data['estimasi_penanganan'] ?? '-' ?></td>
                            <td class="text-left"><?= nl2br(htmlspecialchars($data['isi_laporan'])); ?></td>
                            <td>
                                <?php if (!empty($data['foto'])) { ?>
                                    <a href="#" data-toggle="modal" data-target="#modalFoto<?= $data['id_pengaduan']; ?>">
                                        <img src="img/doc/<?= $data['foto']; ?>" class="img-thumbnail rounded shadow-sm" style="width: 85px;">
                                    </a>
                                <?php } else { ?>
                                    <span class="text-muted">-</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                switch ($data['status']) {
                                    case 'proses':
                                        echo '<span class="badge badge-warning text-dark px-2 py-1 text-sm">Sedang diproses</span>';
                                        break;
                                    case 'selesai':
                                        echo '<span class="badge badge-success text-white px-2 py-1 text-sm">Selesai</span>';
                                        break;
                                    case 'tolak':
                                        echo '<span class="badge badge-danger text-white px-2 py-1 text-sm">Ditolak</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-light border text-muted px-2 py-1 text-sm">Belum diproses</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($data['status'] == 'belum diproses' || $data['status'] == '') { ?>
                                    <a href="?url=edit-tanggapan&id=<?= $data['id_pengaduan'] ?>" class="btn btn-sm btn-outline-warning rounded-pill shadow-sm w-100 mb-1 text-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                <?php } else { ?>
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
                                        <img src="img/doc/<?= $data['foto']; ?>" class="img-fluid rounded shadow-sm">
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
