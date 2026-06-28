-- =========================================================
-- database.sql
-- Sistem Pendataan Buku - UAS Pemrograman Web
-- =========================================================

CREATE DATABASE IF NOT EXISTS db_pendataan_buku;
USE db_pendataan_buku;

-- Struktur tabel buku
CREATE TABLE IF NOT EXISTS buku (
    id_buku       INT AUTO_INCREMENT PRIMARY KEY,
    judul         VARCHAR(150) NOT NULL,
    penulis       VARCHAR(100) NOT NULL,
    penerbit      VARCHAR(100) NOT NULL,
    tahun_terbit  YEAR NOT NULL,
    kategori      VARCHAR(50)  NOT NULL,
    stok          INT NOT NULL DEFAULT 0,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal (minimal 5 record)
INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, kategori, stok) VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Fiksi', 15),
('Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 'Fiksi', 8),
('Atomic Habits', 'James Clear', 'Gramedia Pustaka Utama', 2018, 'Pengembangan Diri', 20),
('Filosofi Teras', 'Henry Manampiring', 'Kompas Media Nusantara', 2019, 'Pengembangan Diri', 0),
('Pemrograman Web dengan PHP & MySQL', 'Budi Raharjo', 'Informatika Bandung', 2021, 'Pendidikan', 12),
('Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Kepustakaan Populer Gramedia', 2017, 'Non-Fiksi', 5);
