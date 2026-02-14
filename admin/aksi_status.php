<?php
require '../db.php';
$id = $_GET['id'];
$s = $_GET['s'];

$conn->query("UPDATE pendaftaran SET status='$s' WHERE id=$id");
header("Location: data_pendaftaran.php");
