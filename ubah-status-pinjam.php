<?php 
include 'config/app.php';
session_start();

if (isset($_SESSION['username'])) {
   $id = $_GET["id"];
   $status = $_GET["status"];

   update_status_pinjam($id, $status);
  
} else {
   header("Location: login-template.php");
   exit();
}

?>