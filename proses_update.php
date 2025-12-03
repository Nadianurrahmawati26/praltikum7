<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pelanggan') {
    echo "Akses ditolak.";
    exit();
}

include "../koneksi.php";

$nama = trim($_POST['nama']);
$file = $_FILES['foto'];

if ($file['error'] != 0) {
    echo "<script>alert('Upload error'); window.location='index.php';</script>";
    exit();
}

// batas ukuran 2MB
if ($file['size'] > 2*1024*1024) {
    echo "<script>alert('Ukuran file maksimal 2MB!'); window.location='index.php';</script>";
    exit();
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','gif'];

if (!in_array($ext, $allowed)) {
    echo "<script>alert('Format tidak diizinkan!'); window.location='index.php';</script>";
    exit();
}

$newName = time() . "_" . uniqid() . "." . $ext;
$target = "../gambar/" . $newName;

move_uploaded_file($file['tmp_name'], $target);

// simpan database
$stmt = $mysqli->prepare("INSERT INTO galeri (nama, foto) VALUES (?,?)");
$stmt->bind_param("ss", $nama, $newName);
$stmt->execute();

echo "<script>alert('Upload berhasil!'); window.location='index.php';</script>";
?>
