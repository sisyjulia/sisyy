<?php
include 'koneksi.php';

if (isset($_POST['tambah']) || isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5('12345'); // Set password default biar tidak kosong
    $role     = 'users';

    // Menambah data ke tabel users yang tersedia
    $query = mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");

    if ($query) {
        echo "<script>
                alert('Data berhasil ditambahkan! 🦅');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambah data: " . mysqli_error($koneksi) . "');
                window.location.href = 'tambah.php';
              </script>";
    }
}
?>