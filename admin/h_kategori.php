<?php
include "koneksi.php";
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM tb_kategori WHERE id_kategori = '$id'");

if ($hapus) {
    echo "<script>alert('Data berhasil dihapus!')</script>";
    header('location:kategori.php');
} else {
    echo "<script>alert('Data gagal dihapus!')</script>";
    header('location:kategori.php');
}
?>