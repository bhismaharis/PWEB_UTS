<?php
session_start();
require_once "ConnectionDatabase.php";

if (isset($_POST["aksi"])) {
  if ($_POST["aksi"] === "add") {
    echo "<script>alert('".$_POST['kotaTujuan']."');</script>";
    $sukses = store($_POST);
    
    if ($sukses) {
      $_SESSION["alert"] = "Data berhasil ditambahkan";
      header("Location: Beranda.php");
    } else {
      echo $stmt;
    }
  } else if ($_POST["aksi"] === "edit") {
    $sukses = update($_POST);
    if ($sukses) {
      $_SESSION["alert"] = "Data berhasil diperbarui";
      header("Location: Beranda.php");
    } else {
      echo $stmt;
    }
  }
}

if (isset($_GET["hapus"])) {
  $sukses = destroy($_GET);
  if ($sukses) {
    $_SESSION["alert"] = "Data berhasil dihapus";
    header("Location: Beranda.php");
  } else {
    echo $stmt;
  }
}
