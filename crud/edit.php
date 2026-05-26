<?php
session_start();
include 'koneksi.php';

// Proteksi halaman, wajib admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("location:index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
    $data = mysqli_fetch_array($query);

    if (mysqli_num_rows($query) < 1) {
        echo "<script>alert('Data pendekar tidak ditemukan! 🥺'); window.location='index.php';</script>";
        exit;
    }
} else {
    header("location:index.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama          = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas         = $_POST['kelas'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $username      = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email         = mysqli_real_escape_string($koneksi, $_POST['email']);
    $role          = $_POST['role'];
    $password_baru = $_POST['password'];

    if (empty($password_baru)) {
        $query_update = "UPDATE users SET nama='$nama', kelas='$kelas', tanggal_lahir='$tanggal_lahir', 
                         jenis_kelamin='$jenis_kelamin', username='$username', email='$email', role='$role' WHERE id='$id'";
    } else {
        $password_md5 = md5($password_baru);
        $query_update = "UPDATE users SET nama='$nama', kelas='$kelas', tanggal_lahir='$tanggal_lahir', 
                         jenis_kelamin='$jenis_kelamin', username='$username', email='$email', role='$role', password='$password_md5' WHERE id='$id'";
    }

    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Yey! Data jurus pendekar berhasil diperbarui ✨'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Aduh gagal update: " . mysqli_error($koneksi) . " 😭');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="logo_pd.jpeg" type="image/jpeg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota Perisai Diri</title>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Varela Round', sans-serif;
            background-image: linear-gradient(rgba(186, 230, 253, 0.65), rgba(224, 242, 254, 0.75)), url('gambar1.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
            margin: 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 30px 40px;
            width: 100%;
            max-width: 680px;
            border: 3px solid #FFF9C4;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 0 0 4px #FFCDD2;
            text-align: center;
            position: relative;
        }

        .form-container::before { content: '🦅'; position: absolute; top: 20px; right: 25px; font-size: 1.5rem; opacity: 0.6; }

        .logo-img { width: 70px; height: 70px; object-fit: contain; margin-bottom: 10px; }
        .form-title { color: #0369A1; font-weight: bold; font-size: 1.8rem; }
        .form-subtitle { color: #EF5350; font-weight: bold; font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 25px; }
        .section-divider { color: #0284C7; font-weight: bold; font-size: 0.95rem; border-bottom: 2px dashed #BDE0FE; padding-bottom: 5px; margin-top: 20px; margin-bottom: 15px; text-align: left; }
        .form-label { font-weight: bold; color: #475569; font-size: 0.85rem; display: block; text-align: left; }

        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.8) !important;
            border: 2px solid #E2E8F0 !important;
            border-radius: 15px;
            padding: 10px 15px;
            font-size: 0.9rem;
            color: #334155 !important;
        }
        .form-control:focus, .form-select:focus { border-color: #7DD3FC !important; box-shadow: 0 0 10px rgba(125, 211, 252, 0.3) !important; }

        .btn-update { background: linear-gradient(135deg, #FCD34D 0%, #FBBF24 100%); color: #78350F; font-weight: bold; padding: 10px 35px; border-radius: 50px; border: none; box-shadow: 0 4px 10px rgba(251, 191, 36, 0.3); }
        .btn-update:hover { transform: scale(1.03); box-shadow: 0 0 10px #FFF176; }
        .btn-back { background-color: #E2E8F0; color: #475569; font-weight: bold; padding: 10px 25px; border-radius: 50px; text-decoration: none; }
        .btn-back:hover { background-color: #CBD5E1; color: #334155; }
    </style>
</head>
<body>
    <div class="form-container">
        <img src="logo_pd.jpeg" alt="Logo Perisai Diri" class="logo-img">
        <div class="form-title">PERISAI DIRI</div>
        <div class="form-subtitle">⚡ Perbarui Data Pesilat ⚡</div>
        <form method="POST" action="">
            <div class="section-divider">🔒 Kredensial Akun</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($data['username']); ?>" required autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <span class="text-muted fw-normal small">(Kosongkan jika tak diubah)</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password baru">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($data['email']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tingkatan Sistem (Role)</label>
                    <select name="role" class="form-select" required>
                        <option value="users" <?php if($data['role'] == 'users') echo 'selected'; ?>>User (Lihat Saja)</option>
                        <option value="admin" <?php if($data['role'] == 'admin') echo 'selected'; ?>>Admin (Modifikasi)</option>
                    </select>
                </div>
            </div>

            <div class="section-divider">👤 Biodata Diri Pendekar</div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas TJKT</label>
                <select name="kelas" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    <optgroup label="Kelas X">
                        <option value="X TJKT 1" <?php if($data['kelas'] == 'X TJKT 1') echo 'selected'; ?>>X TJKT 1</option>
                        <option value="X TJKT 2" <?php if($data['kelas'] == 'X TJKT 2') echo 'selected'; ?>>X TJKT 2</option>
                        <option value="X TJKT 3" <?php if($data['kelas'] == 'X TJKT 3') echo 'selected'; ?>>X TJKT 3</option>
                        <option value="X TJKT 4" <?php if($data['kelas'] == 'X TJKT 4') echo 'selected'; ?>>X TJKT 4</option>
                    </optgroup>
                    <optgroup label="Kelas XI">
                        <option value="XI TJKT 1" <?php if($data['kelas'] == 'XI TJKT 1') echo 'selected'; ?>>XI TJKT 1</option>
                        <option value="XI TJKT 2" <?php if($data['kelas'] == 'XI TJKT 2') echo 'selected'; ?>>XI TJKT 2</option>
                        <option value="XI TJKT 3" <?php if($data['kelas'] == 'XI TJKT 3') echo 'selected'; ?>>XI TJKT 3</option>
                        <option value="XI TJKT 4" <?php if($data['kelas'] == 'XI TJKT 4') echo 'selected'; ?>>XI TJKT 4</option>
                    </optgroup>
                    <optgroup label="Kelas XII">
                        <option value="XII TJKT 1" <?php if($data['kelas'] == 'XII TJKT 1') echo 'selected'; ?>>XII TJKT 1</option>
                        <option value="XII TJKT 2" <?php if($data['kelas'] == 'XII TJKT 2') echo 'selected'; ?>>XII TJKT 2</option>
                        <option value="XII TJKT 3" <?php if($data['kelas'] == 'XII TJKT 3') echo 'selected'; ?>>XII TJKT 3</option>
                        <option value="XII TJKT 4" <?php if($data['kelas'] == 'XII TJKT 4') echo 'selected'; ?>>XII TJKT 4</option>
                    </optgroup>
                </select>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $data['tanggal_lahir']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="Laki-laki" <?php if($data['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if($data['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center border-top pt-4">
                <a href="index.php" class="btn-back">Batal</a>
                <button type="submit" name="update" class="btn-update">Perbarui Data 🙏</button>
            </div>
        </form>
    </div>
</body>
</html>