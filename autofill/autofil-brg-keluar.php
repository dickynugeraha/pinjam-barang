<?php
include '../config/app.php';
session_start();

   if (isset($_SESSION['username'])) {
      $nama_brg = $_GET["term"];
      $data_brg =  select("SELECT nama_brg FROM brg_masuk WHERE stok != 0 AND nama_brg LIKE '$nama_brg%' LIMIT 10");
      
      $data_nama = array();
      for ($i=0; $i < count($data_brg); $i++) { 
         $data_nama[$i] = $data_brg[$i]["nama_brg"];
      }
   }
   echo json_encode($data_nama)
?>