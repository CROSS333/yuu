<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cegah daftar 2x
$cek_stmt = $conn->prepare("SELECT id FROM pendaftaran WHERE user_id = ?");
$cek_stmt->bind_param("i", $_SESSION['user_id']);
$cek_stmt->execute();
$cek_stmt->store_result();

if ($cek_stmt->num_rows > 0) {
    $cek_stmt->close();
    header("Location: status_pendaftaran.php");
    exit;
}
$cek_stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama   = trim($_POST['nama']);
    $jk     = $_POST['jk'];
    $tmp    = trim($_POST['tempat_lahir']);
    $tgl    = $_POST['tanggal_lahir'];
    $alamat = trim($_POST['alamat']);
    $hp     = trim($_POST['no_hp']);
    $wali   = trim($_POST['nama_wali']);

    if (empty($nama) || empty($jk) || empty($tmp) || empty($tgl) || empty($alamat) || empty($hp) || empty($wali)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } elseif (!preg_match('/^[0-9]+$/', $hp)) {
        echo "<script>alert('No HP hanya boleh berisi angka!');</script>";
    } else {

        $folder = "upload/";
        if (!is_dir($folder)) mkdir($folder, 0777, true);

        $berkas_name  = $_FILES['berkas']['name'];
        $berkas_tmp   = $_FILES['berkas']['tmp_name'];
        $berkas_size  = $_FILES['berkas']['size'];
        $berkas_error = $_FILES['berkas']['error'];

        $ext = strtolower(pathinfo($berkas_name, PATHINFO_EXTENSION));

        if ($berkas_error !== 0) {
            echo "<script>alert('Gagal upload file!');</script>";
        } elseif ($ext !== 'pdf') {
            echo "<script>alert('File harus PDF!');</script>";
        } elseif ($berkas_size > 5 * 1024 * 1024) {
            echo "<script>alert('Ukuran file maksimal 5MB!');</script>";
        } else {

            $berkas = time() . "_" . basename($berkas_name);
            move_uploaded_file($berkas_tmp, $folder . $berkas);

            $stmt = $conn->prepare("
                INSERT INTO pendaftaran
                (user_id, nama, jk, tempat_lahir, tanggal_lahir, alamat, no_hp, nama_wali, berkas)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param(
                "issssssss",
                $_SESSION['user_id'],
                $nama, $jk, $tmp, $tgl, $alamat, $hp, $wali, $berkas
            );

            $stmt->execute();
            $stmt->close();

            header("Location: status_pendaftaran.php");
            exit;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form Pendaftaran</title>

<style>
body{
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,#1e88e5,#64b5f6);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.container{
    background:white;
    width:100%;
    max-width:500px;
    padding:25px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

h2{
    text-align:center;
    color:#1e88e5;
}

input,select,textarea{
    width:100%;
    padding:10px;
    margin-bottom:14px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:15px;
}

input:focus,select:focus,textarea:focus{
    outline:none;
    border-color:#1e88e5;
    box-shadow:0 0 5px rgba(30,136,229,.4);
}

button{
    width:100%;
    padding:12px;
    background:#1e88e5;
    color:white;
    border:none;
    border-radius:6px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#1565c0;
}
</style>

<script>
function hanyaAngka(e){
    e.value = e.value.replace(/[^0-9]/g,'');
}
</script>

</head>
<body>

<div class="container">
<h2>Form Pendaftaran Siswa</h2>

<form method="post" enctype="multipart/form-data">

<input name="nama" placeholder="Nama Lengkap" required>

<select name="jk" required>
    <option value="">-- Jenis Kelamin --</option>
    <option value="Laki-laki">Laki-laki</option>
    <option value="Perempuan">Perempuan</option>
</select>

<input name="tempat_lahir" placeholder="Tempat Lahir" required>

<input type="date" name="tanggal_lahir" required>

<textarea name="alamat" placeholder="Alamat" required></textarea>

<input
    type="tel"
    name="no_hp"
    placeholder="No HP (angka saja)"
    inputmode="numeric"
    pattern="[0-9]*"
    oninput="hanyaAngka(this)"
    required
>

<input name="nama_wali" placeholder="Nama Wali" required>

<input type="file" name="berkas" accept=".pdf" required>

<button type="submit">Kirim Pendaftaran</button>

</form>
</div>

</body>
</html>
