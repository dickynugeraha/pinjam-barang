<?php

// render halaman menjadi json
header('Content-Type: application/json');

require '../config/app.php';

$query = select("SELECT * FROM brg_peminjaman");

echo json_encode(['Data Barang Peminjaman' => $query]);
