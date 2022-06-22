-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 20, 2022 at 07:15 AM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorie_articles`
--

CREATE TABLE `categorie_articles` (
  `reference_article` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `depots`
--

CREATE TABLE `depots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Contact du responsable',
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point_vente` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Permet de savoir si un depot est un entrepôt ou un point de vente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depots`
--

INSERT INTO `depots` (`id`, `nom`, `contact`, `localisation`, `point_vente`, `created_at`, `updated_at`) VALUES
(4, 'Mon second point de vente', '0334534543 - 0324323412', 'Mangarivotra sud', 1, '2022-06-15 09:47:50', '2022-06-17 05:04:47'),
(7, 'Mon premier entrepot', '0341234565', 'Bazar be, Rue test', 0, '2022-06-20 04:00:35', '2022-06-20 04:10:48'),
(8, 'Nouveau entrepot de test', '0341234565', 'Mangarano', 0, '2022-06-20 04:01:19', '2022-06-20 04:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fonctions`
--

CREATE TABLE `fonctions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_fonction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_fonction` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fonctions`
--

INSERT INTO `fonctions` (`id`, `nom_fonction`, `description_fonction`, `created_at`, `updated_at`) VALUES
(1, 'Magasinier', 'Responsable du magasin', '2022-06-17 08:17:19', '2022-06-17 08:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `fonction_inclusions`
--

CREATE TABLE `fonction_inclusions` (
  `fonction_parent` bigint(20) UNSIGNED NOT NULL,
  `fonction_enfant` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fonction_roles`
--

CREATE TABLE `fonction_roles` (
  `fonction` bigint(20) UNSIGNED NOT NULL,
  `role` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fonction_roles`
--

INSERT INTO `fonction_roles` (`fonction`, `role`) VALUES
(1, 1),
(1, 2),
(1, 5),
(1, 8),
(1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2022_06_01_072044_create_articles_table', 1),
(3, '2022_06_01_072044_create_categorie_articles_table', 1),
(4, '2022_06_01_072044_create_categories_table', 1),
(5, '2022_06_01_072044_create_failed_jobs_table', 1),
(6, '2022_06_01_072044_create_fonctions_table', 1),
(7, '2022_06_01_072044_create_password_resets_table', 1),
(8, '2022_06_01_072044_create_personnel_fonctions_table', 1),
(9, '2022_06_01_072044_create_roles_table', 1),
(10, '2022_06_01_072044_create_user_roles_table', 1),
(11, '2022_06_01_072044_create_users_table', 1),
(12, '2022_06_01_072045_add_foreign_keys_to_categorie_articles_table', 1),
(13, '2022_06_01_072045_add_foreign_keys_to_personnel_fonctions_table', 1),
(14, '2022_06_01_072045_add_foreign_keys_to_user_roles_table', 1),
(15, '2022_06_02_052406_create_fonction_roles_table', 1),
(16, '2022_06_03_074330_create_fonction_inclusions_table', 1),
(17, '2022_06_14_063643_create_depots_table', 1),
(18, '2022_06_14_070421_create_travailler_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(11, 'App\\Models\\User', 6, 'API Token', 'b3a924c433fa841ff88e518b48ab174a1e3e96a355db454f8a35c137f7e84f3c', '[\"*\"]', NULL, '2022-06-17 08:19:30', '2022-06-17 08:19:30'),
(12, 'App\\Models\\User', 6, 'API Token', 'eeccc8f535221b2608ef28f8633d3b68a09da6d7ed2ab381605a6dbdda6a387c', '[\"*\"]', NULL, '2022-06-17 10:55:17', '2022-06-17 10:55:17'),
(13, 'App\\Models\\User', 2, 'API Token', '552690771d75508315f2b5ba5434a437c8c414aa799aaa358e10487166c10145', '[\"*\"]', NULL, '2022-06-20 02:36:30', '2022-06-20 02:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `personnel_fonctions`
--

CREATE TABLE `personnel_fonctions` (
  `personnel` bigint(20) UNSIGNED NOT NULL,
  `fonction` bigint(20) UNSIGNED NOT NULL,
  `date_association` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personnel_fonctions`
--

INSERT INTO `personnel_fonctions` (`personnel`, `fonction`, `date_association`) VALUES
(2, 1, '2022-06-20 06:47:56'),
(6, 1, '2022-06-17 11:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nom_role`, `created_at`, `updated_at`, `description`) VALUES
(1, 'add_point_vente', NULL, NULL, 'Ajouter un nouveau point de vente'),
(2, 'view_point_vente', NULL, NULL, 'Voir la liste de point de vente'),
(3, 'manage_roles_and_functions', NULL, NULL, 'Gerer les personnels et les roles'),
(4, 'add_user', NULL, NULL, 'Ajouter un nouveau personnel'),
(5, 'delete_user', NULL, NULL, 'Supprimer un personnel'),
(6, 'view_user', NULL, NULL, 'Voir la liste des utilisateur'),
(7, 'edit_user', NULL, NULL, 'Modifier un personnel'),
(8, 'edit_point_vente', NULL, NULL, 'Modifier un point de vente'),
(9, 'delete_point_vente', NULL, NULL, 'Supprimer un point de vente'),
(10, 'add_entrepot', NULL, NULL, 'Ajouter une nouvelle entrepôt'),
(11, 'view_entrepot', NULL, NULL, 'Voir la liste des entrepôt'),
(12, 'edit_entrepot', NULL, NULL, 'Modifier un entrepôt'),
(13, 'delete_entrepot', NULL, NULL, 'Supprimer un entrepôt');

-- --------------------------------------------------------

--
-- Table structure for table `travailler`
--

CREATE TABLE `travailler` (
  `personnel` bigint(20) UNSIGNED NOT NULL,
  `depot` bigint(20) UNSIGNED NOT NULL,
  `est_responsable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Permet de determiner si le personnel est responsable de ce depot',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `travailler`
--

INSERT INTO `travailler` (`personnel`, `depot`, `est_responsable`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NULL, NULL),
(1, 8, 1, NULL, NULL),
(2, 4, 0, NULL, NULL),
(3, 4, 0, NULL, NULL),
(4, 7, 1, NULL, NULL),
(5, 4, 1, NULL, NULL),
(6, 4, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_personnel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenoms_personnel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_personnel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_personnel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cin_personnel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom_personnel`, `prenoms_personnel`, `contact_personnel`, `adresse_personnel`, `cin_personnel`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Carson', 'Senger', '(586) 656-7429', '18735 Zieme Junctions Apt. 763\nWest Declan, AK 98577', '669440872009', 'xzavier.kassulke', 'merle.berge@example.org', '2022-06-14 04:21:50', 'eyJpdiI6Ikw2MFJGMytmOTVJeXlPUlFHWGh0RkE9PSIsInZhbHVlIjoiVllYbWlYc3BSUW90QWVDT3ZTRDhGdz09IiwibWFjIjoiOGE4MGQ3ZWVhMWE5MTk4MGM3MTdiMDRlZjVmOWQzZDNmM2U0OTg1OWYwMjAzYWY1ZWU2MmEwMDQ4NmE1MWNiMCIsInRhZyI6IiJ9', 'zMhP3j0e1r', '2022-06-14 04:21:50', '2022-06-14 04:21:50'),
(2, 'Everardo', 'Okuneva', '+261323434543', '170 Jenkins Ford Suite 468\nDaxview, WY 82726-9800', '772769692059', 'annie03', 'ashly.hettinger@example.org', '2022-06-14 04:21:50', 'eyJpdiI6ImFTWERVNVlLSnlqY2VKdEVqVTYzd3c9PSIsInZhbHVlIjoiSzlORHQ5MXQ4azNudTJPdTRaU3NvZz09IiwibWFjIjoiMmZjNGZiYzRkYzUwODA0OTY0Nzg0ODY1OWM4NmNmODQ5MzgwN2I5MDg1MzAxYWNiNzJkMGU4MTdkOTQ2MjJiZSIsInRhZyI6IiJ9', 'OoXlOZ82Ycd8xK4tVSWhZwpRhR988zTNlc8HQEz4c7goU4aunE8bj5TC0Vo8', '2022-06-14 04:21:50', '2022-06-20 03:47:56'),
(3, 'Reed', 'Stiedemann', '+1.978.298.1558', '7521 Ena Locks Apt. 552\nGreenfelderbury, HI 66655', '436950185815', 'zmayert', 'jaime.emard@example.net', '2022-06-14 04:21:50', 'eyJpdiI6IkQvY1JoVEhpYy9VNkpiZjIvTnNTd1E9PSIsInZhbHVlIjoiam1waHJtT2pCS2dKNTlmUzl5NjZlQT09IiwibWFjIjoiYTczNWE1YjRiYTk3NjVlOWQ4NGI1MDMxMjM4NTU4MzZkOWJkNjQ1ZjdlZDQ3MjA5YTVmYWI3NTcxMTI4ODQ5YyIsInRhZyI6IiJ9', 'wiBPMr7skp', '2022-06-14 04:21:50', '2022-06-14 04:21:50'),
(4, 'Nia', 'Stark', '1-248-731-3998', '531 Goodwin Mountains\nEast Tarynfort, ME 56552-5926', '853073206437', 'ashtyn.wiza', 'nicklaus.sipes@example.org', '2022-06-14 04:21:50', 'eyJpdiI6IjdNMHlBQ0ZvS1RIM1hmcGVOcTNIa2c9PSIsInZhbHVlIjoiL2xTZXg1QmZuZlhOZUQxQW5hN3hBdz09IiwibWFjIjoiN2NlNzUyMzg1MzUyM2M4OTkyZjg5Yzg5ZDY5N2JhMWJhNTNjZjc2OTA1ZmM2YWM0MjIxOWU2YzUxMjU4ZWViNyIsInRhZyI6IiJ9', 'q4QEyRWTb3', '2022-06-14 04:21:50', '2022-06-14 04:21:50'),
(5, 'Patience', 'Kulas', '+1-585-230-1029', '14649 Rosemarie Springs\nCarleytown, CT 94808-7602', '160722886311', 'vladimir.heaney', 'davis.trevor@example.org', '2022-06-14 04:21:50', 'eyJpdiI6IlRzTTB1UnFUVmc3OTlkNmk4WVJZMVE9PSIsInZhbHVlIjoiQTdaVit6NzBiUHNYWmNTWHMzRkNOQT09IiwibWFjIjoiYmNkMzQxYmU5ZWFkM2Q1NWEzMWIyNDc1ZjEzMWUzZWU0OTlmMmY0OGFjODY3NWQ2ZmIxNTc5OWVkNjYyMDI1MSIsInRhZyI6IiJ9', 'U3no8cqrEB', '2022-06-14 04:21:50', '2022-06-14 04:21:50'),
(6, 'RAKOTO', 'Beloha', '+261324543212', 'Tanambao 5', NULL, 'rakoto-beloha', NULL, NULL, 'eyJpdiI6Ijg3YzhjRTZ1MUw0aENKdldCSk9GYVE9PSIsInZhbHVlIjoiZ2Y0NjBTWW5ZTXArMnl2R2ZVN1ZsZz09IiwibWFjIjoiY2I3ZThhODYzYWM4MmFlYmM5ZTJiZDU2YWRkZDllOTU0MjE2NWQxMGI5YTUzNTNiMGNjNWViNTkyZjc4YzZmNCIsInRhZyI6IiJ9', NULL, '2022-06-17 08:18:02', '2022-06-17 08:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(6, 1),
(6, 2),
(6, 5),
(6, 8),
(6, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`reference`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorie_articles`
--
ALTER TABLE `categorie_articles`
  ADD PRIMARY KEY (`categorie_id`,`reference_article`),
  ADD KEY `fk_article` (`reference_article`),
  ADD KEY `fk_categorie` (`categorie_id`);

--
-- Indexes for table `depots`
--
ALTER TABLE `depots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fonctions`
--
ALTER TABLE `fonctions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fonctions_nom_fonction_unique` (`nom_fonction`);

--
-- Indexes for table `fonction_inclusions`
--
ALTER TABLE `fonction_inclusions`
  ADD PRIMARY KEY (`fonction_parent`,`fonction_enfant`),
  ADD KEY `fonction_inclusions_fonction_enfant_foreign` (`fonction_enfant`);

--
-- Indexes for table `fonction_roles`
--
ALTER TABLE `fonction_roles`
  ADD PRIMARY KEY (`fonction`,`role`),
  ADD KEY `fk_role_fonction` (`role`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `personnel_fonctions`
--
ALTER TABLE `personnel_fonctions`
  ADD PRIMARY KEY (`personnel`,`fonction`),
  ADD KEY `fk_fonction` (`fonction`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nom_role` (`nom_role`);

--
-- Indexes for table `travailler`
--
ALTER TABLE `travailler`
  ADD PRIMARY KEY (`personnel`,`depot`),
  ADD KEY `travailler_depot_foreign` (`depot`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_cin_personnel_unique` (`cin_personnel`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `depots`
--
ALTER TABLE `depots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fonctions`
--
ALTER TABLE `fonctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categorie_articles`
--
ALTER TABLE `categorie_articles`
  ADD CONSTRAINT `fk_article` FOREIGN KEY (`reference_article`) REFERENCES `articles` (`reference`),
  ADD CONSTRAINT `fk_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `fonction_inclusions`
--
ALTER TABLE `fonction_inclusions`
  ADD CONSTRAINT `fonction_inclusions_fonction_enfant_foreign` FOREIGN KEY (`fonction_enfant`) REFERENCES `fonctions` (`id`),
  ADD CONSTRAINT `fonction_inclusions_fonction_parent_foreign` FOREIGN KEY (`fonction_parent`) REFERENCES `fonctions` (`id`);

--
-- Constraints for table `fonction_roles`
--
ALTER TABLE `fonction_roles`
  ADD CONSTRAINT `fk_fonction_role` FOREIGN KEY (`fonction`) REFERENCES `fonctions` (`id`),
  ADD CONSTRAINT `fk_role_fonction` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

--
-- Constraints for table `personnel_fonctions`
--
ALTER TABLE `personnel_fonctions`
  ADD CONSTRAINT `fk_fonction` FOREIGN KEY (`fonction`) REFERENCES `fonctions` (`id`),
  ADD CONSTRAINT `fk_personnel` FOREIGN KEY (`personnel`) REFERENCES `users` (`id`);

--
-- Constraints for table `travailler`
--
ALTER TABLE `travailler`
  ADD CONSTRAINT `travailler_depot_foreign` FOREIGN KEY (`depot`) REFERENCES `depots` (`id`),
  ADD CONSTRAINT `travailler_personnel_foreign` FOREIGN KEY (`personnel`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
