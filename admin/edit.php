<?php
require '../db.php';

if (!isset($_GET['id'])) {
    header("Location: data_pendaftaran.php");
    exit;
}

$id = (int)$_GET['id'];

/* Ambil data */
$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}

/* Proses update */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama          = $_POST['nama'];
    $jk            = $_POST['jk'];
    $tempat_lahir  = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat        = $_POST['alamat'];
    $no_hp         = $_POST['no_hp'];
    $nama_wali     = $_POST['nama_wali'];
    $status        = $_POST['status'];

    $berkas = $data['berkas'];

    /* Upload berkas jika diganti */
    if (!empty($_FILES['berkas']['name'])) {
        $namaFile = time() . "_" . basename($_FILES['berkas']['name']);
        move_uploaded_file($_FILES['berkas']['tmp_name'], "../upload/" . $namaFile);
        $berkas = $namaFile;
    }

    $update = $conn->prepare("
        UPDATE pendaftaran SET
        nama=?,
        jk=?,
        tempat_lahir=?,
        tanggal_lahir=?,
        alamat=?,
        no_hp=?,
        nama_wali=?,
        status=?,
        berkas=?
        WHERE id=?
    ");

    $update->bind_param(
        "sssssssssi",
        $nama,
        $jk,
        $tempat_lahir,
        $tanggal_lahir,
        $alamat,
        $no_hp,
        $nama_wali,
        $status,
        $berkas,
        $id
    );

    $update->execute();

    header("Location: data_pendaftaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Data Pendaftar</title>
<style>
body{
    font-family: Arial;
    background:#f0f4f8;
}
.container{
    width:500px;
    margin:40px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
}
h3{text-align:center;color:#2980b9}
label{font-weight:bold;display:block;margin-top:10px}
input,select,textarea{
    width:100%;
    padding:8px;
    margin-top:4px;
    border:1px solid #ccc;
    border-radius:5px;
}
button{
    margin-top:15px;
    padding:10px;
    width:100%;
    background:#28a745;
    color:white;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
}
button:hover{background:#218838}
.back{
    background:#6c757d;
    margin-top:8px;
}
.back:hover{background:#5a6268}
</style>
</head>

<body>
<div class="container">
<h3>Edit Data Pendaftar</h3>

<form method="post" enctype="multipart/form-data">

<label>Nama</label>
<input name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

<label>Jenis Kelamin</label>
<select name="jk" required>
    <option value="Laki-laki" <?= $data['jk']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
    <option value="Perempuan" <?= $data['jk']=='Perempuan'?'selected':'' ?>>Perempuan</option>
</select>

<label>Tempat Lahir</label>
<input name="tempat_lahir" value="<?= htmlspecialchars($data['tempat_lahir']) ?>" required>

<label>Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required>

<label>Alamat</label>
<textarea name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>

<label>No HP</label>
<input name="no_hp" value="<?= htmlspecialchars($data['no_hp']) ?>" required>

<label>Nama Wali</label>
<input name="nama_wali" value="<?= htmlspecialchars($data['nama_wali']) ?>" required>

<label>Status</label>
<select name="status">
    <option value="Pending" <?= $data['status']=='Pending'?'selected':'' ?>>Pending</option>
    <option value="Diterima" <?= $data['status']=='Diterima'?'selected':'' ?>>Diterima</option>
    <option value="Ditolak" <?= $data['status']=='Ditolak'?'selected':'' ?>>Ditolak</option>
</select>

<label>Berkas (PDF/JPG)</label>
<input type="file" name="berkas">
<?php if ($data['berkas']) { ?>
    <small>Berkas lama: <?= $data['berkas'] ?></small>
<?php } ?>

<button type="submit">💾 Simpan Perubahan</button>
<button type="button" class="back" onclick="location.href='data_pendaftaran.php'">
⬅ Kembali
</button>

</form>
</div>
</body>
</html>
