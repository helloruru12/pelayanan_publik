<?php
include 'koneksi.php';

function getStatusCount($status) {
    global $koneksi;
    $sql = "SELECT COUNT(*) AS total FROM pengaduan WHERE status = $status";
    $result = mysqli_query($koneksi, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

function getTotalCountBySession() {
    global $koneksi;
    $nik = $_SESSION['nik'];
    $nik_escaped = mysqli_real_escape_string($koneksi, $nik);
    $sql = "SELECT COUNT(*) AS total FROM pengaduan WHERE nik = '$nik_escaped'";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

function getTotalCountPetugas() {
    global $koneksi;
    $sql = "SELECT COUNT(*) AS total FROM petugas";
    $result = mysqli_query($koneksi, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

function getCountByStatus($status) {
    global $koneksi;
    $nik = $_SESSION['nik'];
    $nik_escaped = mysqli_real_escape_string($koneksi, $nik);
    $sql = "SELECT COUNT(*) AS total FROM pengaduan WHERE nik = '$nik_escaped' AND status = $status";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

function getPengaduanByNik($limit = 10) {
    global $koneksi;
    $nik = $_SESSION['nik'];
    $nik_escaped = mysqli_real_escape_string($koneksi, $nik);
    $sql = "SELECT * FROM pengaduan WHERE nik = '$nik_escaped' ORDER BY tgl_pengaduan DESC LIMIT " . (int)$limit;
    $result = mysqli_query($koneksi, $sql);
    return $result;
}

function getTotalPendingAndInProgress() {
    return getCountByStatus(0) + getCountByStatus(1);
}

function getComplaintCountByMonth($year, $month) {
    global $koneksi;
    $sql = "SELECT COUNT(*) AS total FROM pengaduan WHERE YEAR(tgl_pengaduan) = $year AND MONTH(tgl_pengaduan) = '$month'";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

$totalLaporanUser = getTotalCountBySession();
$totalBelumDiproses = getCountByStatus(0);
$totalSedangDiproses = getCountByStatus(1);
$totalSelesaiDitangani = getCountByStatus(2);
$totalPendingAndInProgress = $totalBelumDiproses + $totalSedangDiproses;
$totalPetugasAktif = getTotalCountPetugas();

$currentYear = date('Y');
$monthlyComplaintCounts = [];
for ($m = 1; $m <= 12; $m++) {
    $monthlyComplaintCounts[] = getComplaintCountByMonth($currentYear, sprintf('%02d', $m));
}
?>

<style>
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
    .dashboard-card.border-info-custom { border-color: #36b9cc !important; }

    .dashboard-card .col-auto i {
        color: rgba(0,0,0,0.15);
    }

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
    .dashboard-main-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Animasi (untuk header) */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .activity-list-item {
        transition: background-color 0.2s ease-in-out;
        border-left: 4px solid transparent;
        font-size: 0.9rem;
    }
    .activity-list-item:hover {
        background-color: #f8f9fc;
        border-left-color: #4e73df;
    }
    .activity-list-item .text-muted {
        font-size: 0.75rem;
    }
    .activity-list-item i.fas {
        font-size: 0.8rem;
    }
    .activity-list-item .status-icon-pending { color: #f6c23e; }
    .activity-list-item .status-icon-processing { color: #36b9cc; }
    .activity-list-item .status-icon-completed { color: #1cc88a; }

    .table-responsive .table {
        margin-bottom: 0;
    }
    .table thead th {
        background-color: #f2f4f8;
        color: #6e707e;
        border-bottom: 2px solid #eaecf4;
        font-size: 0.85rem;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
    .table tbody td {
        font-size: 0.8rem;
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

    .img-thumbnail {
        border-radius: 0.25rem;
        padding: 2px;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    .img-thumbnail:hover {
        border-color: #4e73df;
    }

    .btn-action {
        border-radius: 0.35rem;
        font-size: 0.8rem;
        padding: .3rem .7rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: 0.85rem;
        padding: 0.5em 0.8em;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        font-size: 0.85rem;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.85rem;
    }
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        font-size: 0.85rem;
    }
</style>

<header class="bg-primary text-white text-center py-4 dashboard-main-header">
    <h2 class="font-weight-bold d-none d-sm-block">Dashboard Solusi Warga</h2>
    <h1 class="font-weight-bold d-block d-sm-none small">Dashboard Solusi Warga</h1>
    <p class="d-none d-sm-block">Selamat datang, <?php echo $_SESSION['nama']; ?></p>
    <p class="d-block d-sm-none small">Selamat datang kembali, **<?php echo $_SESSION['nama']; ?>**!</p>
</header>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card dashboard-card border-primary-custom h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title text-primary">JUMLAH LAPORAN ANDA</div>
                            <div class="card-text"><?php echo $totalLaporanUser; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card dashboard-card border-warning-custom h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title text-warning">MENUNGGU PENANGANAN</div>
                            <div class="card-text"><?php echo $totalPendingAndInProgress; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card dashboard-card border-success-custom h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title text-success">SELESAI DITANGANI</div>
                            <div class="card-text"><?php echo $totalSelesaiDitangani; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pengaduan Bulanan (Tahun <?php echo $currentYear; ?>)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terkini</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php
                        $sql_activity = "SELECT pengaduan.id_pengaduan, pengaduan.tgl_pengaduan, pengaduan.status, masyarakat.nama
                                FROM pengaduan
                                JOIN masyarakat ON pengaduan.nik = masyarakat.nik
                                ORDER BY pengaduan.tgl_pengaduan DESC LIMIT 5";
                        $query_activity = mysqli_query($koneksi, $sql_activity);

                        if (mysqli_num_rows($query_activity) > 0) {
                            while ($data_activity = mysqli_fetch_array($query_activity)) {
                                $status_text_activity = '';
                                $status_icon_class = '';
                                $status_color_class = '';
                                switch ($data_activity['status']) {
                                    case 0:
                                        $status_text_activity = "Laporan baru dari";
                                        $status_icon_class = 'fas fa-plus-circle status-icon-pending';
                                        break;
                                    case 1:
                                        $status_text_activity = "Laporan sedang diproses dari";
                                        $status_icon_class = 'fas fa-spinner fa-spin status-icon-processing';
                                        break;
                                    case 2:
                                        $status_text_activity = "Laporan selesai ditangani dari";
                                        $status_icon_class = 'fas fa-check-circle status-icon-completed';
                                        break;
                                    default:
                                        $status_text_activity = "Aktivitas tidak diketahui dari";
                                        $status_icon_class = 'fas fa-question-circle text-secondary';
                                }
                                ?>
                                <a href="?url=lihat-tanggapan&id=<?php echo $data_activity['id_pengaduan']; ?>" class="list-group-item list-group-item-action activity-list-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="<?php echo $status_icon_class; ?> mr-2"></i>
                                        <?php echo $status_text_activity; ?> <strong class="text-dark"><?php echo $data_activity['nama']; ?></strong>
                                    </div>
                                    <small class="text-muted"><?php echo date('d M Y', strtotime($data_activity['tgl_pengaduan'])); ?></small>
                                </a>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="list-group-item text-center text-muted">Tidak ada aktivitas terbaru.</div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
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
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 12,
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            if (Math.floor(value) === value) {
                                return value;
                            }
                        },
                        font: {
                            size: 10
                        }
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + ' Laporan';
                            }
                            return label;
                        }
                    },
                    titleFont: {
                        size: 12
                    },
                    bodyFont: {
                        size: 11
                    }
                }
            }
        }
    });
</script>