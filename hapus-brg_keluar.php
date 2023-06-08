<?php
include 'config/app.php';
session_start();

// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {


    // menerima id barang yang dipilih pengguna
    $id = (int)$_GET['id'];

    if (delete_barang_keluar($id) > 0) {
        echo "<script>
                alert('Data Barang Keluar Berhasil Dihapus !');
                document.location.href = 'brg_keluar.php';
             </script>";
    } else {
        echo "<script>
                alert('Data Barang Keluar Gagal Dihapus !');
                document.location.href = 'brg_keluar.php';
             </script>";
    }
} else {
    header("Location: login-template.php");
    exit();
}
