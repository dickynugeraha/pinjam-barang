<?php
session_start();
$tittle = 'Edit Barang Keluar';
include 'layout/header.php';

// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {





    //mengambil id barang dari URL
    $id = (int)$_GET['id'];

    $barang = select("SELECT * FROM brg_keluar WHERE id = $id")[0];

    // cek apakah tombol tambah ditekan
    if (isset($_POST['edit_brg_keluar'])) {
        if (update_barang_keluar($_POST) > 0) {
            echo "<script>
                alert('Data Barang Berhasil Diperbaharui !');
                document.location.href = 'brg_keluar.php';
             </script>";
        } else {
            echo "<script>
                alert('Data Barang Gagal Diperbaharui !');
                document.location.href = 'brg_keluar.php';
             </script>";
        }
    }


?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-edit"></i> Edit Data Barang Keluar</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="" method="post" enctype="multipart/form-data" style="width: 50%; margin-left: 40px; min-height:900px">

                    <input type="hidden" name="id" value="<?= $barang['id']; ?>">
                    <input type="hidden" name="gambarLama" value="<?= $barang['gambar_brg_keluar']; ?>">

                    <div class="mb-3">
                        <label for="nama_brg_keluar" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_brg_keluar" name="nama_brg_keluar" value="<?= $barang['nama_brg_keluar']; ?>" placeholder="Nama Barang Keluar...">
                    </div>

                    <div class="mb-3">
                        <label for="tipe_brg_keluar" class="form-label">Tipe Barang</label>
                        <input type="text" class="form-control" id="tipe_brg_keluar" name="tipe_brg_keluar" value="<?= $barang['tipe_brg_keluar']; ?>" placeholder="Tipe Barang Keluar...">
                    </div>

                    <div class="mb-3">
                        <label for="jenis_brg_keluar" class="form-label">Jenis Barang</label>
                        <input type="text" class="form-control" id="jenis_brg_keluar" name="jenis_brg_keluar" value="<?= $barang['jenis_brg_keluar']; ?>" placeholder="Jenis Barang Keluar...">
                    </div>

                    <div class="mb-3">
                        <label for="harga_jual_keluar" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual_keluar" name="harga_jual_keluar" value="<?= $barang['harga_jual_keluar']; ?>" placeholder="Harga Jual Barang ...">
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_brg_keluar" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah_brg_keluar" name="jumlah_brg_keluar" value="<?= $barang['jumlah_brg_keluar']; ?>" placeholder="Jumlah Barang ...">
                    </div>

                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="number" class="form-control" id="total_harga" name="total_harga" value="<?= $barang['total_harga']; ?>" placeholder="Total Harga ...">
                    </div>

                    <!-- <div class="mb-3">
                        <label for="gambar_brg_keluar" class="form-label">Gambar Barang</label> <br>
                        <input type="file" class="form-control mt-2" id="gambar_brg_keluar" onchange="previewImg()" name="gambar_brg_keluar" value="<?= $barang['gambar_brg_keluar']; ?>">

                        <img src="" alt="" class="img-thumbnail img-preview mt-2" width="300px">
                    </div> -->

                    <div class=" mb-3">
                        <label for="keterangan" class="form-label">keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $barang['keterangan']; ?>" placeholder="keterangan ...">
                    </div>

                    <div class=" mb-3">
                        <label for="tgl_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="tgl_keluar" name="tgl_keluar" value="<?= $barang['tgl_keluar']; ?>" placeholder="Tanggal Keluar ...">
                    </div>

                    <a href="brg_keluar.php" class="btn btn-danger" style="float: right;">Cancel</a>
                    <button type="submit" name="edit_brg_keluar" class="btn btn-warning mb-3" style="float: right; margin-right: 10px; color: white;">Edit</button>
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>


    <script>
        // preview image
        function previewImg() {
            const gambar = document.querySelector('#gambar_brg_keluar');
            const imgPreview = document.querySelector('.img-preview');

            const fileGambar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>

<?php

} else {
    header("Location: login-template.php");
    exit();
}

include 'layout/footer.php';

?>