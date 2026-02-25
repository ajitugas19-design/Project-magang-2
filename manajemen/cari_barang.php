<?php
header('Content-Type: application/json');

include '../koneksi.php';

$kode = isset($_GET['kode']) ? $_GET['kode'] : '';

if(empty($kode)){
    echo json_encode(['success' => false, 'message' => 'Kode barcode kosong']);
    exit;
}

// Search barang by barcode (barang_id)
$query = "SELECT * FROM barang WHERE barang_id = '$kode' OR barang_nama LIKE '%$kode%'";
$result = mysqli_query($koneksi, $query);

if(mysqli_num_rows($result) > 0){
    $barang = mysqli_fetch_assoc($result);
    echo json_encode([
        'success' => true, 
        'data' => [
            'barang_id' => $barang['barang_id'],
            'barang_nama' => $barang['barang_nama'],
            'barang_spesifikasi' => $barang['barang_spesifikasi'],
            'barang_lokasi' => $barang['barang_lokasi'],
            'barang_jumlah' => $barang['barang_jumlah']
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Barang tidak ditemukan']);
}
