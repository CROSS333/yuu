<?php
session_start();
require '../db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$cek = $conn->query("SELECT role FROM users WHERE id='$id'")->fetch_assoc();

if ($cek['role'] != 'admin') {
    $conn->query("DELETE FROM users WHERE id='$id'");
}

header("Location: data_user.php");
