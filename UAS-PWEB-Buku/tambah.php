<?php
// Halaman Tambah Data Buku (Create)
require "koneksi.php";
require "functions.php";

$pageTitle = "Tambah Buku";
$errors    = [];

// Variabel default untuk mengisi ulang form jika terjadi error
$judul   = "";
$penulis = "";
$penerbit = "";
$tahun   = "";
$kategori = "Fiksi";
$stok    = 0;

// Form Processing (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = trim($_POST['judul']);
    $penulis  = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun    = trim($_POST['tahun_terbit']);
    $kategori = $_POST['kategori'];
    $stok     = (int) $_POST['stok'];

    // Memanggil function validasi (percabangan ada di dalam function)
    $errors = validasiBuku($judul, $penulis, $tahun);

    // Percabangan: hanya simpan jika tidak ada error
    if (count($errors) === 0) {
        $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, kategori, stok)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssisi", $judul, $penulis, $penerbit, $tahun, $kategori, $stok);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: daftar.php?status=tambah");
            exit;
        } else {
            $errors[] = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

include "header.php";
?>

<section class="page-head">
    <p class="eyebrow">Tambah Data</p>
    <h1>Tambah Buku Baru</h1>
</section>

<?php if (count($errors) > 0): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $err) {
                echo "<li>" . htmlspecialchars($err) . "</li>";
            } ?>
        </ul>
    </div>
<?php endif; ?>

<form action="tambah.php" method="POST" class="card form-slip">
    <div class="form-row">
        <label for="judul">Judul Buku</label>
        <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($judul); ?>" required>
    </div>

    <div class="form-row form-row-split">
        <div>
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" value="<?php echo htmlspecialchars($penulis); ?>" required>
        </div>
        <div>
            <label for="penerbit">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($penerbit); ?>" required>
        </div>
    </div>

    <div class="form-row form-row-split">
        <div>
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" min="1000" max="<?php echo date('Y'); ?>"
                   value="<?php echo htmlspecialchars($tahun); ?>" required>
        </div>
        <div>
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" min="0" value="<?php echo htmlspecialchars($stok); ?>" required>
        </div>
    </div>

    <div class="form-row">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori">
            <?php
            // Perulangan untuk membangun pilihan dropdown kategori
            $listKategori = ["Fiksi", "Non-Fiksi", "Pendidikan", "Pengembangan Diri", "Lainnya"];
            foreach ($listKategori as $k) {
                $selected = ($kategori === $k) ? "selected" : "";
                echo "<option value='" . htmlspecialchars($k) . "' $selected>" . htmlspecialchars($k) . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-brass">Simpan Buku</button>
        <a href="daftar.php" class="btn btn-ghost">Batal</a>
    </div>
</form>

<?php include "footer.php"; ?>
