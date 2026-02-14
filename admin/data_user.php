<?php
session_start();
require '../db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$data = $conn->query("SELECT id, nama, email, role, password FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data User</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    margin: 0;
    padding: 20px;
    color: #333;
}

.header-page {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.header-page h2 {
    margin: 0;
    color: #4facfe;
    font-size: 28px;
    display: flex;
    align-items: center;
}

.header-page h2 i { margin-right: 10px; }

.btn-back {
    background: #6c757d;
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-back:hover { background: #5a6268; }

.table-container {
    overflow-x: auto;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    background: #fff;
    border-collapse: collapse;
    border-radius: 15px;
    overflow: hidden;
    min-width: 600px;
}

th, td {
    padding: 16px 14px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

th {
    background: #4facfe;
    color: white;
    font-weight: 600;
}

tr:hover { background: #f8f9fa; }

a.btn {
    padding: 8px 12px;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
    display: inline-block;
    margin: 0 2px;
}

.edit { background: #ffc107; }
.edit:hover { background: #ff8c00; }

.hapus { background: #dc3545; }
.hapus:hover { background: #c82333; }

.password-container {
    position: relative;
    display: inline-block;
    width: 120px;
}

.password-input {
    border: 1px solid #ddd;
    background: #f8f9fa;
    text-align: center;
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    font-family: inherit;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
}

@media (max-width: 768px) {
    body { padding: 10px; }
    .header-page { flex-direction: column; text-align: center; padding: 15px; }
    .header-page h2 { margin-bottom: 15px; font-size: 24px; }
    th, td { padding: 10px 8px; }
    .password-container { width: 100px; }
}
</style>
</head>
<body>

<div class="header-page">
    <h2><i class="fas fa-user-cog"></i> Data User</h2>
    <a href="dashboard.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="table-container">
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Password</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; while ($u = $data->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($u['nama']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['role'] ?></td>
            <td>
                <div class="password-container">
                    <input type="password" class="password-input" value="<?= htmlspecialchars($u['password']) ?>" readonly>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword(this)"></i>
                </div>
            </td>
            <td>
                <a class="btn edit" href="edit_user.php?id=<?= $u['id'] ?>">
                    <i class="fas fa-edit"></i>
                </a>
                <?php if ($u['role'] != 'admin'): ?>
                <a class="btn hapus" href="hapus_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Yakin hapus user?')">
                    <i class="fas fa-trash"></i>
                </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<script>
function togglePassword(icon) {
    const input = icon.previousElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>