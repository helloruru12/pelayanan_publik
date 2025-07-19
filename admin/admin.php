<?php
session_start();
if($_SESSION['level']!="admin"){
  echo"<script>alert('Maaf Anda Bukan Pada Sesi Admin'); window.location.assign('../index2.php'); </script>";
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
    <title>Aksi Masyarakat</title>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
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
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <div class="container-fluid px-0">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                        <div class="container-fluid">
                            <a class="navbar-brand d-flex align-items-center" href="admin.php">
                                <div class="sidebar-brand-icon rotate-n-15">
                                    <img src="../icon.png" width="35" alt="">
                                </div>
                                <div class="sidebar-brand-text font-weight-bold mx-3">AKSIMAS</div>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                                <ul class="navbar-nav font-weight-bold">
                                    <li class="nav-item active d-lg-inline">
                                    <a class="nav-link" href="admin.php">
                                        <i class="fas fa-fw fa-tachometer-alt"></i>
                                        <span>Dashboard</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?url=lihat-laporan">
                                        <i class="fa fa-comment"></i>
                                        <span>Lihat Laporan</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="?url=lihat-pengajuan">
                                        <i class="fa fa-comment"></i>
                                        <span>Data Pengajuan</span></a>
                                    </li>
                                    <li class="nav-item dropdown no-arrow bg-light rounded px-2">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                            <span class="mr-2  text-dark"><?php echo $nama_petugas; ?></span>
                                            <img src="<?= $foto_path ?>" class="img-profile rounded-circle mr-2" style="width: 30px; height: 30px;">
                                            <i class="fas fa-caret-down text-dark"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right mb-2 shadow animated--grow-in" aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="?url=profil">
                                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Profile
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="../logout.php">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Logout
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                            </nav>


 
                </div>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="">
                    <!-- Page Heading -->
                    <?php include 'halaman.php'; ?>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer ">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Aksi Masyarakat &copy; KKNT UDB 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages -->
    <script src="../js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
        // Script to toggle the sidebar
        $('#sidebarToggleTop').click(function() {
            $('.navbar-nav').toggle();
        });
    </script>
</body>

</html>
