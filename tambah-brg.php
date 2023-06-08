<?php
session_start();
$tittle = 'Tambah Barang';
include 'layout/header.php';


// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {

    // cek apakah tombol tambah ditekan
    if (isset($_POST['tambah'])) {
        if (create_barang($_POST) > 0) {
            echo "<script>
                alert('Data Barang Berhasil Ditambahkan !');
                document.location.href = 'brg_masuk.php';
             </script>";
        } else {
            echo "<script>
                alert('Data Barang Gagal Ditambahkan !');
                document.location.href = 'brg_masuk.php';
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
                        <h1 class="m-0"> <i class="fas fa-plus"></i> Tambah Data Barang</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- <div class="note" style="border: 0.5px solid; border-radius: 7px; margin-left: 555px; margin-right: 200px; height: 780px;">
                    <h4 style="position: relative; left: 20px;"> <b>Note :</b> </h4>
                </div> -->

                <form action="" method="post" enctype="multipart/form-data" style="width: 50%; margin-left: 40px; min-height:900px">

                    <div class="mb-3">
                        <label for="nama_brg" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_brg" name="nama_brg" placeholder="Nama Barang ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_brg" class="form-label">Tipe Barang</label>
                        <input type="text" class="form-control" id="tipe_brg" name="tipe_brg" placeholder="Tipe Barang ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_brg" class="form-label">Jenis Barang</label>
                        <input type="text" class="form-control" id="jenis_brg" name="jenis_brg" placeholder="Jenis Barang ..." required>
                    </div>


                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli Barang ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual Barang ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Barang</label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="stok Barang ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Barang</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" onchange="previewImg()">

                        <img src="" alt="" class="img-thumbnail img-preview mt-2" width="300px">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan ...">
                    </div>

                    <div class="mb-3">
                        <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" placeholder="Tanggal Masuk Barang ...">
                    </div>

                    <a href="brg_masuk.php" class="btn btn-danger" style="float: right;">Cancel</a>
                    <button type="submit" name="tambah" class="btn btn-primary mb-3" style="float: right; margin-right: 10px;">Tambah</button>
                </form>

            </div>
        </section>
        <!-- /.content -->
    </div>


    <script>
        // preview image
    
        function previewImg() {
            const gambar = document.querySelector('#gambar');
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