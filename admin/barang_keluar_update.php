<?php 
include '../koneksi.php';
$id  = $_POST['id'];
$barang  = $_POST['barang'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];
$lokasi_asal = $_POST['lokasi_asal'];
$lokasi_tujuan = $_POST['lokasi_tujuan'];
$keterangan = $_POST['keterangan'];

// Ambil data barang
$b = mysqli_query($koneksi,"select * from barang where barang_id='$barang'");
$bb = mysqli_fetch_assoc($b);
$nama_barang = $bb['barang_nama'];
$jumlah_barang = $bb['barang_jumlah'];

// Ambil data barang keluar lama
$bk = mysqli_query($koneksi,"select * from barang_keluar where bk_id='$id'");
$barang_keluar = mysqli_fetch_assoc($bk);
$id_barang = $barang_keluar['bk_id_barang'];
$jumlah_barang_keluar = $barang_keluar['bk_jumlah_keluar'];

// Ambil jumlah barang dari database
$x = mysqli_query($koneksi,"select * from barang where barang_id='$id_barang'");
$xx = mysqli_fetch_assoc($x);
$jumlah_x = $xx['barang_jumlah'];

// Kembalikan jumlah lama ke stok
$kembalikan_jumlah = $jumlah_x + $jumlah_barang_keluar;

// Cek jika jumlah yang diinput lebih besar dari jumlah barang yang ada
if($jumlah > $kembalikan_jumlah){
	header("location:barang_keluar.php?alert=lebih");
}else{
	// Kembalikan stok barang lama
	mysqli_query($koneksi,"update barang set barang_jumlah='$kembalikan_jumlah' where barang_id='$id_barang'");

	// Kurangi stok untuk barang baru
	$jumlah_akhir = $kembalikan_jumlah - $jumlah;
	mysqli_query($koneksi,"update barang set barang_jumlah='$jumlah_akhir' where barang_id='$barang'");

	// Update data barang keluar
	mysqli_query($koneksi,"update barang_keluar set 
		bk_id_barang='$barang', 
		bk_nama_barang='$nama_barang', 
		bk_tgl_keluar='$tanggal', 
		bk_jumlah_keluar='$jumlah', 
		bk_lokasi_asal='$lokasi_asal',
		bk_lokasi_tujuan='$lokasi_tujuan',
		bk_keterangan='$keterangan' 
		where bk_id='$id'");
	
	header("location:barang_keluar.php");
}
