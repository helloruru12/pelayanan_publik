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

function getComplaintCountByMonth($year, $month) {
    global $koneksi;
    $sql = "SELECT COUNT(*) AS total FROM pengaduan WHERE YEAR(tgl_pengaduan) = $year AND MONTH(tgl_pengaduan) = '$month'";
    $result = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

$currentYear = date('Y');
$monthlyComplaintCounts = [];
for ($m = 1; $m <= 12; $m++) {
    $monthlyComplaintCounts[] = getComplaintCountByMonth($currentYear, sprintf('%02d', $m));
}
?>

<style>
/* Tambahkan semua CSS modern di sini */
.dashboard-card {
    border-left: 0.25rem solid transparent;
    border-radius: 0.35rem;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 68, .15) !important;
    margin-bottom: 1.5rem;
}
.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
}
.dashboard-card .card-body {
    padding: 1rem 1.25rem;
}
.dashboard-card .card-title {
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #b7b9cc;
    text-transform: uppercase;
}
.dashboard-card .card-text {
    font-size: 1.5rem;
    font-weight: 700;
    color: #5a5c69;
}

.dashboard-card.border-primary-custom { border-color: #4e73df !important; }
.dashboard-card.border-warning-custom { border-color: #f6c23e !important; }
.dashboard-card.border-success-custom { border-color: #1cc88a !important; }

.dashboard-main-header {
    background: linear-gradient(45deg, #4e73df, #224abe);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 0.75rem;
    text-align: center;
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.2);
    animation: fadeInDown 0.8s ease-out;
}
.dashboard-main-header h2 {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
.status-badge {
    padding: .3em .6em;
    font-size: 75%;
    border-radius: .5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.status-badge.pending { background-color: #f6c23e; color: white; }
.status-badge.processing { background-color: #36b9cc; color: white; }
.status-badge.completed { background-color: #1cc88a; color: white; }
</style>

<header class="dashboard-main-header">
    <h2>Dashboard Pelayanan Pelaporan Masyarakat</h2>
    <p>Selamat datang kembali, <?php echo $_SESSION['nama'] ?? 'Pengguna'; ?></p>
</header>

<div class="container">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card dashboard-card border-primary-custom h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title text-primary">Jumlah Laporan</div>
                            <div class="card-text"><?php echo getTotalCount(); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card border-warning-custom">
                <div class="card-body">
                    <h5 class="card-title">Butuh Penanganan</h5>
                    <p class="card-text"><?php echo getStatusCount(0) + getStatusCount(1); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card border-success-custom">
                <div class="card-body">
                    <h5 class="card-title">Pengguna Aktif</h5>
                    <p class="card-text"><?php echo getTotalCountMasyarakat(); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Grafik Pengaduan Bulanan</h5>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aktivitas Terkini</h5>
                    <ul class="list-group">
                        <?php
                        $sql = "SELECT pengaduan.id_pengaduan, pengaduan.tgl_pengaduan, pengaduan.status, masyarakat.nama FROM pengaduan JOIN masyarakat ON pengaduan.nik = masyarakat.nik ORDER BY pengaduan.tgl_pengaduan DESC LIMIT 5";
                        $query = mysqli_query($koneksi, $sql);
                        if (mysqli_num_rows($query) > 0) {
                            while ($data = mysqli_fetch_array($query)) {
                                $statusClass = ['pending', 'processing', 'completed'][$data['status']] ?? 'secondary';
                                $statusText = ['Pengaduan baru dari', 'Status pengaduan diperbarui oleh', 'Pengaduan selesai ditangani oleh'][$data['status']] ?? 'Aktivitas tidak diketahui';
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?php echo $statusText . ' <strong>' . $data['nama'] . '</strong>'; ?></span>
                                    <span class="badge status-badge <?php echo $statusClass; ?>"><?php echo date('d M', strtotime($data['tgl_pengaduan'])); ?></span>
                                </li>
                                <?php
                            }
                        } else {
                            echo '<li class="list-group-item">Tidak ada aktivitas terbaru</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: <?php echo json_encode($monthlyComplaintCounts); ?>,
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' Laporan';
                        }
                    }
                }
            }
        }
    });
</script>
