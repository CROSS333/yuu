<?php 
require '../db.php'; 
$q = $conn->query("SELECT * FROM pendaftaran"); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PSB SD Inpres Ganting</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); 
            min-height: 100vh; 
        }
        h2 { text-align: center; color: #1976d2; }
        .buttons { text-align: center; margin-bottom: 20px; }
        .buttons a, .buttons button { 
            padding: 10px 20px; 
            margin: 0 10px; 
            background: #1976d2; 
            color: white; 
            text-decoration: none; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: background 0.3s; 
        }
        .buttons a:hover, .buttons button:hover { background: #1565c0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background: #f2f2f2; }
        @media print { .buttons { display: none; } body { background: white; } }
    </style>
</head>
<body>
    <h2>LAPORAN PSB SD INPRES GANTING</h2>
    <div class="buttons">
        <a href="dashboard.php">Kembali ke Dashboard</a>
        <button onclick="window.print()">Print</button>
        <button onclick="downloadPDF()">Download PDF</button>
        <button onclick="downloadExcel()">Download Excel</button>
    </div>
    <table id="reportTable">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Nama Wali</th>
            <th>Status</th>
        </tr>
        <?php 
        $no = 1;
        if ($q->num_rows > 0) {
            while ($d = $q->fetch_assoc()) { 
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['nama']) ?></td>
            <td><?= htmlspecialchars($d['jk']) ?></td>
            <td><?= htmlspecialchars($d['tempat_lahir']) ?></td>
            <td><?= date('d-m-Y', strtotime($d['tanggal_lahir'])) ?></td>
            <td><?= htmlspecialchars($d['alamat']) ?></td>
            <td><?= htmlspecialchars($d['no_hp']) ?></td>
            <td><?= htmlspecialchars($d['nama_wali']) ?></td>
            <td><?= htmlspecialchars($d['status']) ?></td>
        </tr>
        <?php 
            }
        } else {
            echo '<tr><td colspan="9">Tidak ada data.</td></tr>';
        }
        ?>
    </table>
    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.text('LAPORAN PSB SD INPRES GANTING', 20, 20);
            html2canvas(document.querySelector('#reportTable')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                doc.addImage(imgData, 'PNG', 10, 30, 190, (canvas.height * 190) / canvas.width);
                doc.save('laporan_psb.pdf');
            });
        }
        
        function downloadExcel() {
            const table = document.getElementById('reportTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Laporan" });
            XLSX.writeFile(wb, 'laporan_psb.xlsx');
        }
    </script>
</body>
</html>