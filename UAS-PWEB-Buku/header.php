<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . " — Katalog Buku" : "Katalog Buku"; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,900&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
    <a href="index.php" class="navbar-brand">
        <span class="brand-mark">No.</span> Katalog&nbsp;Buku
    </a>
    <nav class="navbar-menu">
        <a href="index.php"  class="<?php echo (basename($_SERVER['PHP_SELF']) === 'index.php')  ? 'is-active' : ''; ?>">Beranda</a>
        <a href="daftar.php" class="<?php echo (basename($_SERVER['PHP_SELF']) === 'daftar.php') ? 'is-active' : ''; ?>">Daftar Buku</a>
        <a href="tambah.php" class="<?php echo (basename($_SERVER['PHP_SELF']) === 'tambah.php') ? 'is-active' : ''; ?>">Tambah Buku</a>
    </nav>
</header>

<main class="container">
