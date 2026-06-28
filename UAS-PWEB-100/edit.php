<?php
// Halaman Edit Data Buku (Update)
require "koneksi.php";
require "functions.php";

$pageTitle = "Edit Buku";
$errors    = [];

// Form Processing (GET): ambil ID dari URL, contoh edit.php?id=3
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: daftar.php");
    exit;
}
$id = (int) $_GET['id'];

// Ambil data buku yang akan diedit
$buku = getBukuById($conn, $id);

// Percabangan: jika data dengan ID tersebut tidak ditemukan
if (!$buku) {
    header("Location: daftar.php?status=notfound");
    exit;
}

// Variabel awal diisi dari data lama
$judul    = $buku['judul'];
$penulis  = $buku['penulis'];
$penerbit = $buku['penerbit'];
$tahun    = $buku['tahun_terbit'];
$kategori = $buku['kategori'];
$stok     = $buku['stok'];

// Form Processing (POST): proses update saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = trim($_POST['judul']);
    $penulis  = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun    = trim($_POST['tahun_terbit']);
    $kategori = $_POST['kategori'];
    $stok     = (int) $_POST['stok'];

    $errors = validasiBuku($judul, $penulis, $tahun);

    if (count($errors) === 0) {
        $query = "UPDATE buku 
                  SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ?, kategori = ?, stok = ?
                  WHERE id_buku = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssisii", $judul, $penulis, $penerbit, $tahun, $kategori, $stok, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: daftar.php?status=update");
            exit;
        } else {
            $errors[] = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}

include "header.php";
?>

<section class="page-head">
    <p class="eyebrow">Edit Data</p>
    <h1>Ubah Data Buku <span class="mono">#<?php echo $id; ?></span></h1>
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

<form action="edit.php?id=<?php echo $id; ?>" method="POST" class="card form-slip">
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
            $listKategori = ["Fiksi", "Non-Fiksi", "Pendidikan", "Pengembangan Diri", "Lainnya"];
            foreach ($listKategori as $k) {
                $selected = ($kategori === $k) ? "selected" : "";
                echo "<option value='" . htmlspecialchars($k) . "' $selected>" . htmlspecialchars($k) . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-brass">Simpan Perubahan</button>
        <a href="daftar.php" class="btn btn-ghost">Batal</a>
    </div>
</form>

<?php include "footer.php"; ?>
