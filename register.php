<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    if (!$nama || !$email || !$pass) {
        echo "<script>alert('Semua field wajib diisi');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid');</script>";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $cek = $conn->prepare("SELECT id FROM users WHERE email=?");
        $cek->bind_param("s", $email);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows) {
            echo "<script>alert('Email sudah terdaftar');</script>";
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO users (nama,email,password,role) VALUES (?,?,?,'user')"
            );
            $stmt->bind_param("sss", $nama, $email, $hash);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrasi</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    color: #333;
}

.box {
    background: #fff;
    padding: 40px;
    width: 100%;
    max-width: 400px;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #4facfe;
    margin-bottom: 30px;
    font-size: 28px;
    font-weight: 600;
}

input {
    width: 100%;
    padding: 15px;
    border: 2px solid #e1e5e9;
    border-radius: 10px;
    font-size: 16px;
    margin-bottom: 20px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: #4facfe;
    outline: none;
}

button {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.3s ease;
    margin-top: 10px;
}

button:hover {
    transform: translateY(-2px);
}

p {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
}

a {
    color: #4facfe;
    text-decoration: none;
    font-weight: 500;
}

a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .box {
        padding: 30px 20px;
        margin: 20px;
    }
    
    h2 {
        font-size: 24px;
    }
}
</style>
</head>
<body>
<div class="box">
    <h2>Registrasi</h2>
    <form method="post">
        <input name="nama" placeholder="Nama Lengkap" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <button>Daftar</button>
    </form>
    <p><a href="login.php">Kembali ke Login</a></p>
</div>
</body>
</html>