<?php 
session_start();
if($_SESSION['level']!="petugas"){
  echo"<script>alert('Maaf Anda Bukan Pada Sesi Petugas'); window.location.assign('../index2.php'); </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Solusi Warga</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .profile-picture-wrapper {
            position: relative;
            display: inline-block;
        }
        .profile-picture-wrapper .btn-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @media (max-width: 768px) {
            .sidebar.toggled {
                width: 0 !important;
                overflow: hidden;
            }
            .sidebar:not(.toggled) {
                width: var(--sidebar-width) !important;
                min-width: 10rem;
            }
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="petugas.php">
                <div class="sidebar-brand-icon rotate-n-13">
                    <img src="../icon.png" width="100" alt="">
                </div>
                <div class="sidebar-brand-text mr-1">SOLUSI WARGA</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="petugas.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Pengaduan</div>

            <li class="nav-item">
                <a class="nav-link" href="?url=lihat-user">
                    <i class="fas fa-fw fa-user-alt"></i>
                    <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?url=lihat-laporan">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Lihat Laporan</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Lainnya</div>

            <li class="nav-item">
                <a class="nav-link" href="https://wa.me/+6285643493648?" target="_blank">
                    <i class="fab fa-whatsapp fa-fw"></i>
                    <span>Call Center</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                include '../koneksi.php';
                                $id_petugas = $_SESSION['id_petugas'];
                                $sql = "SELECT nama_petugas, foto FROM petugas WHERE id_petugas = ?";
                                $stmt = mysqli_prepare($koneksi, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $id_petugas);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if (mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $nama_petugas = $row['nama_petugas'];
                                    $foto_profil = $row['foto'];
                                    $foto_path = $foto_profil ? "../img/profil/" . $foto_profil : "../img/profil/pp.jpg";
                                } else {
                                    $nama_petugas = "nama_petugas";
                                    $foto_path = "../img/profil/pp.jpg";
                                }
                                mysqli_stmt_close($stmt);
                                mysqli_close($koneksi);
                                ?>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nama_petugas; ?></span>
                                <img class="img-profile rounded-circle" src="<?= $foto_path ?>" style="width: 30px; height: 30px;">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="?url=profil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <?php include 'halaman.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded shadow-sm">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-primary" id="logoutModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-secondary">
                    Klik tombol <strong>"Keluar"</strong> di bawah ini jika Anda ingin mengakhiri sesi saat ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-sm btn-danger" href="../logout.php">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../js/demo/datatables-demo.js"></script>
</body>

</html>