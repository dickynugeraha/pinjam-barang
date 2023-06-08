<?php
include '../config/app.php';
session_start();

if (isset($_SESSION['username'])) {
   $nama_brg = $_GET["query"];
   $data_brg = select("SELECT * FROM brg_masuk WHERE nama_brg LIKE '%$nama_brg%' AND stok != 0");;
}
echo json_encode($data_brg[0])

?>