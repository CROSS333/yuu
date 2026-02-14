<?php
session_start();
require 'db.php';

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}

$error = "";
$emailValue = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $emailValue = $email;
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, nama, role, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Cek password HASH (registrasi baru)
        if (password_verify($password, $user['password']) || md5($password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['role'];

            // Jika password masih MD5 → upgrade ke hash
            if (md5($password) === $user['password']) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $up = $conn->prepare("UPDATE users SET password=? WHERE id=?");
                $up->bind_param("si", $newHash, $user['id']);
                $up->execute();
                $up->close();
            }

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Email atau password salah!";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | PSB SD Inpres Ganting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .container {
            background: #fff;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            width: 110px;
            height: 110px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        h1 {
            color: #4facfe;
            margin-bottom: 5px;
            font-size: 28px;
            font-weight: 600;
        }
        p {
            color: #666;
            margin-bottom: 20px;
        }
        .error {
            background: #cce7ff;
            color: #003366;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
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
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin-top: 10px;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .register-link {
            margin-top: 20px;
            font-size: 14px;
        }
        .register-link a {
            color: #4facfe;
            text-decoration: none;
            font-weight: 500;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
                margin: 20px;
            }
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="Logo.jpg" alt="Logo SD Inpres Ganting">
    </div>
    <h1>Login PSB</h1>
    <p>SD Inpres Ganting</p>
    <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="on">
        <input type="email" name="email" placeholder="Email" required autocomplete="email" value="<?= htmlspecialchars($emailValue) ?>">
        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        Belum punya akun? <a href="register.php">Daftar di sini</a>
    </div>
</div>
</body>
</html>