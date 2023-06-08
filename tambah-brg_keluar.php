<?php
session_start();
$tittle = 'Tambah Barang Keluar';
include 'layout/header.php';


// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {

    // cek apakah tombol tambah ditekan
    if (isset($_POST['tambah_brg_keluar'])) {
        if (create_barang_keluar($_POST) > 0) {
            echo "<script>
                alert('Data Barang Berhasil Ditambahkan !');
                document.location.href = 'brg_keluar.php';
             </script>";
        } else {
            echo "<script>
                alert('Data Barang Gagal Ditambahkan !');
                document.location.href = 'brg_keluar.php';
             </script>";
        }
    }
?>
        
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1200px;">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> <i class="fas fa-plus"></i> Tambah Data Barang Keluar</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
                <!-- <div class="note" style="border: 0.5px solid; border-radius: 7px; margin-left: 555px; margin-right: 200px; height: 780px;">
                    <h4 style="position: relative; left: 20px;"> <b>Note :</b> </h4>
                </div> -->

                <form action="" method="post" enctype="multipart/form-data" style="width: 50%; margin-left: 40px; min-height:900px">
                    <div class="mb-3">
                        <label for="nama_brg_keluar" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_brg_keluar" name="nama_brg_keluar" placeholder="Nama Barang Keluar..." required>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_brg_keluar" class="form-label">Tipe Barang</label>
                        <input type="text" class="form-control" id="tipe_brg_keluar" name="tipe_brg_keluar" placeholder="Tipe Barang Keluar ..." required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_brg_keluar" class="form-label">Jenis Barang</label>
                        <input type="text" class="form-control" id="jenis_brg_keluar" name="jenis_brg_keluar" placeholder="Jenis Barang Keluar ..." required readonly>
                    </div>


                    <div class="mb-3">
                        <label for="harga_jual_keluar" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual_keluar" name="harga_jual_keluar" placeholder="Harga Jual Barang ..." required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_brg_keluar" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah_brg_keluar" name="jumlah_brg_keluar" placeholder="Jumlah Barang ..." required>
                    </div>
                    
                    <input type="text" class="form-control" id="sisa_stok" name="sisa_stok" hidden>
                    <input type="text" class="form-control" id="id_brg_masuk" name="id_brg_masuk" hidden>
                    <input type="text" class="form-control" id="gambar" name="gambar" hidden>

                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="number" class="form-control" id="total_harga" name="total_harga" placeholder="Total harga ..." required readonly>
                    </div>

                    <div class="mb-3">
                        <img src="" alt="" class="img-thumbnail img-preview mt-2" width="300px">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan ..." readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="tgl_keluar" name="tgl_keluar" placeholder="Tanggal Keluar Barang ...">
                    </div>

                    <div class="mt-2">
                        <a href="brg_keluar.php" class="btn btn-danger" style="float: right;">Cancel</a>
                        <button type="submit" name="tambah_brg_keluar" class="btn btn-primary mb-3" style="float: right; margin-right: 10px;">Tambah</button>
                    </div>
                </form>

        </section>
        <!-- /.content -->
    </div>


    <script type="text/javascript">
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
 

        $(function(){
            $("#nama_brg_keluar").autocomplete({
                source: "autofill/autofil-brg-keluar.php"
            });
	    });

        $(function(){
            $("#nama_brg_keluar").keyup(function(e){
                let input = e.target.value;
                if (input == ""){
                    $("#tipe_brg_keluar").val("");
                    $("#jenis_brg_keluar").val("");
                    $("#harga_jual_keluar").val("");
                    $("#keterangan").val("");
                    $("#jumlah_brg_keluar").val("")
                    $("#total_harga").val("")
                    $(".img-preview").attr({
                            "src": ""
                    })
                }
            })  
        
	    });
        

        let obj_brg = new Object();
        $(function(){
            $("#nama_brg_keluar").blur(function(e){
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
                        $("#jumlah_brg_keluar").val("")
                        $("#total_harga").val("")
                        $(".img-preview").attr({
                            "src": ""
                        })
                        return;
                    } 

                    $("#tipe_brg_keluar").val(obj_brg.tipe_brg);
                    $("#jenis_brg_keluar").val(obj_brg.jenis_brg);
                    $("#harga_jual_keluar").val(obj_brg.harga_jual);
                    $("#keterangan").val(obj_brg.keterangan);
                    $("#jumlah_brg_keluar").attr({
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
            $("#jumlah_brg_keluar").keyup(function(e){
                let input = e.target.value;

                if (input > parseInt(obj_brg.stok)){
                    $("#jumlah_brg_keluar").val(1);
                    alert(`Stok barang ini adalah ${obj_brg.stok}, jumlah barang input jangan melebihi stok yang tersedia`);
                    return;
                }
                $("#sisa_stok").val(parseInt(obj_brg.stok) - input)
                $("#id_brg_masuk").val(obj_brg.id)
                $("#gambar").val(obj_brg.gambar)
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