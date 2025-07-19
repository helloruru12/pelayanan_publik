<?php
include '../koneksi.php';

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Menentukan jumlah data per halaman
$limit = 10;

// Mendapatkan nomor halaman saat ini
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch data from skck table, urutkan berdasarkan waktu terbaru
$sql_skck = "SELECT id, tgl_pengaduan, nik, nama, 'SKCK' AS jenis, nomor FROM skck";
$result_skck = $koneksi->query($sql_skck);

// Fetch data from pengantar table, urutkan berdasarkan waktu terbaru
$sql_pengantar = "SELECT id, tgl_pengaduan, nik, nama, 'Pengantar' AS jenis, nomor FROM pengantar";
$result_pengantar = $koneksi->query($sql_pengantar);

// Gabungkan hasil dari kedua tabel dalam satu array
$combined_results = [];

// Ambil semua baris dari skck
if ($result_skck->num_rows > 0) {
    while ($row = $result_skck->fetch_assoc()) {
        $combined_results[] = $row;
    }
}

// Ambil semua baris dari pengantar
if ($result_pengantar->num_rows > 0) {
    while ($row = $result_pengantar->fetch_assoc()) {
        $combined_results[] = $row;
    }
}

// Fungsi untuk membandingkan tanggal pengaduan dan mengurutkan secara menurun
function cmp($a, $b)
{
    return strtotime($b['tgl_pengaduan']) - strtotime($a['tgl_pengaduan']);
}

// Urutkan $combined_results berdasarkan fungsi cmp
usort($combined_results, 'cmp');

// Menghitung total halaman
$total_data = count($combined_results);
$total_pages = ceil($total_data / $limit);

// Memotong array untuk menampilkan data sesuai halaman
$current_data = array_slice($combined_results, $offset, $limit);
?>

<div class="container mt-4">
    <div class="card shadow my-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Data Surat Pengajuan</h6>
                </div>
            </div>
        </div>
        <div class="card-body" style="font-size: 14px;">
            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered "  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Keperluan</th>
                            <th>Whatsapp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $offset + 1;
                        foreach ($current_data as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($no++) . "</td>";
                            echo "<td>" . htmlspecialchars($row["tgl_pengaduan"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nik"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nama"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["jenis"]) . "</td>";
                            echo "<td>";
                            // Ambil nomor WhatsApp tanpa angka 0 di depannya
                            $nomor_whatsapp = isset($row['nomor']) ? ltrim($row['nomor'], '0') : '6281234567890'; // Ganti nomor default sesuai kebutuhan
                            echo "<a href='https://api.whatsapp.com/send?phone=62" . htmlspecialchars($nomor_whatsapp) . "&text=Mohon%20maaf%20bapak/ibu,%20Saya%20ingin%20menginformasikan%20bahwa%20surat%20pengajuan%20dengan%20NIK%20" . htmlspecialchars($row["nik"]) . "' target='_blank' class='btn btn-success btn-sm ml-1'><i class='fab fa-whatsapp'></i> WhatsApp</a>";
                            echo "</td>";
                            echo "<td>";
                            echo "<a href='view.php?jenis=" . htmlspecialchars(strtolower($row["jenis"])) . "&id=" . htmlspecialchars($row["id"]) . "' class='btn btn-info btn-sm' target='_blank'>Lihat</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php
$koneksi->close();
?>
