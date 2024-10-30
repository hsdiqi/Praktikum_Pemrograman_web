<?php
require 'tiket.php';
use PemesananTiket\TiketWisata;

$daftarWisata = [
    "Candi Bajangratu" => 100000,
    "Museum Majapahit" => 150000,
    "Patung Budha Tidur" => 200000,
    "Taman Ghanjaran" => 120000
];

$tiket = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaWisata = $_POST['namaWisata'];
    $harga = intval($_POST['harga']);
    $jumlah = intval($_POST['jumlah']);
    $namaPemesan = $_POST['namaPemesan'];

    $tiket = new TiketWisata($namaWisata, $harga);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket Wisata</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function updateHarga() {
            const daftarWisata = <?php echo json_encode($daftarWisata); ?>;
            const wisataTerpilih = document.getElementById("namaWisata").value;
            document.getElementById("harga").value = daftarWisata[wisataTerpilih] || 0;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Pemesanan Tiket Wisata</h2>
        <form method="POST">
            <label>Nama Wisata:</label>
            <select id="namaWisata" name="namaWisata" onchange="updateHarga()" required>
                <option value="">Pilih Wisata</option>
                <?php foreach ($daftarWisata as $nama => $harga): ?>
                    <option value="<?= $nama ?>"><?= $nama ?></option>
                <?php endforeach; ?>
            </select>

            <label>Harga per Tiket:</label>
            <input type="number" id="harga" name="harga" readonly required>

            <label>Jumlah Tiket:</label>
            <input type="number" name="jumlah" required>

            <label>Nama Pemesan:</label>
            <input type="text" name="namaPemesan" required>

            <button type="submit">Pesan Tiket</button>
        </form>

        <?php if ($tiket): ?>
            <div class="output">
                <h3>Detail Pemesanan</h3>
                <?php $tiket->infoTiket($_POST['jumlah']); ?>
                <?php $tiket->cetakTiket($_POST['namaPemesan']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
