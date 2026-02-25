<?php 
include '../koneksi.php';
$nama  = $_POST['nama'];
$spesifikasi = $_POST['spesifikasi'];
$lokasi = $_POST['lokasi'];
$jumlah = $_POST['jumlah'];
$sumber_dana = $_POST['sumber_dana'];
$keterangan = $_POST['keterangan'];



mysqli_query($koneksi, "insert into barang values (NULL,'$nama','$spesifikasi','$lokasi','$jumlah','$sumber_dana','$keterangan')");
header("location:barang.php");
