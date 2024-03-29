<?php
session_start();
$tittle = 'Data Barang Masuk';
include 'layout/header.php';

// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {

    $data_barang = select("SELECT * FROM brg_masuk ORDER BY id DESC");
?>

    <!-- Content Wrapper. Contains page content -->

    <script src="assets-template/plugins/jquery/jquery.min.js"></script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Barang <b style="color: green;">MASUK</b></h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">



                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tabel Data Barang Masuk</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <a href="tambah-brg.php" class="btn btn-primary btn-small mb-2"> <i class="fas fa-plus"></i> Tambah</a>
                                        <table id="dataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Barang</th>
                                                    <th>Tipe Barang</th>
                                                    <th>Jenis Barang</th>
                                                    <th>Harga Beli</th>
                                                    <th>Harga Jual</th>
                                                    <th>Stok</th>
                                                    <th>Gambar Barang</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php $no = 1; ?>
                                                <?php foreach ($data_barang as $barang) : ?>
                                                    <tr>
                                                        <td> <?= $no++; ?> </td>
                                                        <td> <?= $barang['nama_brg']; ?> </td>
                                                        <td><?= $barang['tipe_brg']; ?></td>
                                                        <td><?= $barang['jenis_brg']; ?></td>
                                                        <td>Rp. <?= number_format($barang['harga_beli'], 0, ',', '.'); ?></td>
                                                        <td>Rp. <?= number_format($barang['harga_jual'], 0, ',', '.'); ?></td>
                                                        <td><?= $barang['stok'] == 0 ? "habis" : $barang['stok'];?></td>
                                                        <td><a href="assets/img/gambar_brg_masuk/<?= $barang['gambar']; ?>">
                                                                <img src="assets/img/gambar_brg_masuk/<?= $barang['gambar']; ?>" width="100px" height="100px" alt="gambar">
                                                            </a></td>
                                                        <td><?= $barang['keterangan']; ?></td>
                                                        <td><?= date('d-m-Y', strtotime($barang['tgl_masuk'])); ?></td>
                                                        <td width="15%" class="text-center">
                                                            <a href="edit-brg.php?id=<?= $barang['id']; ?>" class="btn btn-warning" style="color: white;"><i class="fas fa-edit" style="margin-right: 3px;"></i>Edit</a>
                                                            <a href="hapus-brg.php?id=<?= $barang['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin mengahapus data barang ini ?')"><i class="fas fa-trash-alt" style="margin-right: 3px;"></i>Hapus</a>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>


    <script>
        $('document').ready(function() {
            setInterval(function() {
                getBrgMasuk()
            }, 1000) //request per 2 detik
        });

        function getBrgMasuk() {
            $.ajax({
                url: "realtime-brg_masuk.php",
                type: "GET",
                success: function(response) {
                    $('#live_data').html(response)
                }
            });
        }
    </script>

<?php

} else {
    header("Location: login-template.php");
    exit();
}

include 'layout/footer.php';

?>