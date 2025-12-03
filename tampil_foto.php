<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include "../koneksi.php";
$result = $mysqli->query("SELECT * FROM galeri ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Galeri Pelanggan - Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="page">
    <h2>Semua Upload Pelanggan</h2>

    <table class="table">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Foto</th>
            <th>Waktu</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; while($row=$result->fetch_assoc()){ ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlentities($row['nama']) ?></td>
            <td><img src="../gambar/<?= $row['foto'] ?>"></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a href="delete.php?id=<?= $row['id'] ?>" class="btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="index.php" class="btn" style="width:auto; margin-top:16px;">Kembali</a>
</div>
</body>
</html>
