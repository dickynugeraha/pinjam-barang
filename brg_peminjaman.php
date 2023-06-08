<?php
session_start();
$tittle = 'Data Peminjaman Barang';
include 'layout/header.php';

// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {

    $data_pinjam = select("SELECT * FROM brg_peminjaman ORDER BY id DESC");
?>


    <!-- Content Wrapper. Contains page content -->

    <script src="assets-template/plugins/jquery/jquery.min.js"></script>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Barang <b>PEMINJAM</b></h1>
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
                                        <h3 class="card-title">Tabel Data Peminjaman Barang</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="width: auto;">
                                        <a href="tambah-pinjam.php" class="btn btn-primary btn-small mb-2"> <i class="fas fa-plus"></i> Tambah</a>
                                        <table id="dataTable" class="table table-bordered table-hover">
                                            <thead >
                                                <tran>
                                                    <th>No</th>
                                                    <th>Nama Peminjam</th>
                                                    <th>Alamat</th>
                                                    <th>No. Handphone</th>
                                                    <th>Tanggal Pinjam</th>
                                                    <th>Tanggal Kembali</th>
                                                    <th>Nama Barang</th>
                                                    <th>Gambar Barang</th>
                                                    <th>Jumlah Barang</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tran>
                                            </thead>
                                            <tbody>
                                                <script>
                                                        let tgl_akhir = ``;
                                                        let today = ``;
                                                        let hari = ``;
                                                        let bulan = ``;
                                                        let tahun = ``;
                                                        let sekarang = ``;
                                                        let status = ``;

                                                </script>
                                                <?php $no = 1; ?>
                                                <?php foreach ($data_pinjam as $pinjam) : ?>
                                                <script>

                                                <?php   
                                                        $id_brg = $pinjam['id'];
                                                        $tgl_akhir_pinjam = $pinjam['tgl_akhir_pinjam'];
                                                        $status = $pinjam['status'];
                                                 ?>
                                                        tgl_akhir = `<?php echo "$tgl_akhir_pinjam" ?>`;
                                                        status = `<?php echo "$status" ?>`;

                                                        today = new Date(Date.now());
                                                        hari = today.getUTCDate();
                                                        bulan = today.getUTCMonth();
                                                        tahun = today.getUTCFullYear();
                                                        sekarang = tahun + "-" + (parseInt(bulan) + 1) + "-" + (parseInt(hari) + 1);

                                                        tgl_akhir = new Date(tgl_akhir);
                                                        hari = tgl_akhir.getUTCDate();
                                                        bulan = tgl_akhir.getUTCMonth();
                                                        tahun = tgl_akhir.getUTCFullYear();
                                                        tanggal_kembali = tahun + "-" + (parseInt(bulan) + 1) + "-" + hari;

                                                        console.log("sekarang: ", sekarang);
                                                        console.log("tanggal kembali: ", tanggal_kembali);

                                                        console.log(tanggal_kembali == sekarang);

                                                        if (sekarang == tanggal_kembali) {
                                                            if (status != 'selesai'){
                                                                $.ajax({
                                                                    url: "ubah-status-pinjam.php",
                                                                    data:{
                                                                        id: `<?php echo "$id_brg" ?>`,
                                                                        status: "deadline",
                                                                    },
                                                                    async: true,
                                                                })
                                                            }
                                                        } else if (new Date(tanggal_kembali) > new Date(sekarang)){
                                                            if (status != 'selesai'){
                                                                $.ajax({
                                                                    url: "ubah-status-pinjam.php",
                                                                    data:{
                                                                        id: `<?php echo "$id_brg" ?>`,
                                                                        status: "dalam peminjaman",
                                                                    },
                                                                    async: true,
                                                                })
                                                            }
                                                        } else if (new Date(tanggal_kembali) < new Date(sekarang)){
                                                            if (status != 'selesai'){
                                                                $.ajax({
                                                                    url: "ubah-status-pinjam.php",
                                                                    data:{
                                                                        id: `<?php echo "$id_brg" ?>`,
                                                                        status: "urgent",
                                                                    },
                                                                    async: true,
                                                                })
                                                            }
                                                        }
                                                    </script>

                                                    <?php 
                                                        $statusCSS = "";
                                                        
                                                        switch ($pinjam["status"]) {
                                                            case 'selesai':
                                                                $statusCSS = "selesai";
                                                                break;
                                                            case 'dalam peminjaman':
                                                                $statusCSS = "dalam-peminjaman";
                                                                break;
                                                            case 'deadline':
                                                                $statusCSS = "deadline";
                                                                break;
                                                            case 'urgent':
                                                                $statusCSS = "urgent";
                                                                break; 
                                                        }
                                                      
                                                    ?>

                                                  

                                                    <tr>
                                                        <td> <?= $no++ ?> </td>
                                                        <td> <?= $pinjam['nama_peminjam']; ?> </td>
                                                        <td><?= $pinjam['alamat']; ?></td>
                                                        <td><?= $pinjam['no_hp']; ?></td>
                                                        <td><?= date('d-m-Y', strtotime($pinjam['tgl_awal_pinjam'])); ?></td>
                                                        <td><?= date('d-m-Y', strtotime($pinjam['tgl_akhir_pinjam'])); ?></td>
                                                        <td><?= $pinjam['nama_brg_pinjam']; ?></td>
                                                        <td>
                                                            <a href="assets/img/gambar_brg_masuk/<?= $pinjam['gambar_pinjam']; ?>">
                                                                <img src="assets/img/gambar_brg_masuk/<?= $pinjam['gambar_pinjam']; ?>" width="100px" height="100px" alt="gambar">
                                                            </a>
                                                        </td>
                                                        <td><?= $pinjam['jumlah_pinjam']; ?></td>
                                                        <td><?= $pinjam['keterangan']; ?></td>
                                                        <td class="<?php echo $statusCSS ?>"><?= $pinjam['status']; ?></td>
                                                        <td width="16%" class="text-center">
                                                            <a href="edit-pinjam.php?id=<?= $pinjam['id']; ?>" class="btn btn-warning btn-sm" style="color: white;"><i class="fas fa-edit" style="margin-right: 3px; color: white;"></i>Edit</a>
                                                            <a href="hapus-pinjam.php?id=<?= $pinjam['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin mengahapus data peminjaman barang ini ?')"><i class="fas fa-trash-alt" style="margin-right: 3px;"></i>Hapus</a>
                                                            <a href="selesai-pinjam.php?id=<?= $pinjam['id']; ?>&nama_brg=<?php echo $pinjam['nama_brg_pinjam'];?>&jumlah=<?php echo $pinjam['jumlah_pinjam'];?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi Barang Selesai Dipinjam ?')"><i class="fas fa-check" style="margin-right: 3px;"></i>Selesai</a>
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
    
    

<?php

} else {
    header("Location: login-template.php");
    exit();
}

include 'layout/footer.php';

?>