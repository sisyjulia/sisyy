<?php
include 'koneksi.php';

if (isset($_POST['daftar'])) {
    $username      = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password      = md5($_POST['password']); 
    $email         = mysqli_real_escape_string($koneksi, $_POST['email']);
    $role          = 'users'; // Otomatis sebagai users biasa
    $nama          = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas         = $_POST['kelas'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Aduh, username ini sudah diambil pesilat lain! Coba bikin nama yang unik ya! 🥺');</script>";
    } else {
        $query_daftar = "INSERT INTO users (nama, kelas, tanggal_lahir, jenis_kelamin, username, email, password, role) 
                         VALUES ('$nama', '$kelas', '$tanggal_lahir', '$jenis_kelamin', '$username', '$email', '$password', '$role')";
        
        if (mysqli_query($koneksi, $query_daftar)) {
            echo "<script>alert('Pendaftaran Berhasil! Selamat bergabung di keluarga besar Perisai Diri! 🎉🥋'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Aduh, sistem error: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="logo_pd.jpeg" type="image/jpeg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota Perisai Diri</title>
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
            max-width: 650px;
            border: 3px solid #FFF9C4;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 0 0 4px #FFCDD2;
            text-align: center;
        }

        .logo-img { width: 75px; height: 75px; object-fit: contain; margin-bottom: 10px; }
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

        .btn-register { background: linear-gradient(135deg, #FF8A80 0%, #FF5252 100%); color: white; font-weight: bold; padding: 12px 40px; border-radius: 50px; border: none; box-shadow: 0 4px 12px rgba(255, 82, 82, 0.25); width: 100%; margin-top: 15px; }
        .btn-register:hover { transform: scale(1.02); box-shadow: 0 0 15px #FFF176; color: white; }
        
        .footer-text { color: #475569; font-size: 0.85rem; margin-top: 20px; font-weight: bold; }
        .login-link { color: #0369A1; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="form-container">
        <img src="logo_pd.jpeg" alt="Logo Perisai Diri" class="logo-img">
        <div class="form-title">REGISTRASI PESILAT</div>
        <div class="form-subtitle">Formulir Pendaftaran Keluarga Besar PD</div>
        <form method="POST" action="">
            <div class="section-divider">🔒 Data Akun Baru</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Buat username baru" required autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Buat password aman" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="contoh: nama@gmail.com" required>
            </div>

            <div class="section-divider">👤 Identitas Diri Anggota</div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap kamu" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Kelas TJKT</label>
                <select name="kelas" class="form-select" required>
                    <option value="">-- Pilih Kelas TJKT Kamu --</option>
                    <optgroup label="Kelas X">
                        <option value="X TJKT 1">X TJKT 1</option>
                        <option value="X TJKT 2">X TJKT 2</option>
                        <option value="X TJKT 3">X TJKT 3</option>
                        <option value="X TJKT 4">X TJKT 4</option>
                    </optgroup>
                    <optgroup label="Kelas XI">
                        <option value="XI TJKT 1">XI TJKT 1</option>
                        <option value="XI TJKT 2">XI TJKT 2</option>
                        <option value="XI TJKT 3">XI TJKT 3</option>
                        <option value="XI TJKT 4">XI TJKT 4</option>
                    </optgroup>
                    <optgroup label="Kelas XII">
                        <option value="XII TJKT 1">XII TJKT 1</option>
                        <option value="XII TJKT 2">XII TJKT 2</option>
                        <option value="XII TJKT 3">XII TJKT 3</option>
                        <option value="XII TJKT 4">XII TJKT 4</option>
                    </optgroup>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <button type="submit" name="daftar" class="btn btn-register">GABUNG SEKARANG 🥋⚡</button>
            <div class="footer-text">Sudah punya akun? <a href="login.php" class="login-link">Masuk Padepokan</a></div>
        </form>
    </div>
</body>
</html>