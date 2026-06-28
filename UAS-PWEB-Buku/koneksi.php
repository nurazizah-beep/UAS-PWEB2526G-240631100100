<?php
/**
 * koneksi.php
 * File koneksi ke database MySQL menggunakan mysqli (procedural).
 * Sesuaikan $host, $user, $pass, $dbname dengan konfigurasi lokal Anda
 * (default XAMPP/Laragon: user=root, pass=kosong).
 */

// Variabel konfigurasi database
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "db_pendataan_buku";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Percabangan: cek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset agar karakter khusus (misal: petik, simbol) tersimpan dengan benar
mysqli_set_charset($conn, "utf8mb4");
?>
