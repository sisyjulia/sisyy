<?php
include 'koneksi.php';

// HAPUS atau KOMENTARI dulu baris IF ISS-ET nya biar kodenya langsung dieksekusi:
// if (isset($_POST['tambah']) || isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5('12345'); 
    $role     = 'users';

    // Kita tes apakah data username-nya masuk atau kosong
    echo "Username yang dikirim: " . $username . "<br>";

    $query = mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");

    if ($query) {
        echo "Hebat! Data berhasil masuk ke database.";
    } else {
        // Ini akan memunculkan pesan error asli dari MySQL jika ada kolom yang salah
        echo "Gagal masuk database karena: " . mysqli_error($koneksi);
    }

    // Kita stop kodingannya di sini dulu biar gak langsung pindah halaman
    die(); 
?>