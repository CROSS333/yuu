<?php
require '../db.php';
$id=$_GET['id'];

$q=$conn->query("SELECT berkas FROM pendaftaran WHERE id=$id");
$d=$q->fetch_assoc();
unlink("../upload/".$d['berkas']);

$conn->query("DELETE FROM pendaftaran WHERE id=$id");
header("Location: data_pendaftaran.php");
