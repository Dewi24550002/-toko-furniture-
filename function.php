<?php
function registrasi($data) {
    global $koneksi;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($koneksi, $data['password']);
    $password2 = mysqli_real_escape_string($koneksi, $data['password2']);
    $status = "customer"; //Default status customer

    // Ambil ID terakhir dari tb_user
    $auto = mysqli_query($koneksi, "SELECT MAX(id_user) AS max_code FROM tb_user");
    $hasil = mysqli_fetch_array($auto);
    $code = $hasil['max_code'];

    // Menghasilkan Id baru dengan format U001, U002, dst.
    $urutan = (int)substr($code, 1, 3);
    $urutan++;
    $huruf = "U";
    $id_user = $huruf . sprintf("%03s", $urutan);

    // Cek apakah username sudah ada
    $result = mysqli_query($koneksi, "SELECT username FROM tb_user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username sudah terdaftar');
        </script>";
        return false;
    }

    // cek konfirmasi password
if ($password !== $password2) {
    echo "<script>
    alert('Konfirmasi password tidak sesuai');
    </script>";
    return false;
}

// enkripsi password
$password = password_hash($password, PASSWORD_DEFAULT);

// Tambahkan user baru ke database
$querry = "INSERT INTO tb_user (id_user, username, password, status) VALUES ('$id_user', '$username', '$password', '$status')";
mysqli_query($koneksi, $querry);

return mysqli_affected_rows($koneksi);
}
?>