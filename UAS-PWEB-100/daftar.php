<?php
// Halaman Daftar Data Buku (Read) + Pencarian
require "koneksi.php";
require "functions.php";

$pageTitle = "Daftar Buku";

// Form Processing (GET): ambil kata kunci pencarian dari query string
$keyword = isset($_GET['cari']) ? trim($_GET['cari']) : "";

// Memanggil function untuk ambil data (perulangan terjadi di dalam function)
$daftarBuku = getAllBuku($conn, $keyword);

include "header.php";
?>

<section class="page-head">
    <p class="eyebrow">Daftar Data</p>
    <h1>Semua Buku</h1>
</section>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-<?php echo htmlspecialchars($_GET['status']); ?>">
        <?php
        // Percabangan switch-case untuk menentukan pesan notifikasi
        switch ($_GET['status']) {
            case 'tambah':
                echo "Data buku berhasil ditambahkan.";
                break;
            case 'update':
                echo "Data buku berhasil diperbarui.";
                break;
            case 'hapus':
                echo "Data buku berhasil dihapus.";
                break;
            default:
                echo "Aksi berhasil dilakukan.";
        }
        ?>
    </div>
<?php endif; ?>

<form action="daftar.php" method="GET" class="search-bar">
    <input type="text" name="cari" placeholder="Cari judul, penulis, atau kategori..."
           value="<?php echo htmlspecialchars($keyword); ?>">
    <button type="submit" class="btn btn-brass">Cari</button>
    <?php if ($keyword !== ""): ?>
        <a href="daftar.php" class="btn btn-ghost">Reset</a>
    <?php endif; ?>
</form>

<section class="card">
    <table class="table-ledger">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Perulangan: menampilkan setiap baris data buku
        if (count($daftarBuku) > 0) {
            $no = 1;
            foreach ($daftarBuku as $buku) {
                echo "<tr>";
                echo "<td class='mono'>" . $no . "</td>";
                echo "<td class='judul-cell'>" . htmlspecialchars($buku['judul']) . "</td>";
                echo "<td>" . htmlspecialchars($buku['penulis']) . "</td>";
                echo "<td>" . htmlspecialchars($buku['penerbit']) . "</td>";
                echo "<td class='mono'>" . htmlspecialchars($buku['tahun_terbit']) . "</td>";
                echo "<td>" . kategoriBadge($buku['kategori']) . "</td>";
                echo "<td class='mono'>" . (int) $buku['stok'] . "</td>";
                echo "<td>" . statusStok((int) $buku['stok']) . "</td>";
                echo "<td class='aksi-cell'>
                        <a href='edit.php?id=" . (int) $buku['id_buku'] . "' class='btn btn-small btn-ghost'>Edit</a>
                        <a href='hapus.php?id=" . (int) $buku['id_buku'] . "' class='btn btn-small btn-danger' onclick=\"return confirm('Hapus buku ini?');\">Hapus</a>
                      </td>";
                echo "</tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='9' class='empty-row'>Belum ada data, atau data tidak ditemukan.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</section>

<?php include "footer.php"; ?>
