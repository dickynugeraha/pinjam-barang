<?php
session_start();
$tittle = 'Edit Data Peminjaman Barang';
include 'layout/header.php';

// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {





    //mengambil id barang dari URL
    $id = (int)$_GET['id'];

    $pinjam = select("SELECT * FROM brg_peminjaman WHERE id = $id")[0];

    // cek apakah tombol tambah ditekan
    if (isset($_POST['edit-pinjam'])) {
        if (update_barang_peminjaman($_POST) > 0) {
            echo "<script>
                alert('Data Barang Berhasil Diperbaharui !');
                document.location.href = 'brg_peminjaman.php';
             </script>";
        } else {
            echo "<script>
                alert('Data Barang Gagal Diperbaharui !');
                document.location.href = 'brg_peminjaman.php';
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
                        <h1 class="m-0"><i class="fas fa-edit"></i> Edit Data Peminjaman Barang</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="" method="post" enctype="multipart/form-data" style="width: 50%; margin-left: 40px; min-height:1000px">
                    <input type="hidden" name="id" value="<?= $pinjam['id']; ?>">
                    <input type="hidden" name="gambarLama" value="<?= $pinjam['gambar_pinjam']; ?>">

                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="<?= $pinjam['nama_peminjam']; ?>" placeholder="Nama Peminjam ...">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $pinjam['alamat']; ?>" placeholder="Alamat ...">
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No. Handphone</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $pinjam['no_hp']; ?>" placeholder="No. Handphone ...">
                    </div>

                    <div class=" mb-3">
                        <label for="tgl_awal_pinjam" class="form-label">Tanggal Awal Pinjam</label>
                        <input type="date" class="form-control" id="tgl_awal_pinjam" name="tgl_awal_pinjam" value="<?= $pinjam['tgl_awal_pinjam']; ?>" placeholder=" Tanggal Awal Pinjam ...">
                    </div>

                    <div class=" mb-3">
                        <label for="tgl_akhir_pinjam" class="form-label">Tanggal Akhir Pinjam</label>
                        <input type="date" class="form-control" id="tgl_akhir_pinjam" name="tgl_akhir_pinjam" value="<?= $pinjam['tgl_akhir_pinjam']; ?>" placeholder=" Tanggal Akhir Pinjam ...">
                    </div>

                    <div class=" mb-3">
                        <label for="nama_brg_pinjam" class="form-label">Nama Barang Dipinjam</label>
                        <input type="text" class="form-control" id="nama_brg_pinjam" name="nama_brg_pinjam" value="<?= $pinjam['nama_brg_pinjam']; ?>" placeholder="Nama Barang Dipinjam ...">
                    </div>

                    <!-- <div class="mb-3">
                        <label for="gambar_pinjam" class="form-label">Gambar Barang</label> <br>
                        <input type="file" class="form-control mt-2" id="gambar_pinjam" onchange="previewImg()" name="gambar_pinjam" value="<?= $pinjam['gambar_pinjam']; ?>">

                        <img src="" alt="" class="img-thumbnail img-preview mt-2" width="300px">
                    </div> -->

                    <div class=" mb-3">
                        <label for="jumlah_pinjam" class="form-label">Jumlah Peminjaman Barang</label>
                        <input type="number" class="form-control" id="jumlah_pinjam" name="jumlah_pinjam" value="<?= $pinjam['jumlah_pinjam']; ?>" placeholder="Jumlah Peminjaman Barang ...">
                    </div>

                    <div class=" mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $pinjam['keterangan']; ?>" placeholder="keterangan ...">
                    </div>

                    <!-- <div class=" mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="<?= $pinjam['status']; ?>" placeholder="status ...">
                    </div> -->

                    <a href="brg_peminjaman.php" class="btn btn-danger" style="float: right;">Cancel</a>
                    <button type="submit" name="edit-pinjam" class="btn btn-warning mb-3" style="float: right; margin-right: 10px; color: white;">Edit</button>
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <script>
        // preview image
        function previewImg() {
            const gambar = document.querySelector('#gambar_pinjam');
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