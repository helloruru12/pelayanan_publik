<?php

if(isset($_GET['url'])){
    switch ($_GET['url']) {

        case 'lihat-laporan';
        include 'lihat-laporan.php';
        break;

        case 'lihat-user';
        include 'lihat-user.php';
        break;
       
        case 'lihat-tanggapan';
        include 'lihat-tanggapan.php';
        break;
        
        case 'profil';
        include 'profilp.php';
        break;

        case 'edit';
        include 'editp.php';
        break;
        
        case 'tanggapi-laporan':
        include 'tanggapi-laporan.php';
        break;

        default:
        echo "Halaman Tidak Ditemukan";
        break;
    }
}else{
    include 'dasboard.php';
}