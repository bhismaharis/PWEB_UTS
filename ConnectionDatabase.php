<?php
define('DB_HOST', 'localhost'); 
define('DB_USER', 'root');
define('DB_PASS', ''); 
define('DB_NAME', 'db_bhisma');

function get_connection()
{
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }
    return $conn;
}

function closeDatabaseConnection($conn)
{
    $conn->close();
}

function fetchAllDataForTable($conn)
{
    $sql = "
        SELECT 
            m.id_muat,
            k.kotatujuan,
            m.koli,
            m.berat,
            m.harga,
            DATE_FORMAT(m.tanggal, '%Y-%m-%d') AS tanggal
        FROM 
            tbl_muat m 
            JOIN tbl_kotatujuan k ON m.id_kotatujuan = k.id_kotatujuan
        ORDER BY 
            m.id_muat DESC
    ";
    return fetchAll($conn, $sql);
}

function fetchGraphData($conn)
{
    $sql = "
        SELECT 
            DATE_FORMAT(m.tanggal, '%Y-%m') AS bulan, 
            k.kotatujuan, 
            SUM(m.berat) AS total_berat,
            SUM(m.koli) AS total_koli,
            SUM(m.harga) AS total_harga
        FROM 
            tbl_muat m 
            JOIN tbl_kotatujuan k ON m.id_kotatujuan = k.id_kotatujuan 
        GROUP BY 
            bulan, k.kotatujuan
        ORDER BY 
            bulan ASC
    ";
    return fetchAll($conn, $sql);
}

function fetchAll($conn, $sql)
{
    $result = $conn->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
        die("Query failed: " . $conn->error);
    }
    return $rows;
}

function fetchOne($id)
{
//   global $conn;
  $conn = get_connection();

  $stmt = $conn->prepare("SELECT * FROM tbl_muat WHERE id_muat = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $result = [
      'id_muat' => $row['id_muat'],
      'tanggal' => $row['tanggal'],
      'id_kotatujuan' => $row['id_kotatujuan'],
      'koli' => $row['koli'],
      'berat' => $row['berat'],
      'harga' => $row['harga'],
    ];
    return $result;
  } else {
    return null;
  }
}

function fetchKotaTujuan()
{
    $conn = get_connection();
    $result = $conn->query("SELECT id_kotatujuan, kotatujuan FROM tbl_kotatujuan ORDER BY kotatujuan");
    $kotaTujuanOptions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $kotaTujuanOptions[] = $row;
        }
    }
    return $kotaTujuanOptions;
}

function getIdKotaTujuan($kotaTujuan) {
    $conn = get_connection();
    $stmt = $conn->prepare("SELECT id_kotatujuan FROM tbl_kotatujuan WHERE kotatujuan = ?");
    if ($stmt === false) {
        die('Kesalahan pada prepare MySQL: ' . $conn->error);
    }

    $stmt->bind_param("s", $kotaTujuan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $idKotaTujuan = $row['id_kotatujuan'];
        $stmt->close();
        $conn->close();
        return $idKotaTujuan;
    } else {
        $stmt->close();
        $conn->close();
        return null; // Kembalikan null jika tidak ada id yang cocok ditemukan
    }
}

function store($data)
{
    // global $conn;
    $conn = get_connection();

    $tanggal = $data['tanggal'];
    $kotaTujuan = $data['kotaTujuan'];
    $koli = $data['koli'];
    $berat = $data['berat'];
    $harga = $data['harga'];

    // $idKotaTujuan = getIdKotaTujuan($kotaTujuan);
    // if ($idKotaTujuan === null) {
    //     echo "Kotatujuan tidak valid: $kotaTujuan";
    //     return false; // Hentikan eksekusi jika tidak ada ID yang valid ditemukan
    // }

    $stmt = $conn->prepare("INSERT INTO tbl_muat (tanggal, id_kotatujuan, koli, berat, harga) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siidd", $tanggal, $kotaTujuan, $koli, $berat, $harga);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    return true;
}

function update($data)
{
    // global $conn;
    $conn = get_connection();

    $id = $data['id_muat'];
    $tanggal = $data['tanggal'];
    $idKotaTujuan = $data['kotaTujuan'];
    $koli = $data['koli'];
    $berat = $data['berat'];
    $harga = $data['harga'];

    $stmt = $conn->prepare("UPDATE tbl_muat SET id_kotatujuan = ?, koli = ?, berat = ?, harga = ?, tanggal = ? WHERE id_muat = ?");
    $stmt->bind_param("iiiisi", $idKotaTujuan, $koli, $berat, $harga, $tanggal, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    return true;
}


function destroy($data)
{
    // global $conn;
    $conn = get_connection();

    $id = $data['hapus'];
    $stmt = $conn->prepare('DELETE FROM tbl_muat WHERE id_muat = ?');
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    header("Location: Beranda.php");
    return true;
}
?>