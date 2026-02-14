<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | PSB SD Inpres Ganting</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            margin: 0;
            padding: 0;
            color: #333;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 15px 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        nav {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        nav a {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: 0.3s;
        }
        nav a:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
        }
        nav a i {
            margin-right: 8px;
        }
        .container {
            max-width: 1100px;
            margin: 110px auto 20px;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .welcome {
            text-align: center;
            font-size: 20px;
            color: #666;
            margin-bottom: 40px;
        }
        .stats {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }
        .stat-box {
            flex: 1;
            min-width: 250px;
            background: linear-gradient(135deg, #e3f2fd, #f1f8ff);
            padding: 25px;
            border-radius: 12px;
            border-left: 5px solid #4facfe;
            text-align: center;
        }
        .stat-box i {
            font-size: 40px;
            color: #4facfe;
            margin-bottom: 10px;
        }
        .stat-box h3 {
            margin-bottom: 10px;
            color: #4facfe;
        }
        .stat-box p {
            font-size: 28px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <h1><i class="fas fa-cogs"></i> Dashboard Admin PSB</h1>
    <nav>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="data_pendaftaran.php"><i class="fas fa-users"></i> Data Pendaftar</a>

        <!-- ✅ TOMBOL BARU -->
        <a href="data_user.php"><i class="fas fa-user-cog"></i> Data User</a>

        <a href="laporan.php"><i class="fas fa-chart-bar"></i> Laporan</a>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
</div>

<div class="container">
    <p class="welcome">Selamat datang Admin PSB SD Inpres Ganting</p>

    <div class="stats">
        <div class="stat-box">
            <i class="fas fa-user-graduate"></i>
            <h3>Total Pendaftar</h3>
            <p>
            <?php
            $q = $conn->query("SELECT COUNT(*) total FROM pendaftaran");
            echo $q->fetch_assoc()['total'];
            ?>
            </p>
        </div>

        <div class="stat-box">
            <i class="fas fa-clock"></i>
            <h3>Pending</h3>
            <p>
            <?php
            $q = $conn->query("SELECT COUNT(*) total FROM pendaftaran WHERE status='Pending'");
            echo $q->fetch_assoc()['total'];
            ?>
            </p>
        </div>

        <div class="stat-box">
            <i class="fas fa-check-circle"></i>
            <h3>Approved</h3>
            <p>
            <?php
            $q = $conn->query("SELECT COUNT(*) total FROM pendaftaran WHERE status='Approved'");
            echo $q->fetch_assoc()['total'];
            ?>
            </p>
        </div>
    </div>
</div>

</body>
</html>
