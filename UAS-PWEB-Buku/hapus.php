<?php
// Proses Hapus Data Buku (Delete)
require "koneksi.php";

// Form Processing (GET): ambil ID dari URL, contoh hapus.php?id=3
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: daftar.php");
    exit;
}

$id = (int) $_GET['id'];

$query = "DELETE FROM buku WHERE id_buku = ?";
$stmt  = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);

// Percabangan: redirect dengan status berbeda sesuai hasil eksekusi
if (mysqli_stmt_execute($stmt)) {
    header("Location: daftar.php?status=hapus");
} else {
    header("Location: daftar.php?status=error");
}
exit;
?>
