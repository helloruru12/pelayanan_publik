<div class="container">
    <?php include '../carosel.php' ?>
    <div class="header">
        <h3 class="mb-3">Dashboard Pelayanan Pelaporan Masyarakat</h3>
    </div>
    <div class="content">
        <!-- Summary Cards -->
        <?php
        include '../koneksi.php';

        function getStatusCount($status) {
            global $koneksi;
            $sql = "SELECT COUNT(*) AS total FROM pengaduan WHERE status = $status";
            $result = mysqli_query($koneksi, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['total'];
            } else {
                return 0;
            }
        }

        function getTotalCount() {
            global $koneksi;
            $sql = "SELECT COUNT(*) AS total FROM pengaduan";
            $result = mysqli_query($koneksi, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['total'];
            } else {
                return 0;
            }
        }

        function getTotalCountMasyarakat() {
            global $koneksi;
            $sql = "SELECT COUNT(*) AS total FROM masyarakat";
            $result = mysqli_query($koneksi, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['total'];
            } else {
                return 0;
            }
        }

        // Fungsi untuk mengambil jumlah pengaduan per bulan
        function getComplaintCountByMonth($year, $month) {
            global $koneksi;
            $sql = "SELECT COUNT(*) AS total 
                    FROM pengaduan 
                    WHERE YEAR(tgl_pengaduan) = $year 
                    AND MONTH(tgl_pengaduan) = '$month'";
            $result = mysqli_query($koneksi, $sql);
            $row = mysqli_fetch_assoc($result);
            return $row['total'];
        }
        
        // Ambil jumlah pengaduan untuk setiap bulan tahun 2024
        $janComplaintCount = getComplaintCountByMonth(2024, '01');
        $febComplaintCount = getComplaintCountByMonth(2024, '02');
        $marComplaintCount = getComplaintCountByMonth(2024, '03');
        $aprComplaintCount = getComplaintCountByMonth(2024, '04');
        $meiComplaintCount = getComplaintCountByMonth(2024, '05');
        $junComplaintCount = getComplaintCountByMonth(2024, '06');
        $julComplaintCount = getComplaintCountByMonth(2024, '07');
        $augComplaintCount = getComplaintCountByMonth(2024, '08');
        $sepComplaintCount = getComplaintCountByMonth(2024, '09');
        $oktComplaintCount = getComplaintCountByMonth(2024, '10');
        $novComplaintCount = getComplaintCountByMonth(2024, '11');
        $desComplaintCount = getComplaintCountByMonth(2024, '12');
        ?>
         <!-- Statistik Utama -->
         <div class="my-4">
             <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Laporan</h5>
                            <p class="card-text"><?php echo getTotalCount(); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Butuh Penanganan</h5>
                            <p class="card-text"><?php echo getStatusCount(0) + getStatusCount(1); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pengguna Aktif</h5>
                            <p class="card-text"><?php echo getTotalCountMasyarakat(); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik dan Diagram -->
            <div class="row ">
                <div class="col-md-8">
                    <div class="card mb-4 ">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Pengaduan Bulanan</h5>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body small">
                            <h5 class="card-title">Aktivitas Terkini</h5>
                            <ul class="list-group">
                                <?php
                                $sql = "SELECT pengaduan.id_pengaduan, pengaduan.tgl_pengaduan, pengaduan.status, masyarakat.nama
                                        FROM pengaduan
                                        JOIN masyarakat ON pengaduan.nik = masyarakat.nik
                                        ORDER BY pengaduan.tgl_pengaduan DESC LIMIT 5";
                                $query = mysqli_query($koneksi, $sql);

                                if (mysqli_num_rows($query) > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                        <li class="list-group-item">
                                            <?php
                                            switch ($data['status']) {
                                                case 0:
                                                    echo "Pengaduan baru dari " . $data['nama'];
                                                    break;
                                                case 1:
                                                    echo "Status pengaduan " . $data['nama'] . " diperbarui";
                                                    break;
                                                case 2:
                                                    echo "Pengaduan " . $data['nama'] . " selesai ditangani";
                                                    break;
                                                default:
                                                    echo "Aktivitas tidak diketahui";
                                            }
                                            ?>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li class="list-group-item">Tidak ada aktivitas terbaru</li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </div>                         
            <!-- Laporan Terbaru Table -->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaduan Terbaru</h6>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped small table-sm">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Pelapor</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT pengaduan.id_pengaduan, pengaduan.tgl_pengaduan, pengaduan.status, masyarakat.nama AS nama_pelapor
                                    FROM pengaduan
                                    JOIN masyarakat ON pengaduan.nik = masyarakat.nik
                                    WHERE pengaduan.status != 2
                                    ORDER BY pengaduan.tgl_pengaduan DESC LIMIT 10";
                            $query = mysqli_query($koneksi, $sql);

                            if (mysqli_num_rows($query) > 0) {
                                $no = 1;
                                while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $data['nama_pelapor']; ?></td>
                                        <td><?= $data['tgl_pengaduan']; ?></td>
                                        <td>
                                            <span class="badge text-light 
                                                <?= $data['status'] == 0 ? 'bg-warning' : ($data['status'] == 1 ? 'bg-success' : 'bg-danger'); ?>">
                                                <?= $data['status'] == 0 ? 'Belum diproses' : ($data['status'] == 1 ? 'Sedang diproses' : 'Selesai'); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="?url=lihat-laporan&id=<?= $data['id_pengaduan'] ?>" class="btn btn-primary btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data pengaduan yang belum selesai.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
                </div>
            </div>
       
    </div>
</div>


<!-- Optional JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Script untuk membuat grafik dengan Chart.js
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: [
                    <?php
                    // Isi data bulan Januari sampai Desember
                    echo json_encode($janComplaintCount) . ', ';
                    echo json_encode($febComplaintCount) . ', ';
                    echo json_encode($marComplaintCount) . ', ';
                    echo json_encode($aprComplaintCount) . ', ';
                    echo json_encode($meiComplaintCount) . ', ';
                    echo json_encode($junComplaintCount) . ', ';
                    echo json_encode($julComplaintCount) . ', ';
                    echo json_encode($augComplaintCount) . ', ';
                    echo json_encode($sepComplaintCount) . ', ';
                    echo json_encode($oktComplaintCount) . ', ';
                    echo json_encode($novComplaintCount) . ', ';
                    echo json_encode($desComplaintCount);
                    ?>
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>