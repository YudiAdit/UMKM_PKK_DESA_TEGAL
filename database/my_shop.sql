-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Agu 2024 pada 08.47
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
-- Database: `my_shop`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'laksana', '$2y$10$BfQLUgvNLrq6EndwDDFFJuLz3RgldoTJqk5NgQvTIdcFzyVYN7Bv2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Batik'),
(2, 'Makanan'),
(3, 'Rajutan'),
(4, 'Lukis'),
(5, 'cleaning'),
(6, 'lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`, `image`, `description`) VALUES
(14, 'basreng', 16000.00, 2, 'basreng edit.jpg', 'original taste'),
(15, 'karbol pinus', 50000.00, 5, 'karbol.jpg', 'pembersih ampuh'),
(16, 'sepatu biru', 200000.00, 6, 'sepatu biru.jpg', 'sepatu kualitas terbaik'),
(17, 'keripik ubi', 22000.00, 2, 'keripik ubi.jpg', 'dri ubi terbaik'),
(18, 'bumbu pecel', 7000.00, 2, 'bumbu pecel.jpg', 'Bumbu enak pecelnya mantap'),
(19, 'bawang goreng', 12000.00, 2, 'bawang goreng.jpg', 'nikmat dimakan dengan nasi'),
(20, 'bakpia', 21000.00, 2, 'pia.jpg', 'Bakpia nikmat untuk disantap'),
(24, 'Dompet Grany', 62000.00, 3, 'dompet granny.jpg', 'dompet'),
(25, 'Kotak Tisue', 105000.00, 3, 'kotak tisu.jpg', 'kotak untuk tisue'),
(26, 'Tas Handphone', 52000.00, 3, 'tas hp.jpg', 'Tas Hp'),
(27, 'Tas Botol Minum', 52000.00, 3, 'tas botol minum.jpg', 'Tas untuk botol minum'),
(28, 'Tas Grainy HP', 62000.00, 3, 'tas grainy hp.jpg', 'Tas untuk Hp'),
(29, 'Baju Rajutan', 355000.00, 3, 'baju rajutan.jpg', 'Baju Rajut '),
(30, 'Tas Grainy Hitam', 152000.00, 3, 'tas granny hitam.jpg', 'Cocok untuk dibawa kemana saja'),
(31, 'Tas Besar', 355000.00, 3, 'tas besar.jpg', 'cocok untuk dibawa kemana saja'),
(32, 'Topi Perca', 52000.00, 3, 'topi perca.jpg', 'Topi kualitas terbaik'),
(33, 'Stick Ubi', 16000.00, 2, 'stick ubi.jpg', 'Ubi Cilembu\r\nUbi Ungu'),
(34, 'Cheese Stick', 16000.00, 2, 'Cheese Stick.jpg', 'Rasa Original'),
(35, 'Keripik Kentang', 36000.00, 2, 'keripik kentang.jpg', 'Rasa Original'),
(36, 'Slondok', 9000.00, 2, 'slondok.jpg', 'Rasa Original'),
(38, 'Sepatu Lukis', 190000.00, 4, 'sepatu lukis.jpg', 'Sepatu lukis cantik'),
(39, 'Tas Tali Kulit', 85000.00, 4, 'tas tali kulit.jpg', 'Tas lukis '),
(40, 'Pouch Lucu', 25000.00, 4, 'pouch lucu.jpg', 'Pouch lukis lucu'),
(41, 'Topi Lukis Biasa', 70000.00, 4, 'topi lukis biasa.jpg', 'Topi lukis cantik'),
(42, 'Pouch Warna', 27000.00, 4, 'pouch warna.jpg', 'Banyak pilihan warna'),
(43, 'Topi Lukis Tali', 105000.00, 4, 'topi lukis tali.jpg', 'Topi lukis lucu'),
(44, 'Tas Botol Lukis', 52000.00, 4, 'tas botol lukis.jpg', 'Tas lukis untuk botol minuman'),
(45, 'Jaket Lukis Anak', 155000.00, 4, 'jaket lukis anak.jpg', 'Jaket lukis unicorn'),
(48, 'Batik Hem', 205000.00, 1, 'HEM.jpg', 'Batik jenis Hem'),
(49, 'Batik Tunik Resleting', 205000.00, 1, 'TUNINK RESLETING.jpg', 'Motif tunik resleting'),
(50, 'Batik Tunik Kancing', 205000.00, 1, 'TUNINK KANCING.jpg', 'Motif tunik kancing'),
(51, 'Batik Kain Eco Print', 150000.00, 1, 'KAIN ECO PRINT.jpg', 'Motif eco print'),
(52, 'Batik Outer', 205000.00, 1, 'Outer.jpg', 'Motif outer'),
(53, 'Kain Batik Senjaya', 500000.00, 1, 'KAIN BATIK SANJAYA.jpg', 'motif kain sanjaya'),
(54, 'Ikat Rambut Perca', 13000.00, 3, 'IKAT RAMBUT PERCA.jpg', 'Ikat rambut cantik');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
