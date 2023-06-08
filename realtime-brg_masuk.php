<?php
include 'config/app.php';

$data_barang = select("SELECT * FROM brg_masuk ORDER BY id DESC");
?>



<?php $no = 1; ?>
<?php foreach ($data_barang as $barang) : ?>
    <tr>
        <td> <?= $no++; ?> </td>
        <td> <?= $barang['nama_brg']; ?> </td>
        <td><?= $barang['tipe_brg']; ?></td>
        <td><?= $barang['jenis_brg']; ?></td>
        <td>Rp. <?= number_format($barang['harga_beli'], 0, ',', '.'); ?></td>
        <td>Rp. <?= number_format($barang['harga_jual'], 0, ',', '.'); ?></td>
        <td><?= $barang['stok']; ?></td>
        <td><a href="assets/img/<?= $barang['gambar']; ?>">
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


