<?php
$mysqli = new mysqli("localhost", "root", "", "foto");
if ($mysqli->connect_errno) {
    die("Gagal koneksi: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
?>
