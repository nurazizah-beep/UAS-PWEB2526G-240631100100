<?php
/**
 * functions.php
 * Kumpulan function bantuan (helper) untuk operasi data buku.
 * File ini di-include/require di halaman lain agar kode tidak berulang.
 */

// FUNCTION 1: Mengambil seluruh data buku dari database (mendukung pencarian)
function getAllBuku($conn, $keyword = "")
{
    $data = [];

    if ($keyword !== "") {
        // Form Processing (GET) -> pencarian judul/penulis/kategori
        $keyword = "%" . $keyword . "%";
        $query   = "SELECT * FROM buku 
                     WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ?
                     ORDER BY id_buku DESC";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $keyword, $keyword, $keyword);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $query  = "SELECT * FROM buku ORDER BY id_buku DESC";
        $result = mysqli_query($conn, $query);
    }

    // Perulangan: menampung setiap baris hasil query ke dalam array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

// FUNCTION 2: Mengambil 1 data buku berdasarkan ID (untuk form edit)
function getBukuById($conn, $id)
{
    $query = "SELECT * FROM buku WHERE id_buku = ?";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// FUNCTION 3: Menentukan label status stok (percabangan if-elseif-else)
function statusStok($stok)
{
    if ($stok > 10) {
        return '<span class="badge badge-aman">Stok Aman</span>';
    } elseif ($stok > 0) {
        return '<span class="badge badge-menipis">Stok Menipis</span>';
    } else {
        return '<span class="badge badge-kosong">Stok Kosong</span>';
    }
}

// FUNCTION 4: Menentukan kelas warna badge kategori (percabangan switch-case)
function kategoriBadge($kategori)
{
    switch ($kategori) {
        case "Fiksi":
            $kelas = "kat-fiksi";
            break;
        case "Non-Fiksi":
            $kelas = "kat-nonfiksi";
            break;
        case "Pendidikan":
            $kelas = "kat-pendidikan";
            break;
        case "Pengembangan Diri":
            $kelas = "kat-pengembangan";
            break;
        default:
            $kelas = "kat-lainnya";
    }
    return '<span class="kategori ' . $kelas . '">' . htmlspecialchars($kategori) . '</span>';
}

// FUNCTION 5: Menghitung statistik sederhana (total judul & total stok) -> perulangan foreach
function getStatistik($conn)
{
    $totalJudul = 0;
    $totalStok  = 0;
    $kosong     = 0;

    $semuaBuku = getAllBuku($conn);
    foreach ($semuaBuku as $buku) {
        $totalJudul++;
        $totalStok += (int) $buku['stok'];
        if ((int) $buku['stok'] === 0) {
            $kosong++;
        }
    }

    return [
        "judul"  => $totalJudul,
        "stok"   => $totalStok,
        "kosong" => $kosong,
    ];
}

// FUNCTION 6: Validasi input form tambah/edit buku
function validasiBuku($judul, $penulis, $tahun)
{
    $errors = [];

    if (trim($judul) === "") {
        $errors[] = "Judul buku wajib diisi.";
    }
    if (trim($penulis) === "") {
        $errors[] = "Penulis wajib diisi.";
    }
    if (!is_numeric($tahun) || $tahun < 1000 || $tahun > (int) date("Y")) {
        $errors[] = "Tahun terbit tidak valid.";
    }

    return $errors;
}
?>
