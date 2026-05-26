<?php
session_start(); // <-- Kunci utama agar variabel $_SESSION tidak undefined!
include 'koneksi.php';

// Cek apakah user sudah login dan pastikan dia adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak! Hanya Admin yang bisa menghapus data! ✋🥋'); window.location='index.php';</script>";
    exit;
}

// Proses hapus data jika ID ditemukan
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil nama anggota dulu untuk notifikasi pemanis
    $cari_nama = mysqli_query($koneksi, "SELECT nama FROM users WHERE id = '$id'");
    $data_nama = mysqli_fetch_assoc($cari_nama);
    $nama_pesilat = $data_nama['nama'];

    // Eksekusi hapus data
    $query_hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id'");
    
    if ($query_hapus) {
        echo "<script>alert('Data pendekar $nama_pesilat berhasil dihapus! 🧼'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Aduh, gagal menghapus data karena: " . mysqli_error($koneksi) . " 😭'); window.location='index.php';</script>";
    }
} else {
    header("location:index.php");
}
?>