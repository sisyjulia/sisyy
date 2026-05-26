<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="logo_pd.jpeg" type="image/jpeg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perisai Diri</title>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Varela Round', sans-serif;
            background-image: linear-gradient(rgba(10, 37, 64, 0.6), rgba(5, 19, 41, 0.7)), url('gambar1.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 35px 35px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 3px solid #FFF9C4;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3), 0 0 0 4px #FFCDD2;
        }

        .logo-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .login-title { color: #0284C7; font-weight: bold; font-size: 1.8rem; }
        .login-subtitle { color: #EF5350; font-weight: bold; font-size: 0.85rem; letter-spacing: 2px; margin-bottom: 30px; }

        .form-control {
            background-color: rgba(255, 255, 255, 0.8) !important;
            border: 2px solid #E0F2FE !important;
            color: #334155 !important;
            border-radius: 20px;
            padding: 12px 18px;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }
        .form-control:focus { border-color: #7DD3FC !important; box-shadow: 0 0 10px rgba(125, 211, 252, 0.5) !important; }

        .btn-login {
            background: linear-gradient(135deg, #FF8A80 0%, #FF5252 100%);
            color: white;
            font-weight: bold;
            width: 100%;
            padding: 12px;
            border-radius: 20px;
            border: none;
            box-shadow: 0 6px 12px rgba(255, 82, 82, 0.3);
            transition: all 0.3s ease;
        }
        .btn-login:hover { transform: scale(1.03); box-shadow: 0 0 15px #FFF176; color: white; }
        .signup-text { color: #475569; font-size: 0.85rem; margin-top: 25px; font-weight: bold; }
        .signup-link { color: #0369A1; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="logo_pd.jpeg" alt="Logo Perisai Diri" class="logo-img">
        <div class="login-title">PERISAI DIRI</div>
        <div class="login-subtitle">Keluarga Silat Nasional</div>
        <form action="proses_login.php" method="POST">
            <input type="text" name="username" class="form-control" placeholder="Username atau Email" required autocomplete="off">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" name="login" class="btn btn-login">MASUK ✨</button>
            <div class="signup-text">Belum bergabung? <a href="daftar.php" class="signup-link">Daftar Yuk!</a></div>
        </form>
    </div>
</body>
</html>