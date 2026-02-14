<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
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
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #4facfe, #00f2fe);
        }
        h1 {
            text-align: center;
            color: #4facfe;
            margin-bottom: 10px;
            font-size: 32px;
            font-weight: 700;
        }
        p {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }
        nav {
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        nav a {
            display: inline-flex;
            align-items: center;
            padding: 12px 25px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(79, 172, 254, 0.3);
        }
        nav a:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(79, 172, 254, 0.4);
        }
        nav a i {
            margin-right: 8px;
        }
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, #e1e5e9, #4facfe, #e1e5e9);
            margin: 30px 0;
        }
        h3 {
            color: #4facfe;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }
        .info-section {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .info-box {
            flex: 1;
            min-width: 280px;
            background: linear-gradient(135deg, #e3f2fd 0%, #f1f8ff 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 5px solid #4facfe;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .info-box h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #4facfe;
            font-size: 20px;
        }
        .info-box p, .info-box ul {
            margin: 0;
            line-height: 1.6;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #4facfe;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }
            h1 {
                font-size: 28px;
            }
            nav {
                flex-direction: column;
                align-items: center;
            }
            nav a {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
            .info-section {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-school"></i> SD INPRES GANTING</h1>
        <p>Sistem Penerimaan Peserta Didik Baru</p>

        <nav>
            <a href="dashboard.php"><i class="fas fa-home"></i> Beranda</a>
            <a href="pendaftaran.php"><i class="fas fa-edit"></i> Pendaftaran</a>
            <a href="status_pendaftaran.php"><i class="fas fa-check-circle"></i> Status</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>

        <hr>

        <h3><i class="fas fa-info-circle"></i> Profil Sekolah</h3>
        <div class="info-box">
            <p>SD Inpres Ganting adalah sekolah dasar negeri yang berkomitmen memberikan pendidikan dasar berkualitas kepada siswa-siswi di wilayah Ganting. Kami fokus pada pengembangan karakter, kreativitas, dan kecerdasan anak-anak untuk menghadapi tantangan masa depan.</p>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h3><i class="fas fa-calendar-alt"></i> Waktu Pendaftaran</h3>
                <p>📅 1 Juni – 30 Juni</p>
            </div>
            <div class="info-box">
                <h3><i class="fas fa-clipboard-list"></i> Syarat Pendaftaran</h3>
                <ul>
                    <li>Akta Kelahiran</li>
                    <li>Kartu Keluarga</li>
                    <li>Pas Foto</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>