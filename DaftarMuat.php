<?php
include 'ConnectionDatabase.php'; 

// Mengambil data kota tujuan untuk dropdown
$kotaTujuanOptions = fetchKotaTujuan();

require_once "ConnectionDatabase.php";

if(isset($_GET['edit'])) {
  $data = $_GET["edit"];
  $result = fetchOne($data);
  $id = $result['id_muat'];
  $tanggal = $result['tanggal'];
  $id_kotatujuan = $result['id_kotatujuan'];
  $koli = $result['koli'];
  $berat = $result['berat'];
  $harga = $result['harga'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= , initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Title -->
    <title>Daftar Muat Kereta Api</title>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top py-3">
        <div class="container">
            <a href="Beranda.php" class="navbar-brand">Daftar Muat Kereta Api</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="Beranda.php" class="nav-link">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Surat Pengiriman</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Card Tabel -->
    <div class="container mt-5 pt-5">
        <!-- <h2>Form Pengiriman Barang</h2> -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-md-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        <!-- <?php if (isset($pesanError))
                            echo $pesanError; ?> -->
                        <form class="form" action="handle.php" method="POST">
                            <input type="text" class="form-control" id="id_muat" name="id_muat" value="<?php echo $id ?>" required hidden>
                            <div class="form-group row mb-2">
                                <label class="col-xl-3" for="tanggal">Tanggal</label>
                                <div class="col-xl-6">
                                    <!-- Di sini, tambahkan nilai default berdasarkan kondisi yang diberikan -->
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo isset($_GET['edit']) ? $tanggal : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-xl-3" for="kotaTujuan">Kota Tujuan</label>
                                <div class="col-xl-6">
                                    <select class="form-control" id="kotaTujuan" name="kotaTujuan" required>
                                        <?php foreach ($kotaTujuanOptions as $option): ?>
                                            <!-- Di sini, tambahkan kondisi untuk menetapkan opsi yang dipilih -->
                                            <option value="<?php echo $option['id_kotatujuan']; ?>" <?php echo (isset($_GET['edit']) && $option['id_kotatujuan'] == $id_kotatujuan) ? 'selected' : ''; ?>>
                                                <?php echo $option['kotatujuan']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-xl-3" for="koli">Koli</label>
                                <div class="col-xl-6">
                                    <input type="number" class="form-control" id="koli" name="koli" value="<?php echo isset($_GET['edit']) ? $koli : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-xl-3" for="berat">Berat</label>
                                <div class="col-xl-6">
                                    <input type="number" class="form-control" id="berat" name="berat" value="<?php echo isset($_GET['edit']) ? $berat : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-xl-3" for="harga">Harga</label>
                                <div class="col-xl-6">
                                    <input type="number" class="form-control" id="harga" name="harga" value="<?php echo isset($_GET['edit']) ? $harga : ''; ?>" required>
                                </div>
                            </div>
                            <br>
                            <?php if (isset($_GET["edit"])) : ?>
                                <button type="submit" name="aksi" value="edit" class="btn btn-secondary">Simpan Perubahan</button>
                            <?php else : ?>
                                <button type="submit" name="aksi" value="add" class="btn btn-secondary">Submit</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>