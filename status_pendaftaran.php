<?php
session_start();
require 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil status pendaftaran dengan prepared statement untuk keamanan
$stmt = $conn->prepare("SELECT status FROM pendaftaran WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$d = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 1.1em;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin: 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .badge:hover {
            transform: scale(1.05);
        }
        .badge.pending {
            background-color: #ffc107;
            color: #212529;
        }
        .badge.pending::before {
            content: "⏳";
            margin-right: 10px;
            font-size: 1.2em;
        }
        .badge.approved {
            background-color: #28a745;
            color: white;
        }
        .badge.approved::before {
            content: "✅";
            margin-right: 10px;
            font-size: 1.2em;
        }
        .badge.rejected {
            background-color: #dc3545;
            color: white;
        }
        .badge.rejected::before {
            content: "❌";
            margin-right: 10px;
            font-size: 1.2em;
        }
        p {
            margin-top: 30px;
            color: #666;
            font-size: 1.1em;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            transition: color 0.3s ease, text-decoration 0.3s ease;
        }
        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Status Pendaftaran</h2>
        <?php
        if ($d) {
            $status = strtolower($d['status']);
            echo "<span class='badge $status'>" . htmlspecialchars($d['status']) . "</span>";
        } else {
            echo "<p>Belum mendaftar</p>";
        }
        ?>
        <p><a href="dashboard.php">Kembali ke dashboard</a></p>
    </div>
</body>
</html>