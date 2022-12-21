-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 27 nov. 2022 à 20:10
-- Version du serveur :  5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_stock`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nombre',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock_alert` decimal(12,2) UNSIGNED DEFAULT NULL COMMENT 'Quantité en stock restant pour alerter l''utilisateur pour un appro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `reference`, `designation`, `unite`, `description`, `created_at`, `updated_at`, `stock_alert`) VALUES
(1, 'ART-0001', 'Ordinateur', 'Nombre', 'Ordinateur portable de marque ACER', '2022-09-19 09:55:26', '2022-09-19 09:55:26', NULL),
(2, 'ART-0002', 'Souris', 'Nombre', 'Souris de marque DELL', '2022-09-19 09:55:26', '2022-09-19 09:55:26', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `article_categories`
--

CREATE TABLE `article_categories` (
  `article` bigint(20) UNSIGNED NOT NULL,
  `categorie` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article_categories`
--

INSERT INTO `article_categories` (`article`, `categorie`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `bons`
--

CREATE TABLE `bons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Permet de savoir si c''est un bon de reception ou un bon de livraison. 1: Bon de reception, 2: Bon de livraison',
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `commande` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Status de bon',
  `adresse_livraison` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Adresse de livraison des marchandises',
  `livreur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nom du livreur de la marchandise',
  `contact_livreur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Contact du livreur',
  `mode_livraison` smallint(5) UNSIGNED DEFAULT '1' COMMENT 'Mode de livraison du bon. 1: Fournisseur qui livre, 2: Client qui le recupère chez le fournisseur',
  `a_la_charge_de` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Qui se charge de payer le cout de livraison s''il y en a. 0: Aucun, 1: Fournisseur, 2: Client',
  `cout` decimal(10,2) DEFAULT NULL COMMENT 'Coût de livraison de l''article s''il y en a',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bons`
--

INSERT INTO `bons` (`id`, `type`, `numero`, `date`, `commande`, `status`, `adresse_livraison`, `livreur`, `contact_livreur`, `mode_livraison`, `a_la_charge_de`, `cout`, `created_at`, `updated_at`) VALUES
(1, 1, 'BR-2022-09-0001', '2022-09-19', 1, 1, 'Mangarano', NULL, NULL, 1, NULL, NULL, '2022-09-19 09:56:49', '2022-09-19 09:56:49'),
(2, 2, 'BL-2022-09-0001', '2022-09-19', 2, 1, NULL, NULL, NULL, 1, NULL, NULL, '2022-09-20 03:32:54', '2022-09-20 03:32:54'),
(3, 1, 'BR-2022-09-0002', '2022-09-21', 8, 1, 'Bazar be', NULL, NULL, 1, NULL, NULL, '2022-09-21 10:51:28', '2022-09-21 10:51:28'),
(4, 2, 'BL-2022-09-0002', '2022-09-21', 10, 1, 'Mangarano', NULL, NULL, 1, NULL, NULL, '2022-09-21 10:53:48', '2022-09-21 10:53:48'),
(5, 1, 'BR-2022-09-0003', '2022-09-21', 11, 1, 'Mangarano', 'RAKOTO Beloha', NULL, 1, 1, '1000.00', '2022-09-22 08:55:26', '2022-09-22 08:55:26'),
(6, 2, 'BL-2022-09-0003', '2022-09-21', 6, 1, 'Mangarano', NULL, NULL, 1, 1, '10000.00', '2022-09-23 03:53:30', '2022-09-23 03:53:30'),
(7, 2, 'BL-2022-09-0004', '2022-09-21', 12, 1, 'Bazar kely', NULL, NULL, 1, 2, '0.00', '2022-09-23 04:10:07', '2022-09-23 04:10:07'),
(8, 2, 'BL-2022-09-0005', '2022-09-21', 13, 1, 'Bazar kely', NULL, NULL, 1, 1, NULL, '2022-09-23 04:16:46', '2022-09-23 04:16:46'),
(9, 1, 'BR-2022-11-0001', '2022-11-29', 16, 1, 'Analakininina', NULL, NULL, 1, 0, '0.00', '2022-11-24 10:44:26', '2022-11-24 10:44:26'),
(10, 1, 'BR-2022-11-0002', '2022-09-21', 15, 1, 'Mangarano', NULL, NULL, 1, 0, '0.00', '2022-11-24 10:44:53', '2022-11-24 10:44:53');

-- --------------------------------------------------------

--
-- Structure de la table `bon_articles`
--

CREATE TABLE `bon_articles` (
  `article` bigint(20) UNSIGNED NOT NULL,
  `bon` bigint(20) UNSIGNED NOT NULL,
  `quantite` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bon_articles`
--

INSERT INTO `bon_articles` (`article`, `bon`, `quantite`) VALUES
(1, 9, 4),
(2, 1, 10),
(2, 2, 1),
(2, 3, 1),
(2, 4, 1),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1),
(2, 8, 1),
(2, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT 'Type de la catégorie: 1-Client, 2-Article, 3-Frs',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `libelle`, `description`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Matériel informatique', 'Tous ce qui est matériel informatique', 3, '2022-09-19 09:55:26', '2022-09-19 09:55:26'),
(2, 'Divers', 'Tous les autres artiles', 3, '2022-09-19 09:55:26', '2022-09-19 09:55:26');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom de la personne ou nom d''une entreprise',
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `adresse`, `email`, `contact`, `nif`, `cif`, `stat`, `created_at`, `updated_at`) VALUES
(1, 'JOHN Doe', 'Bazar be', NULL, '034 12 567 12', NULL, NULL, NULL, '2022-09-19 09:57:51', '2022-09-19 09:57:51');

-- --------------------------------------------------------

--
-- Structure de la table `client_categories`
--

CREATE TABLE `client_categories` (
  `client` bigint(20) UNSIGNED NOT NULL,
  `categorie` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(5) UNSIGNED NOT NULL COMMENT 'Type de commande: 1 - Dévis, 2 - Commande proprement dit',
  `date` date NOT NULL,
  `validite` int(11) DEFAULT NULL COMMENT 'Validité du dévis en nombre de jour',
  `fournisseur` bigint(20) UNSIGNED DEFAULT NULL,
  `client` bigint(20) UNSIGNED DEFAULT NULL,
  `devis` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Devis dans laquelle provient ce commande. N''est utile que pour les commandes',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Status du dévis: 1 - Valide',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `adresse_livraison` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Adresse de livraison des marchandises dans lecas d''une commande',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depot` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Le depot qui a fait la commande ou devis. Uniquement renseigné dans le cas d''un dévis ou commande client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `numero`, `type`, `date`, `validite`, `fournisseur`, `client`, `devis`, `status`, `created_at`, `updated_at`, `adresse_livraison`, `file_path`, `depot`) VALUES
(1, 'BCF-2022-09-0001', 2, '2022-09-19', NULL, 1, NULL, NULL, 3, '2022-09-19 09:55:29', '2022-09-20 03:32:28', 'Mangarano', NULL, NULL),
(2, 'BCC-2022-09-0001', 2, '2022-09-19', NULL, NULL, 1, NULL, 3, '2022-09-19 10:01:54', '2022-09-20 03:33:13', NULL, NULL, 1),
(3, 'DC-2022-09-0001', 1, '2022-09-21', 7, NULL, 1, NULL, 2, '2022-09-21 04:15:39', '2022-09-28 02:54:57', NULL, NULL, 1),
(4, 'BCC-2022-09-0002', 2, '2022-09-21', NULL, NULL, 1, 3, 3, '2022-09-21 04:49:28', '2022-09-21 04:50:23', 'Mangarano', NULL, 1),
(5, 'BCC-2022-09-0003', 2, '2022-09-21', NULL, NULL, 1, 3, 3, '2022-09-21 04:49:55', '2022-09-21 04:50:23', NULL, NULL, 1),
(6, 'BCC-2022-09-0004', 2, '2022-09-21', NULL, NULL, 1, 3, 3, '2022-09-21 05:00:25', '2022-09-23 03:57:35', 'Mangarano', NULL, 1),
(7, 'DF-2022-09-0001', 1, '2022-09-21', 7, 1, NULL, NULL, 2, '2022-09-21 10:49:46', '2022-09-28 02:54:55', NULL, NULL, NULL),
(8, 'BCF-2022-09-0002', 2, '2022-09-21', NULL, 1, NULL, 7, 3, '2022-09-21 10:50:43', '2022-09-21 10:54:57', 'Bazar be', NULL, NULL),
(9, 'DC-2022-09-0002', 1, '2022-09-21', 7, NULL, 1, NULL, 2, '2022-09-21 10:53:02', '2022-09-28 02:54:57', NULL, NULL, 1),
(10, 'BCC-2022-09-0005', 2, '2022-09-21', NULL, NULL, 1, 9, 3, '2022-09-21 10:53:30', '2022-09-22 03:03:59', 'Mangarano', NULL, 1),
(11, 'BCF-2022-09-0003', 2, '2022-09-21', NULL, 1, NULL, 7, 3, '2022-09-22 03:50:27', '2022-09-22 08:55:41', 'Mangarano', NULL, NULL),
(12, 'BCC-2022-09-0006', 2, '2022-09-21', NULL, NULL, 1, 9, 3, '2022-09-23 03:40:05', '2022-09-23 04:10:58', 'Bazar kely', NULL, 1),
(13, 'BCC-2022-09-0007', 2, '2022-09-21', NULL, NULL, 1, 9, 3, '2022-09-23 04:12:43', '2022-09-23 04:17:41', 'Bazar kely', NULL, 1),
(14, 'BCC-2022-09-0008', 2, '2022-09-21', NULL, NULL, 1, 9, 1, '2022-09-23 04:17:30', '2022-09-23 04:17:30', NULL, NULL, 1),
(15, 'BCF-2022-09-0004', 2, '2022-09-21', NULL, 1, NULL, 7, 3, '2022-09-23 04:26:53', '2022-11-25 03:20:36', 'Mangarano', NULL, NULL),
(16, 'BCF-2022-11-0001', 2, '2022-11-29', NULL, 3, NULL, NULL, 3, '2022-11-24 10:09:03', '2022-11-24 10:44:39', 'Analakininina', NULL, NULL),
(17, 'DF-2022-11-0001', 1, '2022-11-29', 7, 3, NULL, NULL, 1, '2022-11-24 10:13:20', '2022-11-24 10:13:20', NULL, NULL, NULL),
(18, 'BCF-2022-11-0002', 2, '2022-12-01', NULL, 2, NULL, NULL, 1, '2022-11-25 03:21:01', '2022-11-25 03:21:01', 'testt', NULL, NULL),
(19, 'BCF-2022-11-0003', 2, '2022-11-29', NULL, 3, NULL, 17, 1, '2022-11-25 06:18:28', '2022-11-25 06:18:28', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commande_articles`
--

CREATE TABLE `commande_articles` (
  `article` bigint(20) UNSIGNED NOT NULL,
  `commande` bigint(20) UNSIGNED NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `pu` decimal(12,2) NOT NULL,
  `tva` decimal(8,2) NOT NULL DEFAULT '20.00',
  `quantite_recu` decimal(10,2) NOT NULL DEFAULT '0.00',
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande_articles`
--

INSERT INTO `commande_articles` (`article`, `commande`, `quantite`, `pu`, `tva`, `quantite_recu`, `reference_id`) VALUES
(1, 16, '4.00', '1000000.00', '20.00', '4.00', NULL),
(1, 17, '10.00', '600000.00', '20.00', '0.00', NULL),
(1, 18, '4.00', '30000.00', '20.00', '0.00', NULL),
(1, 19, '10.00', '600000.00', '20.00', '0.00', NULL),
(2, 1, '10.00', '20000.00', '20.00', '10.00', NULL),
(2, 2, '1.00', '21000.00', '20.00', '1.00', 2),
(2, 3, '1.00', '21000.00', '0.00', '0.00', 2),
(2, 6, '1.00', '21000.00', '0.00', '1.00', 2),
(2, 7, '1.00', '10000.00', '20.00', '0.00', NULL),
(2, 8, '1.00', '10000.00', '20.00', '1.00', NULL),
(2, 9, '1.00', '21000.00', '20.00', '0.00', 2),
(2, 10, '1.00', '21000.00', '20.00', '1.00', 2),
(2, 11, '1.00', '10000.00', '20.00', '1.00', NULL),
(2, 12, '1.00', '21000.00', '0.00', '1.00', 2),
(2, 13, '1.00', '20000.00', '0.00', '1.00', 1),
(2, 14, '1.00', '20000.00', '0.00', '0.00', 1),
(2, 15, '1.00', '10000.00', '20.00', '1.00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `depots`
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
-- Déchargement des données de la table `depots`
--

INSERT INTO `depots` (`id`, `nom`, `contact`, `localisation`, `point_vente`, `created_at`, `updated_at`) VALUES
(1, 'Premier point de vente', '032 12 345 67', 'Mangarano', 1, '2022-09-19 09:56:31', '2022-09-19 09:56:31'),
(2, 'Depot analakininana', NULL, 'analakininina', 0, '2022-11-24 10:05:40', '2022-11-24 10:05:40');

-- --------------------------------------------------------

--
-- Structure de la table `depot_articles`
--

CREATE TABLE `depot_articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de l''artile a stocker',
  `quantite` decimal(10,2) UNSIGNED NOT NULL COMMENT 'Quantité de l''article dans la bon de reception',
  `responsable` bigint(20) UNSIGNED NOT NULL COMMENT 'Id du responsable qui a fait entrer le stock',
  `bon` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Bon de livraison ou bon de reception qui contient l''article',
  `transfert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `depot_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Identifiant du point de vente ou entrepot pour stocker l''article',
  `provenance_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Identifiant du point de vente ou entrepot où provient l''article. Uniquement utilisé dans le cadre d''un transfert. null si l''article provient d''un fournisseur',
  `destination_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Identifiant du point de vente ou entrepot où on doit deplacer l''article. Uniquement utilisé dans le cadre d''un transfert.',
  `date_transaction` date NOT NULL,
  `type` smallint(5) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Type de transaction. Entrée en stock ou sortie de stock. 1: Entree, 0: Sortie',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `depot_articles`
--

INSERT INTO `depot_articles` (`id`, `article_id`, `quantite`, `responsable`, `bon`, `transfert_id`, `depot_id`, `provenance_id`, `destination_id`, `date_transaction`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, '10.00', 1, 1, NULL, 1, NULL, NULL, '2022-09-19', 1, '2022-09-19 09:56:49', '2022-09-19 09:56:49'),
(2, 2, '0.00', 1, NULL, NULL, 1, NULL, NULL, '2022-09-19', 1, '2022-09-19 09:57:08', '2022-09-19 09:57:08'),
(3, 2, '1.00', 1, 2, NULL, 1, NULL, NULL, '2022-09-20', 0, '2022-09-20 03:32:54', '2022-09-20 03:32:54'),
(4, 2, '1.00', 1, 3, NULL, 1, NULL, NULL, '2022-09-21', 1, '2022-09-21 10:51:28', '2022-09-21 10:51:28'),
(5, 2, '1.00', 1, 4, NULL, 1, NULL, NULL, '2022-09-21', 0, '2022-09-21 10:53:48', '2022-09-21 10:53:48'),
(6, 2, '1.00', 1, 5, NULL, 1, NULL, NULL, '2022-09-22', 1, '2022-09-22 08:55:26', '2022-09-22 08:55:26'),
(7, 2, '1.00', 1, 6, NULL, 1, NULL, NULL, '2022-09-23', 0, '2022-09-23 03:53:30', '2022-09-23 03:53:30'),
(8, 2, '1.00', 1, 7, NULL, 1, NULL, NULL, '2022-09-23', 0, '2022-09-23 04:10:07', '2022-09-23 04:10:07'),
(9, 2, '1.00', 1, 8, NULL, 1, NULL, NULL, '2022-09-23', 0, '2022-09-23 04:16:47', '2022-09-23 04:16:47'),
(10, 1, '4.00', 1, 9, NULL, 2, NULL, NULL, '2022-11-24', 1, '2022-11-24 10:44:26', '2022-11-24 10:44:26'),
(11, 2, '1.00', 1, 10, NULL, 1, NULL, NULL, '2022-11-24', 1, '2022-11-24 10:44:53', '2022-11-24 10:44:53');

-- --------------------------------------------------------

--
-- Structure de la table `depot_prix_articles`
--

CREATE TABLE `depot_prix_articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article` bigint(20) UNSIGNED NOT NULL,
  `depot` bigint(20) UNSIGNED NOT NULL,
  `quantite` decimal(10,2) UNSIGNED DEFAULT NULL COMMENT 'Null si tous les autres articles sont concerné par le prix',
  `pu` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `depot_prix_articles`
--

INSERT INTO `depot_prix_articles` (`id`, `article`, `depot`, `quantite`, `pu`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, '20000.00', '2022-09-19 09:57:08', '2022-09-19 09:57:08'),
(2, 2, 1, '1.00', '21000.00', '2022-09-19 09:57:08', '2022-09-23 03:40:05');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero_facture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_facturation` date NOT NULL,
  `date_vente` date NOT NULL,
  `echeance` int(10) UNSIGNED NOT NULL DEFAULT '30' COMMENT 'Nombre d''écheance en jours.',
  `taux_penalite` decimal(10,2) NOT NULL,
  `commande` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Numéro de bon de commande qui a généré la facture',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id`, `numero_facture`, `date_facturation`, `date_vente`, `echeance`, `taux_penalite`, `commande`, `created_at`, `updated_at`) VALUES
(1, 'FAC-2022-09-0001', '2022-09-30', '2022-09-19', 30, '1000.00', 2, '2022-09-30 09:12:42', '2022-09-30 09:12:42');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
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
-- Structure de la table `fonctions`
--

CREATE TABLE `fonctions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_fonction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_fonction` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fonctions`
--

INSERT INTO `fonctions` (`id`, `nom_fonction`, `description_fonction`, `created_at`, `updated_at`) VALUES
(1, 'Magasinier', 'Responsable du magasin', '2022-09-19 09:55:26', '2022-09-19 09:55:26'),
(2, 'Vendeur', 'Responsable de vente', '2022-09-19 09:55:26', '2022-09-19 09:55:26'),
(3, 'Directeur', 'Responsable de tout', '2022-09-19 09:55:26', '2022-09-19 09:55:26');

-- --------------------------------------------------------

--
-- Structure de la table `fonction_inclusions`
--

CREATE TABLE `fonction_inclusions` (
  `fonction_parent` bigint(20) UNSIGNED NOT NULL,
  `fonction_enfant` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonction_roles`
--

CREATE TABLE `fonction_roles` (
  `fonction` bigint(20) UNSIGNED NOT NULL,
  `role` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fonction_roles`
--

INSERT INTO `fonction_roles` (`fonction`, `role`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(2, 2),
(3, 2),
(1, 3),
(2, 3),
(3, 3),
(1, 4),
(2, 4),
(3, 4),
(1, 5),
(2, 5),
(3, 5),
(1, 6),
(2, 6),
(3, 6),
(1, 7),
(2, 7),
(3, 7),
(1, 8),
(2, 8),
(3, 8),
(1, 9),
(2, 9),
(3, 9),
(1, 10),
(2, 10),
(3, 10),
(1, 11),
(2, 11),
(3, 11),
(1, 12),
(2, 12),
(3, 12),
(1, 13),
(2, 13),
(3, 13),
(1, 14),
(2, 14),
(3, 14);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom de la personne ou nom d''une entreprise',
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `adresse`, `email`, `contact`, `nif`, `cif`, `stat`, `created_at`, `updated_at`) VALUES
(1, 'RAKOTO Beloha', 'Mangarano', 'rakoto@gmail.com', '032 54 123 43', NULL, NULL, NULL, '2022-09-19 09:55:26', '2022-09-19 09:55:26'),
(2, 'JEAN Paul', 'Bazar be', 'paul@gmail.com', '032 54 123 44', NULL, NULL, NULL, '2022-09-19 09:55:26', '2022-09-19 09:55:26'),
(3, 'computek', 'Bazary be', NULL, '0325033378', NULL, NULL, NULL, '2022-11-24 10:07:11', '2022-11-24 10:07:11');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur_categories`
--

CREATE TABLE `fournisseur_categories` (
  `fournisseur` bigint(20) UNSIGNED NOT NULL,
  `categorie` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2022_08_15_082702_create_bons_table', 1),
(3, '2022_08_16_073933_create_article_categories_table', 1),
(4, '2022_08_16_073933_create_articles_table', 1),
(5, '2022_08_16_073933_create_bon_articles_table', 1),
(6, '2022_08_16_073933_create_categories_table', 1),
(7, '2022_08_16_073933_create_client_categories_table', 1),
(8, '2022_08_16_073933_create_clients_table', 1),
(9, '2022_08_16_073933_create_commande_articles_table', 1),
(10, '2022_08_16_073933_create_commandes_table', 1),
(11, '2022_08_16_073933_create_depots_table', 1),
(12, '2022_08_16_073933_create_failed_jobs_table', 1),
(13, '2022_08_16_073933_create_fonction_inclusions_table', 1),
(14, '2022_08_16_073933_create_fonction_roles_table', 1),
(15, '2022_08_16_073933_create_fonctions_table', 1),
(16, '2022_08_16_073933_create_fournisseur_categories_table', 1),
(17, '2022_08_16_073933_create_fournisseurs_table', 1),
(18, '2022_08_16_073933_create_parametres_table', 1),
(19, '2022_08_16_073933_create_password_resets_table', 1),
(20, '2022_08_16_073933_create_personnel_fonctions_table', 1),
(21, '2022_08_16_073933_create_roles_table', 1),
(22, '2022_08_16_073933_create_sous_categories_table', 1),
(23, '2022_08_16_073933_create_travailler_table', 1),
(24, '2022_08_16_073933_create_user_roles_table', 1),
(25, '2022_08_16_073933_create_users_table', 1),
(26, '2022_08_16_073934_add_foreign_keys_to_bon_articles_table', 1),
(27, '2022_08_16_073934_add_foreign_keys_to_bons_table', 1),
(28, '2022_08_16_073934_add_foreign_keys_to_client_categories_table', 1),
(29, '2022_08_16_073934_add_foreign_keys_to_commande_articles_table', 1),
(30, '2022_08_16_073934_add_foreign_keys_to_commandes_table', 1),
(31, '2022_08_16_073934_add_foreign_keys_to_fonction_inclusions_table', 1),
(32, '2022_08_16_073934_add_foreign_keys_to_fonction_roles_table', 1),
(33, '2022_08_16_073934_add_foreign_keys_to_fournisseur_categories_table', 1),
(34, '2022_08_16_073934_add_foreign_keys_to_personnel_fonctions_table', 1),
(35, '2022_08_16_073934_add_foreign_keys_to_sous_categories_table', 1),
(36, '2022_08_16_073934_add_foreign_keys_to_travailler_table', 1),
(37, '2022_08_16_073934_add_foreign_keys_to_user_roles_table', 1),
(38, '2022_08_16_074235_create_depot_articles_table', 1),
(39, '2022_08_23_073031_create_depot_prix_articles_table', 1),
(40, '2022_09_14_055129_add_depot_columns_to_commandes_table', 1),
(41, '2022_09_19_124854_add_column_to_commande_articles_table', 1),
(43, '2022_09_22_080709_add_livraison_details_to_bons_table', 2),
(50, '2022_09_26_064131_create_factures_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `id` int(11) NOT NULL,
  `generale` json DEFAULT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parametres`
--

INSERT INTO `parametres` (`id`, `generale`, `devise`) VALUES
(1, '{\"nif\": null, \"nom\": \"IZZYFOAM\", \"stat\": null, \"email\": \"izzyfoam@gmail.com\", \"contact\": \"034 12 345 67\", \"assujeti\": false}', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
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
-- Déchargement des données de la table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(8, 'App\\Models\\User', 1, 'API Token', 'dcf7a520c68ce859318593f246ee8bda6c75e3d365fec3f20b6371986abc29ab', '[\"*\"]', NULL, '2022-09-30 08:14:46', '2022-09-30 08:14:46'),
(9, 'App\\Models\\User', 1, 'API Token', '1263de02028d4ba163b4708c7696e3f0eaeaddb20832467e93d2885a302e2c6e', '[\"*\"]', NULL, '2022-11-24 10:15:54', '2022-11-24 10:15:54'),
(10, 'App\\Models\\User', 1, 'API Token', 'db0900d19d97948e2d0d57ac8834282972d1bd2b72c55c73c55ca702a52026c9', '[\"*\"]', NULL, '2022-11-25 02:31:14', '2022-11-25 02:31:14'),
(11, 'App\\Models\\User', 1, 'API Token', '243de7c1c10dbcc41d6b2efde98ca795beba52226fb00943fd35e7940d402e8b', '[\"*\"]', NULL, '2022-11-25 04:14:38', '2022-11-25 04:14:38'),
(12, 'App\\Models\\User', 1, 'API Token', '179cbbd9e8cd2230413fdb3110bbf0f816095c5b48978d159513bff6a3a6e0e6', '[\"*\"]', NULL, '2022-11-25 04:24:45', '2022-11-25 04:24:45'),
(13, 'App\\Models\\User', 1, 'API Token', 'b36d4d9f8eed985e0d57cce342c35ebb2f28fc1d742c0ee48d5fd246eb991f1b', '[\"*\"]', NULL, '2022-11-25 04:37:47', '2022-11-25 04:37:47');

-- --------------------------------------------------------

--
-- Structure de la table `personnel_fonctions`
--

CREATE TABLE `personnel_fonctions` (
  `personnel` bigint(20) UNSIGNED NOT NULL,
  `fonction` bigint(20) UNSIGNED NOT NULL,
  `date_association` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnel_fonctions`
--

INSERT INTO `personnel_fonctions` (`personnel`, `fonction`, `date_association`) VALUES
(1, 3, '2022-09-19 12:55:26');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `nom_role`, `created_at`, `updated_at`, `description`) VALUES
(1, 'add_point_vente', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Ajouter un nouveau point de vente'),
(2, 'view_point_vente', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Voir la liste de point de vente'),
(3, 'manage_roles_and_functions', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Gerer les personnels et les roles'),
(4, 'add_user', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Ajouter un nouveau personnel'),
(5, 'delete_user', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Supprimer un personnel'),
(6, 'view_user', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Voir la liste des utilisateur'),
(7, 'edit_user', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Modifier un personnel'),
(8, 'edit_point_vente', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Modifier un point de vente'),
(9, 'delete_point_vente', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Supprimer un point de vente'),
(10, 'add_entrepot', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Ajouter une nouvelle entrepôt'),
(11, 'view_entrepot', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Voir la liste des entrepôt'),
(12, 'edit_entrepot', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Modifier un entrepôt'),
(13, 'delete_entrepot', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Supprimer un entrepôt'),
(14, 'manage_settings', '2022-09-19 09:55:26', '2022-09-19 09:55:26', 'Gerer les parametres de l\'entreprise');

-- --------------------------------------------------------

--
-- Structure de la table `sous_categories`
--

CREATE TABLE `sous_categories` (
  `categorie_parent` bigint(20) UNSIGNED NOT NULL,
  `categorie_enfant` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transferts`
--

CREATE TABLE `transferts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `travailler`
--

CREATE TABLE `travailler` (
  `personnel` bigint(20) UNSIGNED NOT NULL,
  `depot` bigint(20) UNSIGNED NOT NULL,
  `est_responsable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Permet de determiner si le personnel est responsable de ce depot',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom_personnel`, `prenoms_personnel`, `contact_personnel`, `adresse_personnel`, `cin_personnel`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Golden', 'Kemmer', '559.729.6972', '28286 Mayer Overpass\nGinaburgh, AZ 31240-5197', '861170992341', 'user', 'bertrand50@example.com', '2022-09-19 09:55:26', 'eyJpdiI6ImRzTU9lRzZLU3ROYjB4Q3ZXbW9WdEE9PSIsInZhbHVlIjoibEJVN1NCbWpkSDdDK2lQdVZIVnE5Zz09IiwibWFjIjoiNzMwYTdlMDg5OTNhMjQ2NDVkOWVhYjIwOWYyYzVmN2ExZDBiOTBkOTYwMzYxMDdmODVkNjdlNDBkNjk3YTY1MCIsInRhZyI6IiJ9', 'hSRJH82RBg', '2022-09-19 09:55:26', '2022-09-19 09:55:26');

-- --------------------------------------------------------

--
-- Structure de la table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Index pour la table `article_categories`
--
ALTER TABLE `article_categories`
  ADD PRIMARY KEY (`categorie`,`article`),
  ADD KEY `fk_article_categories` (`article`);

--
-- Index pour la table `bons`
--
ALTER TABLE `bons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_bon` (`numero`),
  ADD KEY `fk_commande` (`commande`);

--
-- Index pour la table `bon_articles`
--
ALTER TABLE `bon_articles`
  ADD PRIMARY KEY (`article`,`bon`),
  ADD KEY `i_fk_article` (`article`),
  ADD KEY `i_fk_bon` (`bon`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_client` (`nom`);

--
-- Index pour la table `client_categories`
--
ALTER TABLE `client_categories`
  ADD PRIMARY KEY (`categorie`,`client`),
  ADD KEY `client_categories_client_foreign` (`client`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_commande` (`numero`),
  ADD KEY `commandes_fournisseur_foreign` (`fournisseur`),
  ADD KEY `commandes_client_foreign` (`client`),
  ADD KEY `fk_devis` (`devis`),
  ADD KEY `commandes_depot_foreign` (`depot`);

--
-- Index pour la table `commande_articles`
--
ALTER TABLE `commande_articles`
  ADD PRIMARY KEY (`article`,`commande`),
  ADD KEY `commande_articles_commande_foreign` (`commande`),
  ADD KEY `commande_articles_reference_id_foreign` (`reference_id`);

--
-- Index pour la table `depots`
--
ALTER TABLE `depots`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depot_articles`
--
ALTER TABLE `depot_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depot_articles_article_id_foreign` (`article_id`),
  ADD KEY `depot_articles_responsable_foreign` (`responsable`),
  ADD KEY `depot_articles_bon_foreign` (`bon`),
  ADD KEY `depot_articles_depot_id_foreign` (`depot_id`),
  ADD KEY `depot_articles_provenance_id_foreign` (`provenance_id`),
  ADD KEY `depot_articles_destination_id_foreign` (`destination_id`);

--
-- Index pour la table `depot_prix_articles`
--
ALTER TABLE `depot_prix_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depot_prix_articles_article_foreign` (`article`),
  ADD KEY `depot_prix_articles_depot_foreign` (`depot`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_facture` (`numero_facture`),
  ADD KEY `factures_commande_foreign` (`commande`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fonctions`
--
ALTER TABLE `fonctions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fonctions_nom_fonction_unique` (`nom_fonction`);

--
-- Index pour la table `fonction_inclusions`
--
ALTER TABLE `fonction_inclusions`
  ADD PRIMARY KEY (`fonction_parent`,`fonction_enfant`),
  ADD KEY `fonction_inclusions_fonction_enfant_foreign` (`fonction_enfant`);

--
-- Index pour la table `fonction_roles`
--
ALTER TABLE `fonction_roles`
  ADD PRIMARY KEY (`fonction`,`role`),
  ADD KEY `fk_role_fonction` (`role`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_fournisseur` (`nom`);

--
-- Index pour la table `fournisseur_categories`
--
ALTER TABLE `fournisseur_categories`
  ADD PRIMARY KEY (`categorie`,`fournisseur`),
  ADD KEY `fournisseur_categories_fournisseur_foreign` (`fournisseur`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `personnel_fonctions`
--
ALTER TABLE `personnel_fonctions`
  ADD PRIMARY KEY (`personnel`,`fonction`),
  ADD KEY `fk_fonction` (`fonction`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nom_role` (`nom_role`);

--
-- Index pour la table `sous_categories`
--
ALTER TABLE `sous_categories`
  ADD PRIMARY KEY (`categorie_parent`,`categorie_enfant`),
  ADD KEY `fk_categorie_enfant` (`categorie_enfant`);

--
-- Index pour la table `transferts`
--
ALTER TABLE `transferts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_transfert` (`numero`);

--
-- Index pour la table `travailler`
--
ALTER TABLE `travailler`
  ADD PRIMARY KEY (`personnel`,`depot`),
  ADD KEY `travailler_depot_foreign` (`depot`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_cin_personnel_unique` (`cin_personnel`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_role` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `bons`
--
ALTER TABLE `bons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `depots`
--
ALTER TABLE `depots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `depot_articles`
--
ALTER TABLE `depot_articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `depot_prix_articles`
--
ALTER TABLE `depot_prix_articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fonctions`
--
ALTER TABLE `fonctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `transferts`
--
ALTER TABLE `transferts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bons`
--
ALTER TABLE `bons`
  ADD CONSTRAINT `bons_commande_foreign` FOREIGN KEY (`commande`) REFERENCES `commandes` (`id`);

--
-- Contraintes pour la table `bon_articles`
--
ALTER TABLE `bon_articles`
  ADD CONSTRAINT `bon_articles_article_foreign` FOREIGN KEY (`article`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `bon_articles_bon_foreign` FOREIGN KEY (`bon`) REFERENCES `bons` (`id`);

--
-- Contraintes pour la table `client_categories`
--
ALTER TABLE `client_categories`
  ADD CONSTRAINT `client_categories_categorie_foreign` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `client_categories_client_foreign` FOREIGN KEY (`client`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_client_foreign` FOREIGN KEY (`client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `commandes_depot_foreign` FOREIGN KEY (`depot`) REFERENCES `depots` (`id`),
  ADD CONSTRAINT `commandes_fournisseur_foreign` FOREIGN KEY (`fournisseur`) REFERENCES `fournisseurs` (`id`),
  ADD CONSTRAINT `fk_devis` FOREIGN KEY (`devis`) REFERENCES `commandes` (`id`);

--
-- Contraintes pour la table `commande_articles`
--
ALTER TABLE `commande_articles`
  ADD CONSTRAINT `commande_articles_article_foreign` FOREIGN KEY (`article`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `commande_articles_commande_foreign` FOREIGN KEY (`commande`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `commande_articles_reference_id_foreign` FOREIGN KEY (`reference_id`) REFERENCES `depot_prix_articles` (`id`);

--
-- Contraintes pour la table `depot_articles`
--
ALTER TABLE `depot_articles`
  ADD CONSTRAINT `depot_articles_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `depot_articles_bon_foreign` FOREIGN KEY (`bon`) REFERENCES `bons` (`id`),
  ADD CONSTRAINT `depot_articles_depot_id_foreign` FOREIGN KEY (`depot_id`) REFERENCES `depots` (`id`),
  ADD CONSTRAINT `depot_articles_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `depots` (`id`),
  ADD CONSTRAINT `depot_articles_provenance_id_foreign` FOREIGN KEY (`provenance_id`) REFERENCES `depots` (`id`),
  ADD CONSTRAINT `depot_articles_responsable_foreign` FOREIGN KEY (`responsable`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `depot_prix_articles`
--
ALTER TABLE `depot_prix_articles`
  ADD CONSTRAINT `depot_prix_articles_article_foreign` FOREIGN KEY (`article`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `depot_prix_articles_depot_foreign` FOREIGN KEY (`depot`) REFERENCES `depots` (`id`);

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_commande_foreign` FOREIGN KEY (`commande`) REFERENCES `commandes` (`id`);

--
-- Contraintes pour la table `fonction_inclusions`
--
ALTER TABLE `fonction_inclusions`
  ADD CONSTRAINT `fonction_inclusions_fonction_enfant_foreign` FOREIGN KEY (`fonction_enfant`) REFERENCES `fonctions` (`id`),
  ADD CONSTRAINT `fonction_inclusions_fonction_parent_foreign` FOREIGN KEY (`fonction_parent`) REFERENCES `fonctions` (`id`);

--
-- Contraintes pour la table `fonction_roles`
--
ALTER TABLE `fonction_roles`
  ADD CONSTRAINT `fk_fonction_role` FOREIGN KEY (`fonction`) REFERENCES `fonctions` (`id`),
  ADD CONSTRAINT `fk_role_fonction` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

--
-- Contraintes pour la table `fournisseur_categories`
--
ALTER TABLE `fournisseur_categories`
  ADD CONSTRAINT `fournisseur_categories_categorie_foreign` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fournisseur_categories_fournisseur_foreign` FOREIGN KEY (`fournisseur`) REFERENCES `fournisseurs` (`id`);

--
-- Contraintes pour la table `personnel_fonctions`
--
ALTER TABLE `personnel_fonctions`
  ADD CONSTRAINT `fk_fonction` FOREIGN KEY (`fonction`) REFERENCES `fonctions` (`id`),
  ADD CONSTRAINT `fk_personnel` FOREIGN KEY (`personnel`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `sous_categories`
--
ALTER TABLE `sous_categories`
  ADD CONSTRAINT `fk_categorie_enfant` FOREIGN KEY (`categorie_enfant`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_categorie_parent` FOREIGN KEY (`categorie_parent`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `travailler`
--
ALTER TABLE `travailler`
  ADD CONSTRAINT `travailler_depot_foreign` FOREIGN KEY (`depot`) REFERENCES `depots` (`id`),
  ADD CONSTRAINT `travailler_personnel_foreign` FOREIGN KEY (`personnel`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
