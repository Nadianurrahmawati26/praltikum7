<?php
session_start();

// Cegah pelanggan atau orang luar mengakses file delete
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include "../koneksi.php";

// Ambil ID dari URL
$id = (int) $_GET['id'];

// Ambil foto berdasarkan ID
$query = $mysqli->prepare("SELECT foto FROM galeri WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $data = $result->fetch_assoc();
    $foto = $data['foto'];

    // Path lokasi file gambar
    $filePath = "../gambar/" . $foto;

    // Hapus file fisik jika ada
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Hapus data dari database
    $del = $mysqli->prepare("DELETE FROM galeri WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
}

// Kembali ke halaman admin
header("Location: tampil_foto.php");
exit();
?>
