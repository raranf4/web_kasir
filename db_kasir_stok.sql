-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2026 at 03:34 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kasir_stok`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Roti & Bun', '2026-05-18 15:43:21', '2026-05-18 15:43:21'),
(2, 'Cake & Pastry', '2026-05-18 15:43:21', '2026-05-18 15:43:21'),
(3, 'Kue Kering', '2026-05-18 15:43:21', '2026-05-18 15:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_05_18_000000_create_roles_table', 1),
(2, '0001_01_01_000000_create_users_table', 1),
(3, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '2026_05_18_231014_create_kategoris_table', 1),
(6, '2026_05_18_231021_create_produks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `kategori_id`, `nama_produk`, `harga`, `stok`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dinner Rolls', 25000.00, 12, 'Dinner rolls adalah roti kecil berbentuk bulat yang disajikan sebagai pelengkap hidangan utama dalam jamuan bergaya Barat. Roti ini memiliki tekstur yang sangat lembut dan empuk dengan rasa yang sedikit manis. Biasanya dinikmati hangat bersama olesan mentega, sup, atau daging panggang.', 'uploads/produk/1779205021.jpg', '2026-05-18 15:43:21', '2026-05-19 08:48:30'),
(2, 1, 'Croissant Original', 22000.00, 12, 'Croissant original adalah pastry klasik asal Prancis yang memiliki bentuk menyerupai bulan sabit. Terbuat dari adonan berlapis (laminated pastry) dengan mentega, bagian luarnya sangat renyah (flaky) dan berwarna cokelat keemasan, sedangkan bagian dalamnya memiliki tekstur yang lembut, empuk, dan memiliki cita rasa gurih yang khas', 'uploads/produk/1779207405.jpg', '2026-05-18 15:43:21', '2026-05-19 09:16:45'),
(3, 1, 'Roti Sisir Mentega', 14000.00, 25, 'Roti Sisir Mentega adalah roti klasik Indonesia dengan tekstur sangat lembut dan bentuk menyerupai sisir. Roti ini memiliki perpaduan rasa manis dan gurih yang khas berkat olesan mentega. Biasanya dinikmati dengan cara menyobek setiap lembarnya, roti ini sangat cocok sebagai teman minum kopi atau teh hangat.', 'uploads/produk/1779207473.jpg', '2026-05-18 15:43:21', '2026-05-19 09:17:53'),
(4, 1, 'Roti Abon Sapi', 16500.00, 20, 'Roti abon sapi adalah jenis roti gurih (savory) yang memadukan kelembutan tekstur roti dengan taburan abon daging sapi yang melimpah. Biasanya, permukaan roti dilapisi dengan mayones atau cream cheese manis yang membuat abon menempel sempurna, menghasilkan kombinasi rasa gurih, manis, dan creamy.', 'uploads/produk/1779207516.jpg', '2026-05-18 15:43:21', '2026-05-19 09:18:36'),
(5, 2, 'Fudge Brownies Slice', 25000.00, 10, 'Fudgy Brownies Slice adalah potongan kue cokelat dengan ciri khas tekstur yang padat, lembap, legit, dan kenyal di dalam. Disajikan dalam bentuk irisan atau potong-potong, sajian ini memiliki rasa cokelat yang pekat dan bagian atas yang mengkilap (shiny crust).', 'uploads/produk/1779207583.jpg', '2026-05-18 15:43:21', '2026-05-19 09:19:43'),
(6, 2, 'Strawberry Cheese Cake', 35000.00, 8, 'Strawberry Cheese Cake adalah hidangan penutup (dessert) lezat yang memadukan lapisan biskuit renyah di bagian dasar, krim keju yang lembut dan creamy, serta siraman saus atau potongan buah stroberi segar di atasnya. Kue ini menyajikan sensasi rasa manis, gurih, dan asam yang menyegarkan', 'uploads/produk/1779207708.jpg', '2026-05-18 15:43:21', '2026-05-19 09:21:48'),
(7, 2, 'Choux Pastry (Kue Soes)', 8000.00, 30, 'Choux pastry (lebih dikenal sebagai Kue Soes) adalah kue klasik asal Prancis dengan tekstur unik: renyah di luar namun kopong dan lembut di dalam. Adonan dasarnya dimasak di atas kompor sebelum dipanggang, lalu diberi isian vla (custard) manis.', 'uploads/produk/1779207762.jpg', '2026-05-18 15:43:21', '2026-05-19 09:22:42'),
(8, 3, 'Nastar Keju Premium (Toples)', 85000.00, 15, 'Nastar Keju Premium adalah kue kering klasik dengan adonan lumer di mulut, memadukan mentega berkualitas dan isian selai nanas asli. Bagian atasnya diolesi kuning telur dan taburan keju parut (Cheddar/Edam), memberikan sensasi rasa manis, legit, dan gurih.', 'uploads/produk/1779207811.jpg', '2026-05-18 15:43:21', '2026-05-19 09:23:31'),
(9, 3, 'Kastengel Garing (Toples)', 90000.00, 10, 'Kastengel garing adalah kue kering klasik berbentuk batang yang sangat renyah, gurih, dan sarat akan cita rasa keju. Dikemas dalam toples kedap udara, kue ini menjadi camilan favorit yang praktis untuk disajikan saat hari raya, Lebaran, atau sebagai bingkisan.', 'uploads/produk/1779207884.jpg', '2026-05-18 15:43:21', '2026-05-19 09:24:44'),
(10, 3, 'Choco Chip Cookies', 45000.00, 18, 'Choco chip cookies adalah kue kering manis yang memiliki ciri khas tekstur renyah di luar dan lembut di dalam. Kue ini dibuat dari adonan dasar mentega, gula, dan telur yang dicampur dengan potongan kepingan cokelat (choco chips) sebelum dipanggang.', 'uploads/produk/1779208058.jpg', '2026-05-18 15:43:21', '2026-05-19 09:27:38'),
(11, 2, 'Blueberry Cheescake', 24000.00, 25, 'Blueberry cheesecake adalah hidangan penutup manis berupa kue keju lembut di atas lapisan renyah biskuit, yang diberi topping saus buah blueberry. Kue ini sangat populer karena menyajikan kombinasi sempurna antara rasa keju yang gurih, krim yang creamy, serta sensasi manis dan asam segar dari buah blueberry.', 'uploads/produk/1779208165.jpg', '2026-05-19 09:29:25', '2026-05-19 09:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama_role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-05-18 15:43:20', '2026-05-18 15:43:20'),
(2, 'user', '2026-05-18 15:43:20', '2026-05-18 15:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('T0JWksA2w3j96L5entWW92vRo8cRbStb6TnCHXdH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWl0ZmtzSDhueUp2ZzJXUGVDTzZJcm1Dd2d2Ump6TFRvYW5lUEo3VSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1779206809),
('TO2VGSa9iaglqmkXp9IQH5t7OyaMAXb4uo1H55C1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiempVN0l1QWYxMmFFWjE2c053djBnMFVYanROdXU2NlZUckNtRkVZeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VyL3Byb2R1ayI7fX0=', 1779207306);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Owner Bakery (Admin)', 'admin@bakery.com', NULL, '$2y$12$HrTkVpV2ANY2EpxSCZzSp.XHsvKhGtk9HRuxTOGaYkP5Rq2jhXlYO', NULL, '2026-05-18 15:43:20', '2026-05-18 15:43:20'),
(2, 2, 'Izuma', 'kasir1@bakery.com', NULL, '$2y$12$2pP2w2Sjc8OcKXJyHpcOSuWLpENOvjPsizrPLuaRMagdsG592hnnW', NULL, '2026-05-18 15:43:21', '2026-05-18 15:43:21'),
(3, 2, 'Rzee', 'kasir2@bakery.com', NULL, '$2y$12$4ouOkUpQFi.Oe446QffYJOsNuj4pFzuVDY8mr7/ps142yHcAOUYbG', NULL, '2026-05-18 15:43:21', '2026-05-18 15:43:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produks_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produks`
--
ALTER TABLE `produks`
  ADD CONSTRAINT `produks_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
