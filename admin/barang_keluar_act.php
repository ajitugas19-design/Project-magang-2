<?php 
include '../koneksi.php';
$barang  = $_POST['barang'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$lokasi_asal = $_POST['lokasi_asal'];
$lokasi_tujuan = $_POST['lokasi_tujuan'];

// Get supplier info from lokasi_asal (which is supplier name)
$suplier = mysqli_query($koneksi,"SELECT * FROM suplier WHERE suplier_nama='$lokasi_asal'");
$ss = mysqli_fetch_assoc($suplier);
$suplier_id = isset($ss['suplier_id']) ? $ss['suplier_id'] : 0;
$nama_suplier = isset($ss['suplier_nama']) ? $ss['suplier_nama'] : $lokasi_asal;

$b = mysqli_query($koneksi,"select * from barang where barang_id='$barang'");
$bb = mysqli_fetch_assoc($b);
$nama_barang = $bb['barang_nama'];
$jumlah_barang = $bb['barang_jumlah'];

// cek jika jumlah yang diinput lebih besar dari jumlah barang yang ada
if($jumlah > $jumlah_barang){
	header("location:barang_keluar.php?alert=lebih");
}else{

	// kurangi jumlah data barang
	$jumlah_baru = $jumlah_barang-$jumlah;
	mysqli_query($koneksi,"update barang set barang_jumlah='$jumlah_baru' where barang_id='$barang'");

	// Insert with correct column order: bk_id, bk_id_barang, bk_nama_barang, bk_tgl_keluar, bk_jumlah_keluar, bk_lokasi_asal, bk_id_suplier, bk_nama_suplier, bk_lokasi_tujuan, bk_keterangan
	mysqli_query($koneksi, "INSERT INTO barang_keluar (bk_id, bk_id_barang, bk_nama_barang, bk_tgl_keluar, bk_jumlah_keluar, bk_lokasi_asal, bk_id_suplier, bk_nama_suplier, bk_lokasi_tujuan, bk_keterangan) 
	VALUES (NULL,'$barang','$nama_barang','$tanggal','$jumlah','$lokasi_asal','$suplier_id','$nama_suplier','$lokasi_tujuan',NULL)");
	header("location:barang_keluar.php");
}
