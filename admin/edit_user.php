<?php
session_start();
require '../db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id='$id'")->fetch_assoc();

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Update tanpa ganti password
    if ($password == '') {
        $conn->query("UPDATE users SET 
            nama='$nama',
            email='$email',
            role='$role'
            WHERE id='$id'
        ");
    } 
    // Update + ganti password
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET 
            nama='$nama',
            email='$email',
            role='$role',
            password='$hash'
            WHERE id='$id'
        ");
    }

    header("Location: data_user.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    margin: 0;
    padding: 20px;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.header-page {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.header-page h2 {
    margin: 0;
    color: #4facfe;
    font-size: 24px;
    display: flex;
    align-items: center;
}

.header-page h2 i { margin-right: 10px; }

.btn-back {
    background: #6c757d;
    color: white;
    padding: 10px 18px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-back:hover { background: #5a6268; }

.form-container {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 450px;
    margin-top: 80px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #555;
}

input, select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: inherit;
    font-size: 16px;
    transition: border-color 0.3s;
}

input:focus, select:focus {
    outline: none;
    border-color: #4facfe;
    box-shadow: 0 0 5px rgba(79, 172, 254, 0.5);
}

small {
    color: #777;
    font-size: 14px;
    margin-top: 5px;
    display: block;
}

button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    body { padding: 10px; }
    .header-page { position: static; margin-bottom: 20px; }
    .form-container { margin-top: 0; padding: 20px; }
    .header-page h2 { font-size: 20px; }
}
</style>
</head>
<body>

<div class="header-page">
    <h2><i class="fas fa-user-edit"></i> Edit User</h2>
    <a href="data_user.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-container">
    <form method="post">
        <div class="form-group">
            <label for="nama"><i class="fas fa-user"></i> Nama</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="role"><i class="fas fa-user-tag"></i> Role</label>
            <select id="role" name="role">
                <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
                <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password Baru</label>
            <input type="password" id="password" name="password">
            <small>Kosongkan jika tidak ingin mengubah password</small>
        </div>

        <button name="update"><i class="fas fa-save"></i> Update User</button>
    </form>
</div>

</body>
</html>