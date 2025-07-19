<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];

    // Proses form tanggapan
    if (isset($_POST['tanggapan'])) {
        $tanggapan = $_POST['tanggapan'];
        $status = $_POST['status']; // Status baru dari form

        // Update status pengaduan
        $update_sql = "UPDATE pengaduan SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'";
        if (mysqli_query($koneksi, $update_sql)) {
            // Proses menyimpan tanggapan ke tabel tanggapan
            $id_petugas = $_SESSION['id_petugas']; // Asumsikan ID petugas diperoleh dari sesi atau diatur sebelumnya
            $tgl_tanggapan = date('Y-m-d H:i:s'); // Tanggal dan waktu saat ini

            $insert_sql = "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) 
                           VALUES ('$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')";

            if (mysqli_query($koneksi, $insert_sql)) {
                echo "<script>alert('Tanggapan berhasil disimpan');</script>";
                echo "<script>window.location.href = '?url=lihat-laporan';</script>";
                exit;
            } else {
                echo "<script>alert('Gagal menyimpan tanggapan');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengupdate status pengaduan');</script>";
        }
    }

    // Query untuk mendapatkan detail pengaduan
    $sql_detail = "SELECT * FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'";
    $query_detail = mysqli_query($koneksi, $sql_detail);
    $data_detail = mysqli_fetch_assoc($query_detail);

    // Query untuk mendapatkan tanggapan jika ada
    $sql_tanggapan = "SELECT * FROM tanggapan WHERE id_pengaduan = '$id_pengaduan'";
    $query_tanggapan = mysqli_query($koneksi, $sql_tanggapan);
    $data_tanggapan = mysqli_fetch_assoc($query_tanggapan);
}
?>

<!-- Form Tanggapan -->
<div class="card shadow my-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="?url=lihat-laporan" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <span class="text">Kembali</span>
                </a>
            </div>
            <h4 class="m-0 font-weight-bold text-primary mx-auto">Tanggapan Pengaduan</h4>
            <div></div> <!-- Placeholder untuk menjaga space -->
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="isi_laporan" class="small">Isi Laporan:</label>
            <textarea class="form-control" id="isi_laporan" name="isi_laporan" rows="3" readonly><?php echo $data_detail['isi_laporan']; ?></textarea>
        </div>
        <?php if ($data_tanggapan) { ?>
            <div class="form-group">
                <label for="isi_tanggapan" class="small">Isi Tanggapan:</label>
                <textarea class="form-control" id="isi_tanggapan" name="isi_tanggapan" rows="3" readonly><?php echo $data_tanggapan['tanggapan']; ?></textarea>
            </div>
        <?php } elseif ($data_detail['status'] == 1) { ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="isi_tanggapan" class="small">Tanggapan:</label>
                    <textarea class="form-control" id="isi_tanggapan" name="tanggapan" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="status" class="small">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="1">Sedang diproses</option>
                        <option value="2">Selesai</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php } ?>

        <?php if ($data_detail['status'] == 1) { ?>
            <form method="POST" action="">
                <input type="hidden" name="status" value="2">
                <button type="submit" name="tanggapan" value="Pengaduan telah selesai diproses" class="btn btn-success">Tandai sebagai Selesai</button>
            </form>
        <?php } ?>
    </div>
</div>
