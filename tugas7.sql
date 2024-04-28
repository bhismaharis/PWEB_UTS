-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Apr 2024 pada 08.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tugas-7`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kotatujuan`
--

CREATE TABLE `tbl_kotatujuan` (
  `id_kotatujuan` int(11) NOT NULL,
  `kotatujuan` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_kotatujuan`
--

INSERT INTO `tbl_kotatujuan` (`id_kotatujuan`, `kotatujuan`) VALUES
(32, 'BBT'),
(9, 'BDG'),
(43, 'BGL'),
(3, 'BGR'),
(31, 'BJO'),
(11, 'BJR'),
(6, 'BKS'),
(38, 'BLT'),
(8, 'CKP'),
(7, 'CLG'),
(30, 'CPU'),
(12, 'CRB'),
(5, 'DPK'),
(50, 'DPS'),
(17, 'GBO'),
(40, 'GSK'),
(33, 'JBG'),
(46, 'JBR'),
(4, 'JKT'),
(18, 'KBM'),
(36, 'KDR'),
(24, 'KLT'),
(15, 'KRY'),
(19, 'KTA'),
(49, 'KTP'),
(29, 'KTS'),
(27, 'MDN'),
(34, 'MJK'),
(39, 'MLG'),
(28, 'NGA'),
(16, 'PKL'),
(41, 'PMK'),
(45, 'PRB'),
(44, 'PSR'),
(13, 'PWT'),
(48, 'RJP'),
(42, 'SDA'),
(25, 'SLO'),
(21, 'SMG'),
(1, 'SNG'),
(26, 'SRG'),
(22, 'STB'),
(35, 'SUB'),
(2, 'TGA'),
(14, 'TGL'),
(47, 'TGU'),
(37, 'TLA'),
(10, 'TSM'),
(20, 'WAT'),
(23, 'YOG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_muat`
--

CREATE TABLE `tbl_muat` (
  `id_muat` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_kotatujuan` int(11) NOT NULL,
  `koli` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_muat`
--

INSERT INTO `tbl_muat` (`id_muat`, `tanggal`, `id_kotatujuan`, `koli`, `berat`, `harga`) VALUES
(1, '2024-04-17', 37, 5, 42, 260000),
(2, '2024-04-15', 24, 1, 10, 80000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_kotatujuan`
--
ALTER TABLE `tbl_kotatujuan`
  ADD PRIMARY KEY (`id_kotatujuan`),
  ADD UNIQUE KEY `kotatujuan` (`kotatujuan`);

--
-- Indeks untuk tabel `tbl_muat`
--
ALTER TABLE `tbl_muat`
  ADD PRIMARY KEY (`id_muat`),
  ADD KEY `fk_tbl_kotatujuan` (`id_kotatujuan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_kotatujuan`
--
ALTER TABLE `tbl_kotatujuan`
  MODIFY `id_kotatujuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `tbl_muat`
--
ALTER TABLE `tbl_muat`
  MODIFY `id_muat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_muat`
--
ALTER TABLE `tbl_muat`
  ADD CONSTRAINT `fk_tbl_kotatujuan` FOREIGN KEY (`id_kotatujuan`) REFERENCES `tbl_kotatujuan` (`id_kotatujuan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
