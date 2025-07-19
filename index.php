<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Halaman login untuk Solusi Warga.">
    <meta name="author" content="Tim Solusi Warga">

    <title>Login - Solusi Warga</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('img/top.png'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-login {
            max-width: 450px; 
            width: 90%; 
            background-color: rgba(255, 255, 255, 0.95); 
            padding: 40px 30px;
            border-radius: 15px; 
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2); 
            border: none;
            transform: translateY(0); 
            transition: transform 0.5s ease-out, opacity 0.5s ease-out;
            opacity: 1; 
        }

        .card-login.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        .card-title-login {
            text-align: center;
            margin-bottom: 30px;
            color: #4e73df; 
            font-size: 1.8rem; 
            font-weight: 700;
        }

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

        .btn-user {
            border-radius: 50px; 
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 15px; 
        }

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
        <div class="card card-login my-5 mx-auto">
            <div class="card-body">
                <h1 class="card-title-login">Selamat Datang di Solusi Warga!</h1>
                <form class="user" method="post" action="proses-login.php">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control form-control-user rounded" id="inputUsername" aria-describedby="usernameHelp" placeholder="Masukkan Username" required autofocus>
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control form-control-user rounded" id="inputPassword" placeholder="Masukkan Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block rounded">
                        Login
                    </button>
                    <hr>
                    <div class="text-center links-bottom">
                        <div><i class="fas fa-user-plus fa-fw"></i> Belum punya akun? <a href="register.php" class="">Daftar</a></div>
                        <div><i class="fas fa-user-shield fa-fw"></i> Admin? <a href="index2.php" class="">Login</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cardLogin = document.querySelector('.card-login');
            cardLogin.style.opacity = 0; 
            cardLogin.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                cardLogin.style.opacity = 1;
                cardLogin.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>

</body>

</html>