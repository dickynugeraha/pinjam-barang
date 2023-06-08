<?php
session_start();
$tittle = 'Tambah Peminjaman Barang';
include 'layout/header.php';


// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {

    // cek apakah tombol tambah ditekan
    if (isset($_POST['tambah-peminjaman'])) {
        if (create_barang_peminjaman($_POST) > 0) {
            echo "<script>
                alert('Data Peminjaman Barang Berhasil Ditambahkan !');
                document.location.href = 'brg_peminjaman.php';
             </script>";
        } else {
            echo "<script>
                alert('Data Peminjaman Barang Gagal Ditambahkan !');
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
                        <h1 class="m-0"> <i class="fas fa-plus"></i> Tambah Data Peminjaman Barang</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="" method="post" enctype="multipart/form-data" style="width: 50%; margin-left: 40px; min-height:1000px">
                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" placeholder="Nama Peminjam ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="address" class="form-control" id="alamat" name="alamat" placeholder="Alamat ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No. Handphone</label>
                        <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="No. Handphone ..." required>
                    </div>


                    <div class="mb-3">
                        <label for="tgl_awal_pinjam" class="form-label">Tanggal Awal Peminjaman</label>
                        <input type="date" class="form-control" id="tgl_awal_pinjam" name="tgl_awal_pinjam" placeholder="Tanggan Awal Peminjamanng ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_akhir_pinjam" class="form-label">Tanggal Akhir Peminjaman</label>
                        <input type="date" class="form-control" id="tgl_akhir_pinjam" name="tgl_akhir_pinjam" placeholder="Tanggan Akhir Peminjamanng ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_brg_pinjam" class="form-label">Nama Barang Dipinjam</label>
                        <input type="text" class="form-control" id="nama_brg_pinjam" name="nama_brg_pinjam" placeholder="Nama Barang Dipinjam ..." required>
                    </div>

                    <input type="text" class="form-control" id="gambar_pinjam" name="gambar_pinjam" hidden>
                    <input type="text" class="form-control" id="id_brg_masuk" name="id_brg_masuk" hidden>
                    <input type="text" class="form-control" id="sisa_stok" name="sisa_stok" hidden>

                    <div class="mb-3">
                        <label for="gambar_pinjam" class="form-label">Gambar Barang</label><br>

                        <img src="" alt="" class="img-thumbnail img-preview mt-2" width="300px">
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_pinjam" class="form-label">Jumlah Peminjaman Barang</label>
                        <input type="number" class="form-control" id="jumlah_pinjam" name="jumlah_pinjam" placeholder="Jumlah Peminjaman Barang ...">
                    </div>


                    <div class="mb-3">
                        <label for="keterangan" class="form-label">keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan ...">
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control" id="status" name="status" placeholder="status ..." hidden>
                    </div>

                    <a href="brg_peminjaman.php" class="btn btn-danger" style="float: right;">Cancel</a>
                    <button type="submit" name="tambah-peminjaman" class="btn btn-primary mb-3" style="float: right; margin-right: 10px;">Tambah</button>
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

        $(function(){
            $("#nama_brg_pinjam").autocomplete({
                source: "autofill/autofil-brg-keluar.php"
            });
	    });

        $(function(){
            $("#nama_brg_pinjam").keyup(function(e){
                let input = e.target.value;
                if (input == ""){
                    $("#tipe_brg_keluar").val("");
                    $("#jenis_brg_keluar").val("");
                    $("#harga_jual_keluar").val("");
                    $("#keterangan").val("");
                    $("#jumlah_pinjam").val("")
                    $("#total_harga").val("")
                    $(".img-preview").attr({
                            "src": ""
                    })
                }
            })  
        
	    });
        

        let obj_brg = new Object();
        $(function(){
            $("#nama_brg_pinjam").blur(function(e){
                let query = e.target.value;
                $.ajax({
                    url: "autofill/query-brg-keluar.php",
                    data: "query="+query,
                }).success(function(data){
                    let obj_data = JSON.parse(data);
                    obj_brg = obj_data;
                    console.log(obj_brg);

                    if (query == ""){
                        $("#tipe_brg_keluar").val("");
                        $("#jenis_brg_keluar").val("");
                        $("#harga_jual_keluar").val("");
                        $("#keterangan").val("");
                        $("#jumlah_pinjam").val("")
                        $("#total_harga").val("")
                        $(".img-preview").attr({
                            "src": ""
                        })
                        return;
                    } 

                    $("#tipe_brg_keluar").val(obj_brg.tipe_brg);
                    $("#jenis_brg_keluar").val(obj_brg.jenis_brg);
                    $("#harga_jual_keluar").val(obj_brg.harga_jual);
                    $("#jumlah_pinjam").attr({
                        "min": 1,
                        "max": parseInt(obj_brg.stok)
                    })
                    $(".img-preview").attr({
                        "src": "assets/img/gambar_brg_masuk/"+obj_brg.gambar
                    })
                })
            });
	    });


        $(function(){
            $("#jumlah_pinjam").keyup(function(e){
                let input = e.target.value;

                if (input > parseInt(obj_brg.stok)){
                    $("#jumlah_pinjam").val(1);
                    alert(`Stok barang ini adalah ${obj_brg.stok}, jumlah barang input jangan melebihi stok yang tersedia`);
                    return;
                }
                $("#sisa_stok").val(parseInt(obj_brg.stok) - input)
                $("#id_brg_masuk").val(obj_brg.id)
                $("#gambar_pinjam").val(obj_brg.gambar)
                $("#total_harga").val(input * parseInt(obj_brg.harga_jual))
            })
        })
    </script>


<?php
} else {
    header("Location: login-template.php");
    exit();
}


include 'layout/footer.php';
?>