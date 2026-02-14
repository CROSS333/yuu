<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM pendaftaran");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar | Admin PSB SD Inpres Ganting</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2980b9, #6dd5fa);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,.3);
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
            background: url('../logo.png') no-repeat center;
            background-size: cover;
            border-radius: 50%;
        }

        h2 {
            color: #2980b9;
            margin: 0;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: .3s;
            margin-bottom: 4px;
        }

        .back-btn {
            background: #6c757d;
            color: white;
        }
        .back-btn:hover { background: #5a6268; }

        .edit-btn { background: #ffc107; }
        .edit-btn:hover { background: #e0a800; }

        .accept-btn { background: #28a745; color: white; }
        .accept-btn:hover { background: #218838; }

        .reject-btn { background: #dc3545; color: white; }
        .reject-btn:hover { background: #c82333; }

        .delete-btn { background: #343a40; color: white; }
        .delete-btn:hover { background: #23272b; }

        .download-btn { background: #17a2b8; color: white; }
        .download-btn:hover { background: #138496; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2196F3;
            color: white;
        }

        tr:hover {
            background: #e3f2fd;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge.pending { background: #ffc107; }
        .badge.diterima { background: #28a745; color: white; }
        .badge.ditolak { background: #dc3545; color: white; }

        .print-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
        .print-link:hover { background: #218838; }

        @media(max-width:768px){
            table { font-size: 13px; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div class="logo"></div>
        <h2>Data Pendaftar</h2>
    </div>

    <!-- Tombol kembali saja -->
    <button class="btn back-btn" onclick="window.location.href='dashboard.php'">
        ⬅ Kembali ke Dashboard
    </button>

    <table>
        <tr>
            <th>Nama</th>
            <th>JK</th>
            <th>Tempat Lahir</th>
            <th>Tgl Lahir</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Nama Wali</th>
            <th>Status</th>
            <th>Berkas</th>
            <th>Aksi</th>
        </tr>

        <?php while ($d = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td><?= htmlspecialchars($d['jk']) ?></td>
            <td><?= htmlspecialchars($d['tempat_lahir']) ?></td>
            <td><?= htmlspecialchars($d['tanggal_lahir']) ?></td>
            <td><?= htmlspecialchars($d['alamat']) ?></td>
            <td><?= htmlspecialchars($d['no_hp']) ?></td>
            <td><?= htmlspecialchars($d['nama_wali']) ?></td>
            <td>
                <span class="badge <?= strtolower($d['status']) ?>">
                    <?= htmlspecialchars($d['status']) ?>
                </span>
            </td>
            <td>
                <?php if ($d['berkas']) { ?>
                    <button class="btn download-btn"
                        onclick="window.open('../upload/<?= htmlspecialchars($d['berkas']) ?>','_blank')">
                        Download
                    </button>
                <?php } else { echo "Tidak ada"; } ?>
            </td>
            <td>
                <button class="btn edit-btn"
                    onclick="location.href='edit.php?id=<?= $d['id'] ?>'">Edit</button>

                <button class="btn accept-btn"
                    onclick="location.href='aksi_status.php?id=<?= $d['id'] ?>&s=Diterima'">Terima</button>

                <button class="btn reject-btn"
                    onclick="location.href='aksi_status.php?id=<?= $d['id'] ?>&s=Ditolak'">Tolak</button>

                <button class="btn delete-btn"
                    onclick="return confirm('Yakin hapus data ini?') &&
                    (location.href='hapus.php?id=<?= $d['id'] ?>')">Hapus</button>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="laporan.php" class="print-link">Cetak Laporan</a>

</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
