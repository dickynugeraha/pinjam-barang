<?php 
include 'config/app.php';
session_start();

if (isset($_SESSION['username'])) {
   $id = $_GET["id"];
   $nama_brg = $_GET["nama_brg"];
   $jumlah = $_GET["jumlah"];

   if (selesai_pinjam($id, $nama_brg, $jumlah) > 0){
      echo "<script>
               alert('Status berhasil diubah');
                   document.location.href = 'brg_peminjaman.php';
            </script>";
   } else {
      echo "<script>
               alert('Status gagal diubah');
                   document.location.href = 'brg_peminjaman.php';
            </script>";
   }
} else {
   header("Location: login-template.php");
   exit();
}

?>