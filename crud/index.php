<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
    exit;
}

$nama_user = $_SESSION['nama'];
$role_user = $_SESSION['role'];

// Ambil data anggota dari database
$query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="logo_pd.jpeg" type="image/jpeg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota Perisai Diri</title>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Varela Round', sans-serif;
            /* Warnanya tetap pakai perpaduan biru muda pastel dengan background gambar1.jpg */
            background-image: linear-gradient(rgba(186, 230, 253, 0.65), rgba(224, 242, 254, 0.75)), url('gambar1.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            padding: 30px 15px;
            margin: 0;
        }

        /* Banner Selamat Datang */
        .welcome-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 20px 30px;
            border: 3px solid #FFF9C4;
            box-shadow: 0 10px 25px rgba(14, 165, 233, 0.15);
            margin-bottom: 25px;
        }

        .welcome-text {
            font-size: 1.3rem;
            font-weight: bold;
            color: #0369A1;
        }

        .badge-role {
            font-size: 0.8rem;
            padding: 6px 15px;
            border-radius: 50px;
            background-color: #EF5350; /* Sentuhan merah khas seragam PD */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 2px 5px rgba(239, 83, 80, 0.3);
        }

        .btn-logout {
            background: linear-gradient(135deg, #FF8A80 0%, #FF5252 100%);
            color: white;
            font-weight: bold;
            padding: 8px 25px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 4px 10px rgba(255, 82, 82, 0.2);
            transition: transform 0.2s;
        }
        .btn-logout:hover {
            transform: scale(1.05);
            color: white;
            box-shadow: 0 0 12px #FFF176;
        }

        /* Container Utama */
        .main-container {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 35px;
            border: 3px solid #FFF9C4;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15), 0 0 0 4px #FFCDD2;
            position: relative;
            overflow: hidden;
        }

        /* Hiasan Silat di Sudut */
        .main-container::before {
            content: '🥋✨';
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            opacity: 0.6;
        }
        .main-container::after {
            content: '🦅 🌸';
            position: absolute;
            bottom: 10px;
            left: 20px;
            font-size: 1.2rem;
            opacity: 0.5;
        }

        /* Header Judul (Kuning Soft) */
        .header-table-area {
            background-color: #FFF9C4;
            border-radius: 20px;
            padding: 15px 25px;
            margin-bottom: 25px;
            border: 2px dashed #FFCDD2;
        }

        .table-title {
            color: #0369A1;
            font-weight: bold;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .slogan-pd {
            font-size: 0.8rem;
            color: #EF5350;
            font-weight: bold;
            display: block;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .mini-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
            filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.1));
        }

        .btn-add {
            background: linear-gradient(135deg, #38BDF8 0%, #0284C7 100%);
            color: white;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
            transition: all 0.3s;
        }
        .btn-add:hover {
            transform: scale(1.05);
            color: white;
            box-shadow: 0 0 15px #FFF176;
        }

        /* Desain Tabel */
        .table-responsive {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        }

        .custom-table {
            margin-bottom: 0;
            background-color: white !important;
        }

        .custom-table thead {
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
            color: #475569;
            font-weight: bold;
        }

        .custom-table th {
            padding: 16px !important;
            border-bottom: 3px solid #E2E8F0 !important;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-table td {
            padding: 14px 12px !important;
            vertical-align: middle;
            color: #334155;
            font-size: 0.95rem;
        }

        /* Badge Kelas & Sabuk (Dibuat bertema silat pastel) */
        .badge-kelas {
            background-color: #E0F2FE;
            color: #0369A1;
            border: 1px solid #BDE0FE;
            font-weight: bold;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        /* Role disamakan warnanya dengan tema strip sabuk */
        .badge-table-user { background-color: #94A3B8; color: white; font-weight: bold; font-size: 0.75rem; padding: 5px 12px; border-radius: 50px; }
        .badge-table-admin { background-color: #0284C7; color: white; font-weight: bold; font-size: 0.75rem; padding: 5px 12px; border-radius: 50px; }

        .username-style {
            color: #DB2777;
            font-weight: bold;
        }

        /* Tombol Aksi */
        .btn-ubah {
            background-color: #FCD34D;
            color: #78350F;
            font-weight: bold;
            font-size: 0.85rem;
            padding: 6px 16px;
            border-radius: 50px;
            border: none;
            transition: 0.2s;
        }
        .btn-ubah:hover { background-color: #FBBF24; transform: scale(1.05); color: #78350F; }

        .btn-hapus {
            background-color: #FCA5A5;
            color: #7F1D1D;
            font-weight: bold;
            font-size: 0.85rem;
            padding: 6px 16px;
            border-radius: 50px;
            border: none;
            transition: 0.2s;
        }
        .btn-hapus:hover { background-color: #F87171; transform: scale(1.05); color: #7F1D1D; }
    </style>
</head>
<body>

    <div class="container">
        <div class="welcome-container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span class="welcome-text">Selamat Datang <span class="text-danger"><?php echo htmlspecialchars($nama_user); ?></span>! 🌸</span>
                <span class="badge-role">Tingkatan: <?php echo $role_user; ?></span>
            </div>
            <a href="logout.php" class="btn btn-logout" onclick="return confirm('Yakin ingin keluar aplikasi, ksatria? 🥺')">Keluar 🏃‍♂️</a>
        </div>

        <div class="main-container">
            
            <div class="header-table-area d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="logo_pd.jpeg" alt="Logo PD" class="mini-logo">
                    <div>
                        <span class="table-title">Data Anggota Perisai Diri</span>
                        <span class="slogan-pd">⚡ PANDAI SILAT TANPA CEDERA ⚡</span>
                    </div>
                </div>
                <?php if ($role_user === 'admin'): ?>
                    <a href="tambah.php" class="btn btn-add">+ Daftar Pesilat Baru</a>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table table-hover custom-table table-striped align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status Akun</th>
                            <?php if ($role_user === 'admin'): ?>
                                <th>Aksi Jurus</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td class="fw-bold text-muted"><?php echo $no++; ?></td>
                            <td class="fw-bold text-start ps-3">🦅 <?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><span class="badge-kelas"><?php echo htmlspecialchars($row['kelas']); ?></span></td>
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_lahir'])); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                            <td><span class="username-style">@<?php echo htmlspecialchars($row['username']); ?></span></td>
                            <td class="text-lowercase"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <span class="<?php echo ($row['role'] == 'admin') ? 'badge-table-admin' : 'badge-table-user'; ?>">
                                    <?php echo htmlspecialchars($row['role']); ?>
                                </span>
                            </td>
                            <?php if ($role_user === 'admin'): ?>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-ubah">Ubah</a>
                                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-hapus" onclick="return confirm('Beneran data pendekar <?php echo $row['nama']; ?> mau dihapus? 😭')">Hapus</a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-muted py-4'>Belum ada data pesilat yang bergabung... 🥋</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <div style="text-align: center; margin-top: 30px; margin-bottom: 20px; color: #475569; font-weight: bold; font-size: 0.95rem;">
        <span>&copy; 2026 by perisai diri 🥋 🌸 </span>
    </div>

</body>
</html>