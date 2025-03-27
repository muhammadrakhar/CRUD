<?php
function open_connection() {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "akademik";

    // Mencoba koneksi ke database
    $koneksi = mysqli_connect($hostname, $username, $password, $dbname);

    // Cek apakah koneksi berhasil atau gagal
    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    } else {
        echo "Koneksi berhasil!";
    }

    return $koneksi;
}

// Tes koneksi
open_connection();
?>
