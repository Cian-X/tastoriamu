<?php
$host = 'auth-db1866.hstgr.io';
$db   = 'u836906944_tastoria_app';
$user = 'u836906944_tastoria_admin';
$pass = 'Aslam2004.'; // Ganti jika password sudah diubah

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die('Koneksi GAGAL: ' . mysqli_connect_error());
}
echo 'Koneksi BERHASIL!';
// Hapus file ini setelah testing demi keamanan! 