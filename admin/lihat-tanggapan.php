<?php

$id = $_GET['id'];
if(empty($id)){
    header("Location:admin.php");
}

include '../koneksi.php';
$query = mysqli_query($koneksi, "SELECT*FROM pengaduan,tanggapan WHERE tanggapan.id_pengaduan='$id' AND tanggapan.id_pengaduan=pengaduan.id_pengaduan");

?>
<div class="card shadow my-4">
<div class="card-header">
    <a href="?url=lihat-laporan" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-5">
            <i class="fa fa-arrow-left"></i>
        </span>
        <span class="text"> Kembali </span>
    </a>
</div>
<div class="card-body">
    <?php
    if(mysqli_num_rows($query)==0){
        echo"<div class='alert alert-denger'>Maaf tanggapan anda belum ditanggapi.</div>";
    }else{
        $data = mysqli_fetch_array($query); ?>

    <form method="post" action="proses-pengaduan.php" enctype="multipart/form-data">

    <div class="form-group">
        <label style="font-size: 14px">Tgl Tanggapan</label>
        <input type="text" name="tgl_tanggapans" class="form-control" readonly
        value="<?= $data['tgl_tanggapan']; ?>">
    </div>

    <div class="form-group">
        <label style="font-size: 14px">Tanggapan</label>
        <textarea name="tanggapan" class="form-control" readonly><?= $data['tanggapan']; ?></textarea>
    </div>

    <div class="form-group">
        <label style="font-size: 14px">Isi Laporan</label>
        <textarea name="isi_laporan" class="form-control" readonly><?= $data['isi_laporan']; ?></textarea>
    </div>

</form>
<?php } ?>

</div>
</div>