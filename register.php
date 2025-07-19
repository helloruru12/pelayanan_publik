<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Halaman pendaftaran akun baru untuk Solusi Warga.">
    <meta name="author" content="Tim Solusi Warga">

    <title>Solusi Warga - Daftar Akun</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('img/top.png'); /* Pastikan path ini benar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-y: auto; /* Agar bisa discroll jika form terlalu panjang */
        }

        /* Menggunakan kelas yang konsisten dengan halaman login */
        .card-register {
            max-width: 500px;
            width: 90%;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            border: none;
            transform: translateY(0);
            transition: transform 0.5s ease-out, opacity 0.5s ease-out;
            opacity: 1;
            margin-top: 2rem;
            margin-bottom: 2rem;
            /* Tambahan: Pastikan card berada di tengah secara horizontal jika kolomnya lebih lebar */
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Animasi fade-in */
        .card-register.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        /* Kelas untuk judul dalam card */
        .card-title-register {
            text-align: center;
            margin-bottom: 30px;
            color: #4e73df;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.4;
        }

        /* Gaya untuk input form yang konsisten */
        .form-control-user {
            border-radius: 50px;
            padding: 15px 25px;
            font-size: 1rem;
            border: 1px solid #ddd;
        }
        .form-control-user:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 .2rem rgba(78, 115, 223, .25);
        }

        /* Gaya untuk tombol */
        .btn-user {
            border-radius: 50px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 15px;
        }

        /* Gaya untuk link di bagian bawah form */
        .links-bottom {
            margin-top: 25px;
            font-size: 0.9rem;
        }
        .links-bottom a {
            color: #4e73df;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .links-bottom a:hover {
            color: #2e59d9;
            text-decoration: underline;
        }
        .links-bottom div {
            margin-bottom: 8px;
        }
        .links-bottom i {
            margin-right: 5px;
            color: #6e707e;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-8 col-md-10"> 
                 <div class="card card-register o-hidden border-0 shadow-lg my-5 mx-auto">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="card-title-register">Silakan Masukkan Biodata Anda untuk Mendaftar Akun Solusi Warga.</h1>
                                    </div>
                                    <form method="post" action="proses-register.php" class="user">
                                        <div class="form-group">
                                            <input name="nik" type="text" class="form-control form-control-user rounded" id="inputNIK" placeholder="Masukkan NIK Anda (16 digit)" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="nama" type="text" class="form-control form-control-user rounded" id="inputNama" placeholder="Masukkan Nama Lengkap Anda" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="username" type="text" class="form-control form-control-user rounded" id="inputUsername" placeholder="Buat Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user rounded" id="inputPassword" placeholder="Buat Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="telp" type="text" class="form-control form-control-user rounded" id="inputTelp" placeholder="Masukkan Nomor Telepon (aktif)" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block rounded">
                                            Daftar Sekarang
                                        </button>
                                        <hr>
                                        <div class="text-center links-bottom">
                                            <div>
                                                <i class="fas fa-sign-in-alt fa-fw"></i> Sudah punya akun? <a href="index.php" class="">Login</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

    <script>
        // Animasi fade-in saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const cardRegister = document.querySelector('.card-register');
            cardRegister.style.opacity = 0;
            cardRegister.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                cardRegister.style.opacity = 1;
                cardRegister.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>

</body>

</html>