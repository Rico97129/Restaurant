-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 08 mars 2023 à 00:07
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `restaurant`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis_clients`
--

DROP TABLE IF EXISTS `avis_clients`;
CREATE TABLE IF NOT EXISTS `avis_clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avis_clients`
--

INSERT INTO `avis_clients` (`id`, `client_id`, `menu_id`, `note`, `commentaire`, `created_at`) VALUES
(1, 1, 1, 4, 'Très bon menu du jour', '2023-02-28 20:18:04'),
(2, 2, 2, 3, 'Bon menu végétarien, mais un peu cher', '2023-02-28 20:18:04'),
(3, 3, 3, 5, 'Très bon menu enfant', '2023-02-28 20:18:04');

-- --------------------------------------------------------

--
-- Structure de la table `boissons`
--

DROP TABLE IF EXISTS `boissons`;
CREATE TABLE IF NOT EXISTS `boissons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `description` text,
  `prix` decimal(4,2) NOT NULL,
  `image` varchar(200) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `boissons`
--

INSERT INTO `boissons` (`id`, `nom`, `description`, `prix`, `image`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'Coca-Cola', 'Soda rafraîchissant', '2.50', 'https://example.com/coca-cola.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04'),
(2, 'Jus d\'orange', 'Jus d\'orange frais pressé', '3.00', 'https://example.com/jus-orange.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04'),
(3, 'Thé vert', 'Thé vert japonais', '2.00', 'https://example.com/the-vert.jpg', 0, '2023-02-28 20:18:04', '2023-02-28 20:18:04');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `telephone` varchar(20) NOT NULL,
  `numVoie`int not NULL,
  `libelleVoie` varchar(100) not null,
  `codePostal` int not null,
  `ville` varchar(100),
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `motDePasse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `telephone`, `adresse`, `created_at`, `estAdmin`, `motDePasse`) VALUES
(1, 'Durand', 'Jean', 'jean.durand@example.com', '06 12 34 56 78', '1 rue de la Paix', '2023-02-28 20:17:14', 0, ''),
(2, 'Martin', 'Sophie', 'sophie.martin@example.com', '06 98 76 54 32', '14 avenue des Champs-Élysées', '2023-02-28 20:17:14', 0, ''),
(3, 'Dupont', 'Pierre', 'pierre.dupont@example.com', '06 12 34 56 78', '23 rue du Faubourg Saint-Honoré', '2023-02-28 20:17:14', 0, '');
-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_commande` datetime NOT NULL,
  `client_id` int NOT NULL,
  `total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `date_commande`, `client_id`, `total`, `created_at`) VALUES
(1, '2023-02-27 19:30:00', 1, '23.50', '2023-02-28 20:18:04'),
(2, '2023-02-28 12:15:00', 2, '29.00', '2023-02-28 20:18:04'),
(3, '2023-02-28 20:00:00', 3, '14.50', '2023-02-28 20:18:04');

-- --------------------------------------------------------

--
-- Structure de la table `commande_boissons`
--

DROP TABLE IF EXISTS `commande_boissons`;
CREATE TABLE IF NOT EXISTS `commande_boissons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `boisson_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `boisson_id` (`boisson_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande_boissons`
--

INSERT INTO `commande_boissons` (`id`, `commande_id`, `boisson_id`, `quantite`, `prix`, `created_at`) VALUES
(1, 1, 1, 2, '5.00', '2023-02-28 20:18:04'),
(2, 1, 2, 1, '3.00', '2023-02-28 20:18:04'),
(3, 2, 3, 2, '4.00', '2023-02-28 20:18:04'),
(4, 3, 1, 1, '2.50', '2023-02-28 20:18:04'),
(5, 3, 2, 1, '3.00', '2023-02-28 20:18:04'),
(6, 3, 3, 1, '2.00', '2023-02-28 20:18:04');

-- --------------------------------------------------------

--
-- Structure de la table `commande_desserts`
--

DROP TABLE IF EXISTS `commande_desserts`;
CREATE TABLE IF NOT EXISTS `commande_desserts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `dessert_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `dessert_id` (`dessert_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_menus`
--

DROP TABLE IF EXISTS `commande_menus`;
CREATE TABLE IF NOT EXISTS `commande_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande_menus`
--

INSERT INTO `commande_menus` (`id`, `commande_id`, `menu_id`, `quantite`, `prix`, `created_at`) VALUES
(1, 1, 1, 1, '18.50', '2023-02-28 20:18:04'),
(2, 2, 2, 2, '32.00', '2023-02-28 20:18:04'),
(3, 3, 3, 1, '9.00', '2023-02-28 20:18:04');

-- --------------------------------------------------------

--
-- Structure de la table `desserts`
--

DROP TABLE IF EXISTS `desserts`;
CREATE TABLE IF NOT EXISTS `desserts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `description` text,
  `prix` decimal(4,2) NOT NULL,
  `image` varchar(200) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `description` text,
  `prix` decimal(6,2) NOT NULL,
  `image` varchar(200) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `nom`, `description`, `prix`, `image`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'Menu du jour', 'Entrée + plat + dessert', '18.50', 'https://example.com/menu-jour.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04'),
(2, 'Menu végétarien', 'Entrée + plat végétarien + dessert', '16.00', 'https://example.com/menu-vegetarien.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04'),
(3, 'Menu enfant', 'Plat enfant + dessert + boisson', '9.00', 'https://example.com/menu-enfant.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
