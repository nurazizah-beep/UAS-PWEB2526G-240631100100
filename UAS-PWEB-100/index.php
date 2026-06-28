<?php
// Halaman Beranda (Home)
require "koneksi.php";
require "functions.php";

$pageTitle = "Beranda";

// Variabel + memanggil function statistik
$stat = getStatistik($conn);

include "header.php";
?>

<section class="hero">
    <p class="eyebrow">Sistem Pendataan Buku</p>
    <h1>Katalog perpustakaan,<br>tersusun rapi seperti rak aslinya.</h1>
    <p class="hero-desc">
        Aplikasi sederhana berbasis PHP Native &amp; MySQL untuk mencatat,
        mencari, mengubah, dan menghapus data buku perpustakaan secara digital.
    </p>
    <div class="hero-actions">
        <a href="tambah.php" class="btn btn-brass">+ Tambah Buku</a>
        <a href="daftar.php" class="btn btn-ghost">Lihat Daftar Buku</a>
    </div>
</section>

<section class="catalog-stats">
    <div class="catalog-card">
        <span class="catalog-card-no">01</span>
        <span class="catalog-card-value"><?php echo $stat['judul']; ?></span>
        <span class="catalog-card-label">Judul Terdata</span>
    </div>
    <div class="catalog-card">
        <span class="catalog-card-no">02</span>
        <span class="catalog-card-value"><?php echo $stat['stok']; ?></span>
        <span class="catalog-card-label">Total Eksemplar (Stok)</span>
    </div>
    <div class="catalog-card">
        <span class="catalog-card-no">03</span>
        <span class="catalog-card-value"><?php echo $stat['kosong']; ?></span>
        <span class="catalog-card-label">Judul Stok Kosong</span>
    </div>
</section>

<section class="card info-card">
    <h2>Tentang Aplikasi</h2>
    <p>
        Setiap data buku disimpan dalam satu tabel <code>buku</code> pada database MySQL.
        Melalui menu <strong>Daftar Buku</strong>, Anda dapat mencari, mengubah, maupun
        menghapus data. Melalui menu <strong>Tambah Buku</strong>, data baru dapat
        ditambahkan ke katalog.
    </p>
</section>

<?php include "footer.php"; ?>
