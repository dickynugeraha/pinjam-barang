
<?php
include 'config/app.php';
session_start();

   if (isset($_SESSION['username'])) {
      $data_pendapatan =  select("SELECT date_format(created_at,'%M'),sum(total_harga)
      FROM `brg_keluar`
      GROUP BY year(created_at),month(created_at)
      ORDER BY year(created_at),month(created_at);");
   }
   echo json_encode($data_pendapatan);
?>