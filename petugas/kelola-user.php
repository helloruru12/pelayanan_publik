<div class="m-4 small" style="font-size: 0.85rem;">
    <!-- Data User -->
    <div class="card shadow border-0 rounded-lg mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2 px-3">
            <h6 class="m-0 font-weight-bold text-sm">
                <i class="fas fa-users mr-2"></i> Data User
            </h6>
        </div>

        <div class="card-body bg-white px-3 py-2">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered align-middle mb-0 text-center" id="dataTableUser" width="100%">
                    <thead class="bg-light text-success text-sm">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th style="width: 120px;">NIK</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th style="width: 100px;">Telp</th>
                            <th style="width: 100px;">Foto</th>
                            <th style="width: 130px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-secondary text-sm">
                        <?php
                        include '../koneksi.php';
                        $sql = "SELECT * FROM masyarakat ORDER BY nik DESC";
                        $query = mysqli_query($koneksi, $sql);
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nik']; ?></td>
                            <td class="text-left"><?= $data['nama']; ?></td>
                            <td><?= $data['username']; ?></td>
                            <td><?= str_repeat('*', strlen($data['password'])); ?></td>
                            <td><?= $data['telp']; ?></td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#modalFotoUser<?= $data['nik']; ?>">
                                    <img src="../foto_user/<?= $data['foto']?>" class="img-thumbnail rounded shadow-sm" style="width: 75px;">
                                </a>
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="edit-user.php?nik=<?= $data['nik'] ?>" class="btn btn-sm btn-outline-warning rounded-pill shadow-sm w-100 mb-1 text-sm">
                                    <i class="fas fa-edit"></i> Ubah
                                </a>

                                <!-- Tombol Hapus -->
                                <button class="btn btn-sm btn-outline-danger rounded-pill shadow-sm w-100 text-sm" data-toggle="modal" data-target="#modalHapus<?= $data['nik']; ?>">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Foto -->
                        <div class="modal fade" id="modalFotoUser<?= $data['nik']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalFotoUserLabel<?= $data['nik']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white py-2 px-3">
                                        <h6 class="modal-title text-sm" id="modalFotoUserLabel<?= $data['nik']; ?>">Foto User</h6>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body bg-light text-center">
                                        <img src="../foto_user/<?= $data['foto']; ?>" class="img-fluid rounded shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="modalHapus<?= $data['nik']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel<?= $data['nik']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white py-2 px-3">
                                        <h6 class="modal-title text-sm" id="modalHapusLabel<?= $data['nik']; ?>">Konfirmasi Hapus</h6>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <p class="text-sm">Yakin ingin menghapus user <strong><?= $data['nama']; ?></strong>?</p>
                                        <a href="hapus_user.php?nik=<?= $data['nik']; ?>" class="btn btn-sm btn-danger">Ya, Hapus</a>
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
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
