<?php
include 'admin/koneksi.php';
session_start();

if (!(isset($_SESSION['id_user']))) {
    echo "<script>alert('Silahkan login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $id_pesanan => $jumlah) {
        if ($jumlah >= 1) {
            #ambil id_produk dari id_pesanan untuk cek stok
            $query_produk = "SELECT pr.id_produk, pr.stok FROM tb_pesanan p JOIN tb_produk pr ON p.id_produk = pr.id_produk WHERE id_pesanan = '$id_pesanan'";
            $res = mysqli_query($koneksi, $query_produk);
            $produk = mysqli_fetch_assoc($res);

            if ($jumlah <= $produk['stok']) {
                #update qty dan total
                $query_update = "UPDATE tb_pesanan p
                                 JOIN tb_produk pr ON p.id_produk = pr.id_produk
                                 SET p.qty = '$jumlah', p.total = (pr.harga * $jumlah)
                                 WHERE p.id_pesanan = '$id_pesanan'";
                mysqli_query($koneksi, $query_update);
            } else {
                echo "<script>alert('Jumlah melebihi stok!'); window.location='belanja.php';</script>";
                exit;
            }
        }
    }
}
echo "<script>alert('Jumlah produk berhasil diperbarui!'); window.location.href = 'cart.php';
    </script>";
exit;

?>