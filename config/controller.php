<?php

// fungsi menampilkan data
function select($query)
{

    // panggil koneksi database
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// FUNGSI INDEX --------------------------------------------------------------------------------------------------
function getPengeluaran($month, $year){
    $pengeluaran = select("SELECT SUM(harga_beli) FROM brg_masuk WHERE MONTH(created_at) = $month AND YEAR(created_at) = $year");

    $pengeluaran_str = $pengeluaran[0]["SUM(harga_beli)"];

    return $pengeluaran_str;
}

function getPendapatan($month, $year){
    $pendapatan = select("SELECT SUM(total_harga) FROM brg_keluar WHERE MONTH(created_at) = $month AND YEAR(created_at) = $year");

    $pendapatan_str = $pendapatan[0]["SUM(total_harga)"];

    return $pendapatan_str;
}

function getBarangTerpinjam(){
    $brg_terpinjam = select("SELECT SUM(jumlah_pinjam) FROM brg_peminjaman");

    $brg_terpinjam_str = $brg_terpinjam[0]["SUM(jumlah_pinjam)"];

    return $brg_terpinjam_str;
}
// FUNGSI BARANG MASUK -------------------------------------------------------------------------------------------



//fungsi menambahkan data barang
function create_barang($post)
{

    // panggil koneksi database
    global $db;

    $nama_brg = $post['nama_brg'];
    $tipe_brg = $post['tipe_brg'];
    $jenis_brg = $post['jenis_brg'];
    $harga_beli = $post['harga_beli'];
    $harga_jual = $post['harga_jual'];
    $stok = $post['stok'];
    $gambar = upload_file();
    $keterangan = $post['keterangan'];
    $tgl_masuk = $post['tgl_masuk'];

    //cek upload file
    if (!$gambar) {
        return false;
    }

    $now = date("Y-m-d h:i:s");

    //query tambah data
    $query = "INSERT INTO brg_masuk VALUES
    (null,
    '$nama_brg',
    '$tipe_brg',
    '$jenis_brg',
    '$harga_beli',
    '$harga_jual',
    '$stok',
    '$gambar',
    '$keterangan',
    '$tgl_masuk',
    '$now')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// fungsi mengupload file 
function upload_file()
{
    $namaFile   = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error      = $_FILES['gambar']['error'];
    $tmpName    = $_FILES['gambar']['tmp_name'];

    // cek file yang diupload
    $extensifileValid   = ['jpg', 'jpeg', 'png'];
    $extensifile        = explode('.', $namaFile);
    $extensifile        = strtolower(end($extensifile));


    // cek extensi file 
    if (!in_array($extensifile, $extensifileValid)) {

        //pesan gagal
        echo "<script>
                alert('Format file tidak valid');
                document.location.href = 'brg_masuk.php';
                </script>";
        die();
    }

    //cek ukuran file 2MB
    if ($ukuranFile > 2048000) {
        //pesan gagal

        echo "<script>
                alert('Ukuran Maksimal File 2 MB');
                document.location.href = 'brg_masuk.php';
                </script>";
        die();
    }

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    //pindahkan ke folder local 
    move_uploaded_file($tmpName, 'assets/img/gambar_brg_masuk/' . $namaFileBaru);

    return $namaFileBaru;
}

// fungsi mengedit data barang

function update_barang($post)
{
    global $db;

    $id = $post['id'];

    $nama_brg = $post['nama_brg'];
    $tipe_brg = $post['tipe_brg'];
    $jenis_brg = $post['jenis_brg'];
    $harga_beli = $post['harga_beli'];
    $harga_jual = $post['harga_jual'];
    $stok = $post['stok'];
    $gambarLama = $post['gambarLama'];
    $keterangan = $post['keterangan'];
    $tgl_masuk = $post['tgl_masuk'];


    //cek upload gambar baru atau tidak
    if ($_FILES['gambar']['error'] == 4) {
        $gambar = $gambarLama;
    } else {
        //ambil gambar sesuai gambar yang dipilih
        $gambar = select("SELECT * FROM brg_masuk WHERE id = $id")[0];
        $gambar_img = $gambar["gambar"];
        
        $gambar = upload_file();

        $query_gambar_keluar = "UPDATE brg_keluar
        SET gambar_brg_keluar = '$gambar'
        WHERE gambar_brg_keluar = '$gambar_img'";
        mysqli_query($db, $query_gambar_keluar);

        $query_gambar_pinjam = "UPDATE brg_peminjaman
        SET gambar_pinjam = '$gambar'
        WHERE gambar_pinjam = '$gambar_img'";
        mysqli_query($db, $query_gambar_pinjam);

        unlink("assets/img/gambar_brg_masuk/" . $gambar_img);
    }

    //query edit data
    $query = "UPDATE brg_masuk
    SET nama_brg = '$nama_brg',
    tipe_brg = '$tipe_brg',
    jenis_brg = '$jenis_brg',
    harga_beli = '$harga_beli',
    harga_jual = '$harga_jual',
    stok = '$stok',
    gambar = '$gambar',
    keterangan = '$keterangan',
    tgl_masuk = '$tgl_masuk'
    WHERE id = $id";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//fungsi menghapus data barang
function delete_barang($id)
{
    global $db;

    //ambil gambar sesuai gambar yang dipilih
    $gambar = select("SELECT * FROM brg_masuk WHERE id = $id")[0];
    unlink("assets/img/gambar_brg_masuk/" . $gambar['gambar']);

    // query hapus data barang
    $query = "DELETE FROM brg_masuk WHERE id = $id";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// AKHIR FUNGSI BARANG MASUK -------------------------------------------------------------------------------------------



// FUNGSI PEMINJAMAN BARANG --------------------------------------------------------------------------------------------

// Create Data Peminjaman Barang
function create_barang_peminjaman($post)
{

    // panggil koneksi database
    global $db;

    $nama_peminjam = $post['nama_peminjam'];
    $alamat = $post['alamat'];
    $no_hp = $post['no_hp'];
    $tgl_awal_pinjam = $post['tgl_awal_pinjam'];
    $tgl_akhir_pinjam = $post['tgl_akhir_pinjam'];
    $nama_brg_pinjam = $post['nama_brg_pinjam'];
    // $gambar = upload_file_peminjaman();
    $gambar = $post["gambar_pinjam"];
    $jumlah_pinjam = $post['jumlah_pinjam'];
    $keterangan = $post['keterangan'];
    $status = "dalam peminjaman";
    $sisa_stok = $post['sisa_stok'];
    $id_brg_masuk = $post['id_brg_masuk'];

    //cek upload file
    if (!$gambar) {
        return false;
    }

    if ($sisa_stok >= 0){
        $query_update = "UPDATE brg_masuk SET stok = $sisa_stok WHERE id = $id_brg_masuk";
        mysqli_query($db, $query_update);
    } 

    $now = date("Y-m-d h:i:s");

    //query tambah data
    $query = "INSERT INTO brg_peminjaman VALUES
    (null,
    '$nama_peminjam',
    '$alamat',
    '$no_hp',
    '$tgl_awal_pinjam',
    '$tgl_akhir_pinjam',
    '$nama_brg_pinjam',
    '$gambar',
    '$jumlah_pinjam',
    '$keterangan',
    '$status',
    '$now')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//Upload File Peminjaman Barang
function upload_file_peminjaman()
{
    $namaFile   = $_FILES['gambar_pinjam']['name'];
    $ukuranFile = $_FILES['gambar_pinjam']['size'];
    $error      = $_FILES['gambar_pinjam']['error'];
    $tmpName    = $_FILES['gambar_pinjam']['tmp_name'];

    // cek file yang diupload
    $extensifileValid   = ['jpg', 'jpeg', 'png'];
    $extensifile        = explode('.', $namaFile);
    $extensifile        = strtolower(end($extensifile));


    // cek extensi file 
    if (!in_array($extensifile, $extensifileValid)) {

        //pesan gagal
        echo "<script>
                alert('Format file tidak valid');
                document.location.href = 'brg_peminjaman.php';
                </script>";
        die();
    }

    //cek ukuran file 2MB
    if ($ukuranFile > 2048000) {
        //pesan gagal

        echo "<script>
                alert('Ukuran Maksimal File 2 MB');
                documtirditient.location.href = 'brg_peminjaman.php';
                </script>";
        die();
    }

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    //pindahkan ke folder local 
    move_uploaded_file($tmpName, 'assets/img/gambar_peminjaman/' . $namaFileBaru);

    return $namaFileBaru;
}

//Update atau Edit Data Peminjaman Barang
function update_barang_peminjaman($post)
{
    global $db;

    $id = $post['id'];

    $nama_peminjam = $post['nama_peminjam'];
    $alamat = $post['alamat'];
    $no_hp = $post['no_hp'];
    $tgl_awal_pinjam = $post['tgl_awal_pinjam'];
    $tgl_akhir_pinjam = $post['tgl_akhir_pinjam'];
    $nama_brg_pinjam = $post['nama_brg_pinjam'];
    // $gambarLama = $post['gambarLama'];
    $jumlah_pinjam = $post['jumlah_pinjam'];
    $keterangan = $post['keterangan'];


    //cek upload gambar baru atau tidak
    // if ($_FILES['gambar_pinjam']['error'] == 4) {
    //     $gambar = $gambarLama;
    // } else {
    //     //ambil gambar sesuai gambar yang dipilih
    //     $gambar = select("SELECT * FROM brg_peminjaman WHERE id = $id")[0];
    //     unlink("assets/img/gambar_peminjaman/" . $gambar['gambar_pinjam']);
    //     $gambar = upload_file_peminjaman();
    // }


    //query edit data
    $query = "UPDATE brg_peminjaman
    SET nama_peminjam = '$nama_peminjam',
    alamat = '$alamat',
    no_hp = '$no_hp',
    tgl_awal_pinjam = '$tgl_awal_pinjam',
    tgl_akhir_pinjam = '$tgl_akhir_pinjam',
    nama_brg_pinjam = '$nama_brg_pinjam',
    jumlah_pinjam = '$jumlah_pinjam',
    keterangan = '$keterangan'
    WHERE id = $id";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// hapus data peminjaman barang
function delete_barang_peminjaman($id)
{
    global $db;

    //ambil gambar sesuai gambar yang dipilih
    // $gambar = select("SELECT * FROM brg_peminjaman WHERE id = $id")[0];
    // unlink("assets/img/gambar_peminjaman/" . $gambar['gambar']);

    // query hapus data barang peminjaman
    $query = "DELETE FROM brg_peminjaman WHERE id = $id";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function selesai_pinjam($id_brg_pinjam, $nama_brg, $jumlah){
    global $db;

    update_status_pinjam($id_brg_pinjam, 'selesai');

    $query_select_brg = select ("SELECT stok FROM brg_masuk WHERE nama_brg LIKE '%$nama_brg%'");
    $stok_prev = $query_select_brg[0]["stok"];
    $stok_akhir = $stok_prev + $jumlah;

    $query2 = "UPDATE brg_masuk SET stok = '$stok_akhir' WHERE nama_brg LIKE '%$nama_brg%'";
    mysqli_query($db, $query2);

    return mysqli_affected_rows($db);
}

function update_status_pinjam($id, $status){
    global $db;

    $query = "UPDATE brg_peminjaman SET status = '$status' WHERE id = $id";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// AKHIR FUNGSI PEMINJAMAN BARANG --------------------------------------------------------------------------------------------

// FUNGSI BARANG KELUAR ------------------------------------------------------------------------------------------------------

function create_barang_keluar($post)
{

    // panggil koneksi database
    global $db;

    $nama_brg_keluar = $post['nama_brg_keluar'];
    $tipe_brg_keluar = $post['tipe_brg_keluar'];
    $jenis_brg_keluar = $post['jenis_brg_keluar'];
    $harga_jual_keluar = $post['harga_jual_keluar'];
    $jumlah_brg_keluar = $post['jumlah_brg_keluar'];
    $total_harga = $post['total_harga'];
    $gambar = $post['gambar'];
    $keterangan = $post['keterangan'];
    $tgl_keluar = $post['tgl_keluar'];
    $sisa_stok = $post["sisa_stok"];
    $id_brg_masuk = $post["id_brg_masuk"];

    //cek upload file
    if (!$gambar) {
        return false;
    }

    $now = date("Y-m-d h:i:s");

    // kurangin stok barang_masuk
    if ($sisa_stok >= 0){
        $query_update = "UPDATE brg_masuk SET stok = $sisa_stok WHERE id = $id_brg_masuk";
        mysqli_query($db, $query_update);
    } 

     //query tambah data
     $query = "INSERT INTO brg_keluar VALUES
     (null,
     '$nama_brg_keluar',
     '$tipe_brg_keluar',
     '$jenis_brg_keluar',
     '$harga_jual_keluar',
     '$jumlah_brg_keluar',
     '$total_harga',
     '$gambar',
     '$keterangan',
     '$tgl_keluar',
     '$now')";
     mysqli_query($db, $query);
     return mysqli_affected_rows($db);

}

// fungsi mengupload file 
function upload_file_brg_keluar()
{
    $namaFile   = $_FILES['gambar_brg_keluar']['name'];
    $ukuranFile = $_FILES['gambar_brg_keluar']['size'];
    $error      = $_FILES['gambar_brg_keluar']['error'];
    $tmpName    = $_FILES['gambar_brg_keluar']['tmp_name'];

    // cek file yang diupload
    $extensifileValid   = ['jpg', 'jpeg', 'png'];
    $extensifile        = explode('.', $namaFile);
    $extensifile        = strtolower(end($extensifile));


    // cek extensi file 
    if (!in_array($extensifile, $extensifileValid)) {

        //pesan gagal
        echo "<script>
                alert('Format file tidak valid');
                // document.location.href = 'brg_keluar.php';
                </script>";
        die();
    }

    //cek ukuran file 2MB
    if ($ukuranFile > 2048000) {
        //pesan gagal

        echo "<script>
                alert('Ukuran Maksimal File 2 MB');
                document.location.href = 'brg_keluar.php';
                </script>";
        die();
    }

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    //pindahkan ke folder local 
    move_uploaded_file($tmpName, 'assets/img/gambar_brg_keluar/' . $namaFileBaru);

    return $namaFileBaru;
}

// fungsi mengedit data barang

function update_barang_keluar($post)
{
    global $db;

    $id = $post['id'];

    $nama_brg_keluar = $post['nama_brg_keluar'];
    $tipe_brg_keluar = $post['tipe_brg_keluar'];
    $jenis_brg_keluar = $post['jenis_brg_keluar'];
    $harga_jual_keluar = $post['harga_jual_keluar'];
    $jumlah_brg_keluar = $post['jumlah_brg_keluar'];
    $total_harga = $post['total_harga'];
    // $gambarLama = $post['gambarLama'];
    $keterangan = $post['keterangan'];
    $tgl_keluar = $post['tgl_keluar'];


    //cek upload gambar baru atau tidak
    // if ($_FILES['gambar_brg_keluar']['error'] == 4) {
    //     $gambar = $gambarLama;
    // } else {
    //     //ambil gambar sesuai gambar yang dipilih
    //     $gambar = select("SELECT * FROM brg_keluar WHERE id = $id")[0];
    //     unlink("assets/img/gambar_brg_keluar/" . $gambar['gambar_brg_keluar']);
    //     $gambar = upload_file_brg_keluar();
        
    // }


    //query edit data
    $query = "UPDATE brg_keluar
    SET nama_brg_keluar = '$nama_brg_keluar',
    tipe_brg_keluar = '$tipe_brg_keluar',
    jenis_brg_keluar = '$jenis_brg_keluar',
    harga_jual_keluar = '$harga_jual_keluar',
    jumlah_brg_keluar = '$jumlah_brg_keluar',
    total_harga = '$total_harga',
    keterangan = '$keterangan',
    tgl_keluar = '$tgl_keluar'
    WHERE id = $id";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// hapus data peminjaman barang
function delete_barang_keluar($id)
{
    global $db;

    //ambil gambar sesuai gambar yang dipilih
    $gambar = select("SELECT * FROM brg_keluar WHERE id = $id")[0];

    // query hapus data barang peminjaman
    $query = "DELETE FROM brg_keluar WHERE id = $id";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// AKHIR FUNGSI BARANG KELUAR ------------------------------------------------------------------------------------------------