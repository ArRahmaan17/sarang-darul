-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Agu 2022 pada 20.41
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sarang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(30) NOT NULL,
  `nomer_petugas` varchar(13) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_petugas`, `nama_petugas`, `nomer_petugas`, `username`, `password`, `alamat`) VALUES
(1, 'test admin', '089522983270', 'test', 'test', 'test');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_keranjang` int(11) NOT NULL,
  `kode_transaksi` varchar(15) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_kandang` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `checkout` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_keranjang`, `kode_transaksi`, `id_pelanggan`, `id_kandang`, `jumlah_barang`, `checkout`) VALUES
(1, '120220625', 1, 1, 2, 1),
(2, '120220625', 1, 1, 2, 1),
(8, '120220626', 1, 1, 4, 1),
(10, '1202208042', 1, 1, 2, 0),
(11, '1202208042', 1, 2, 3, 0),
(12, '1202208042', 1, 3, 2, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandang`
--

CREATE TABLE `kandang` (
  `id_kandang` int(11) NOT NULL,
  `nama_kandang` varchar(30) NOT NULL,
  `ukuran_kandang` enum('sedang','besar') NOT NULL,
  `bahan_kandang` enum('kayu','besi') NOT NULL,
  `foto_kandang` text NOT NULL,
  `lama_pengerjaan` varchar(10) NOT NULL,
  `harga_kandang` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kandang`
--

INSERT INTO `kandang` (`id_kandang`, `nama_kandang`, `ukuran_kandang`, `bahan_kandang`, `foto_kandang`, `lama_pengerjaan`, `harga_kandang`) VALUES
(1, 'test', 'sedang', 'kayu', 'dajkhbwdawdawdaw.png', '1 minggu', 300000),
(2, 'test1', 'sedang', 'kayu', '1183215174_screenshot-localhost-2022.07.31-22_38_26.png', '1 minggu', 100000),
(3, 'test 1', 'sedang', 'kayu', '334451615_screenshot-localhost-2022.07.31-22_38_26.png', '1 minggu', 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(30) NOT NULL,
  `nomer_pelanggan` varchar(13) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `alamat_pelanggan` text NOT NULL,
  `account` enum('admin','pelanggan') NOT NULL DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `nomer_pelanggan`, `username`, `password`, `alamat_pelanggan`, `account`) VALUES
(1, 'test', '89522983270', 'test', 'test', 'test', 'pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `kode_transaksi` varchar(10) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_pesan` date NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai` date DEFAULT NULL,
  `foto_pembayaran` text DEFAULT NULL,
  `status_pesanan` enum('proses','jeruji','rangka','perangkaian','finishing','siapkirim','selesai') NOT NULL DEFAULT 'proses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `kode_transaksi`, `id_pelanggan`, `tanggal_pesan`, `tanggal_selesai`, `foto_pembayaran`, `status_pesanan`) VALUES
(1, '120220625', 1, '2022-06-25', NULL, NULL, 'jeruji'),
(2, '120220626', 1, '2022-06-26', NULL, '1372194179_Screenshot 05_08_2022 20.32.24.png', 'siapkirim');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL,
  `no_rekening` varchar(30) NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id_setting`, `no_rekening`, `id_petugas`) VALUES
(1, '49081oijwfqoyufw', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_kandang` (`id_kandang`),
  ADD KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `kandang`
--
ALTER TABLE `kandang`
  ADD PRIMARY KEY (`id_kandang`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kandang`
--
ALTER TABLE `kandang`
  MODIFY `id_kandang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
