
<?php
include 'config/app.php';
session_start();

   if (isset($_SESSION['username'])) {
      $data_pengeluaran =  select("SELECT date_format(created_at,'%M'),sum(harga_beli)
      FROM `brg_masuk`
      GROUP BY year(created_at),month(created_at)
      ORDER BY year(created_at),month(created_at);");
   }
   echo json_encode($data_pengeluaran);
?>