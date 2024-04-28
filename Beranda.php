<?php
include ("ConnectionDatabase.php");

$conn = get_connection();
$data = fetchAllDataForTable($conn);
$graphData = fetchGraphData($conn);
closeDatabaseConnection($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Muat Barang</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top py-3">
        <div class="container">
            <a href="#" class="navbar-brand">Pengiriman Via Kereta Api</a>

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

    <div class="container mt-5 pt-5">
        <h2>Data Pengiriman</h2><br>
        <!-- Tabel Data Pengiriman -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-md-12 mb-5">
                <div class="card">
                    <div class="card-header text-bg-dark">
                        <h4 class="mb-0 d-flex justify-content-between align-items-center">
                            Daftar Muatan KA
                            <a href="DaftarMuat.php" class="btn btn-secondary">Tambah</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kota Tujuan</th>
                                    <th>Koli</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Tanggal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= ($row['kotatujuan']) ?></td>
                                        <td><?= ($row['koli']) ?></td>
                                        <td><?= ($row['berat']) ?></td>
                                        <td><?= ($row['harga']) ?></td>
                                        <td><?= ($row['tanggal']) ?></td>
                                        <td>
                                            <a href='DaftarMuat.php?edit=<?= $row['id_muat'] ?>' class='btn btn-primary'>Ubah</a>
                                            <a href='handle.php?hapus=<?= $row['id_muat'] ?>' class='btn btn-danger'>Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-10 col-md-12 mb-5">
                <div class="card">
                    <div class="card-header text-bg-dark">
                        <h4 class="card-title">Grafik Muat Barang</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="dataSelector" class="form-label">Pilih Perbandingan:</label>
                            <select class="form-select" id="dataSelector">
                                <option value="total_berat">Berat</option>
                                <option value="total_koli">Koli</option>
                                <option value="total_harga">Harga</option>
                            </select>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var rawData = <?php echo json_encode($graphData); ?>;
        var currentDataType = 'total_berat'; // Default data type

        function updateChartData() {
            var labels = [];
            var datasets = {};
            rawData.forEach(function (record) {
                var bulan = record.bulan;
                var kotatujuan = record.kotatujuan;
                var dataValue = record[currentDataType]; // Dynamic data value based on selected dataType
                if (!labels.includes(bulan)) {
                    labels.push(bulan);
                }
                if (!datasets[kotatujuan]) {
                    datasets[kotatujuan] = {
                        label: kotatujuan,
                        data: [],
                        borderColor: randomColor(),
                        fill: false,
                        tension: 0.1
                    };
                }
                datasets[kotatujuan].data.push({ x: bulan, y: dataValue });
            });

            var chartDataSets = Object.values(datasets);

            myChart.data.labels = labels;
            myChart.data.datasets = chartDataSets;
            myChart.update();
        }

        function randomColor() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return 'rgb(' + r + ',' + g + ',' + b + ')';
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Initialize chart with default data type
        updateChartData();

        // Event listener for the dropdown change
        document.getElementById('dataSelector').addEventListener('change', function () {
            currentDataType = this.value;
            updateChartData();
        });
    </script>
</body>

</html>