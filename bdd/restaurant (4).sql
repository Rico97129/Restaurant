-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 16 mars 2023 à 00:09
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

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `generate_calendar`$$
CREATE DEFINER=`admin`@`%` PROCEDURE `generate_calendar` ()   BEGIN
    -- Création de la table calendrier
    CREATE TABLE Calendrier(
        calendrier_date DATE PRIMARY KEY,
        calendrier_jour_semaine VARCHAR(10),
        calendrier_mois VARCHAR(20)
    );

    -- Remplissage de la table calendrier avec toutes les dates de l'année, le jour de la semaine correspondant, et le mois correspondant
    SET @startdate = CONCAT(YEAR(CURDATE()), '-01-01');
    SET @enddate = CONCAT(YEAR(CURDATE()), '-12-31');

    WHILE DATE_FORMAT(@startdate, '%Y-%m-%d') <= DATE_FORMAT(@enddate, '%Y-%m-%d') DO
        INSERT INTO Calendrier (calendrier_date, calendrier_jour_semaine, calendrier_mois) 
        VALUES (@startdate, 
                CASE DATE_FORMAT(@startdate, '%W')
                    WHEN 'Monday' THEN 'Lundi'
                    WHEN 'Tuesday' THEN 'Mardi'
                    WHEN 'Wednesday' THEN 'Mercredi'
                    WHEN 'Thursday' THEN 'Jeudi'
                    WHEN 'Friday' THEN 'Vendredi'
                    WHEN 'Saturday' THEN 'Samedi'
                    WHEN 'Sunday' THEN 'Dimanche'
                END, 
                CASE DATE_FORMAT(@startdate, '%m')
                    WHEN '01' THEN 'Janvier'
                    WHEN '02' THEN 'Février'
                    WHEN '03' THEN 'Mars'
                    WHEN '04' THEN 'Avril'
                    WHEN '05' THEN 'Mai'
                    WHEN '06' THEN 'Juin'
                    WHEN '07' THEN 'Juillet'
                    WHEN '08' THEN 'Août'
                    WHEN '09' THEN 'Septembre'
                    WHEN '10' THEN 'Octobre'
                    WHEN '11' THEN 'Novembre'
                    WHEN '12' THEN 'Décembre'
                END
        );
        SET @startdate = DATE_ADD(@startdate, INTERVAL 1 DAY);
    END WHILE;

    -- Affiche toutes les données de la table calendrier
    SELECT calendrier_date, calendrier_jour_semaine, calendrier_mois FROM Calendrier;
END$$

DELIMITER ;

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
-- Structure de la table `burgers`
--

DROP TABLE IF EXISTS `burgers`;
CREATE TABLE IF NOT EXISTS `burgers` (
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
-- Structure de la table `calendrier`
--

DROP TABLE IF EXISTS `calendrier`;
CREATE TABLE IF NOT EXISTS `calendrier` (
  `calendrier_date` date NOT NULL,
  `calendrier_jour_semaine` varchar(10) DEFAULT NULL,
  `calendrier_mois` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`calendrier_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `calendrier`
--

INSERT INTO `calendrier` (`calendrier_date`, `calendrier_jour_semaine`, `calendrier_mois`) VALUES
('2023-01-01', 'Dimanche', 'Janvier'),
('2023-01-02', 'Lundi', 'Janvier'),
('2023-01-03', 'Mardi', 'Janvier'),
('2023-01-04', 'Mercredi', 'Janvier'),
('2023-01-05', 'Jeudi', 'Janvier'),
('2023-01-06', 'Vendredi', 'Janvier'),
('2023-01-07', 'Samedi', 'Janvier'),
('2023-01-08', 'Dimanche', 'Janvier'),
('2023-01-09', 'Lundi', 'Janvier'),
('2023-01-10', 'Mardi', 'Janvier'),
('2023-01-11', 'Mercredi', 'Janvier'),
('2023-01-12', 'Jeudi', 'Janvier'),
('2023-01-13', 'Vendredi', 'Janvier'),
('2023-01-14', 'Samedi', 'Janvier'),
('2023-01-15', 'Dimanche', 'Janvier'),
('2023-01-16', 'Lundi', 'Janvier'),
('2023-01-17', 'Mardi', 'Janvier'),
('2023-01-18', 'Mercredi', 'Janvier'),
('2023-01-19', 'Jeudi', 'Janvier'),
('2023-01-20', 'Vendredi', 'Janvier'),
('2023-01-21', 'Samedi', 'Janvier'),
('2023-01-22', 'Dimanche', 'Janvier'),
('2023-01-23', 'Lundi', 'Janvier'),
('2023-01-24', 'Mardi', 'Janvier'),
('2023-01-25', 'Mercredi', 'Janvier'),
('2023-01-26', 'Jeudi', 'Janvier'),
('2023-01-27', 'Vendredi', 'Janvier'),
('2023-01-28', 'Samedi', 'Janvier'),
('2023-01-29', 'Dimanche', 'Janvier'),
('2023-01-30', 'Lundi', 'Janvier'),
('2023-01-31', 'Mardi', 'Janvier'),
('2023-02-01', 'Mercredi', 'Février'),
('2023-02-02', 'Jeudi', 'Février'),
('2023-02-03', 'Vendredi', 'Février'),
('2023-02-04', 'Samedi', 'Février'),
('2023-02-05', 'Dimanche', 'Février'),
('2023-02-06', 'Lundi', 'Février'),
('2023-02-07', 'Mardi', 'Février'),
('2023-02-08', 'Mercredi', 'Février'),
('2023-02-09', 'Jeudi', 'Février'),
('2023-02-10', 'Vendredi', 'Février'),
('2023-02-11', 'Samedi', 'Février'),
('2023-02-12', 'Dimanche', 'Février'),
('2023-02-13', 'Lundi', 'Février'),
('2023-02-14', 'Mardi', 'Février'),
('2023-02-15', 'Mercredi', 'Février'),
('2023-02-16', 'Jeudi', 'Février'),
('2023-02-17', 'Vendredi', 'Février'),
('2023-02-18', 'Samedi', 'Février'),
('2023-02-19', 'Dimanche', 'Février'),
('2023-02-20', 'Lundi', 'Février'),
('2023-02-21', 'Mardi', 'Février'),
('2023-02-22', 'Mercredi', 'Février'),
('2023-02-23', 'Jeudi', 'Février'),
('2023-02-24', 'Vendredi', 'Février'),
('2023-02-25', 'Samedi', 'Février'),
('2023-02-26', 'Dimanche', 'Février'),
('2023-02-27', 'Lundi', 'Février'),
('2023-02-28', 'Mardi', 'Février'),
('2023-03-01', 'Mercredi', 'Mars'),
('2023-03-02', 'Jeudi', 'Mars'),
('2023-03-03', 'Vendredi', 'Mars'),
('2023-03-04', 'Samedi', 'Mars'),
('2023-03-05', 'Dimanche', 'Mars'),
('2023-03-06', 'Lundi', 'Mars'),
('2023-03-07', 'Mardi', 'Mars'),
('2023-03-08', 'Mercredi', 'Mars'),
('2023-03-09', 'Jeudi', 'Mars'),
('2023-03-10', 'Vendredi', 'Mars'),
('2023-03-11', 'Samedi', 'Mars'),
('2023-03-12', 'Dimanche', 'Mars'),
('2023-03-13', 'Lundi', 'Mars'),
('2023-03-14', 'Mardi', 'Mars'),
('2023-03-15', 'Mercredi', 'Mars'),
('2023-03-16', 'Jeudi', 'Mars'),
('2023-03-17', 'Vendredi', 'Mars'),
('2023-03-18', 'Samedi', 'Mars'),
('2023-03-19', 'Dimanche', 'Mars'),
('2023-03-20', 'Lundi', 'Mars'),
('2023-03-21', 'Mardi', 'Mars'),
('2023-03-22', 'Mercredi', 'Mars'),
('2023-03-23', 'Jeudi', 'Mars'),
('2023-03-24', 'Vendredi', 'Mars'),
('2023-03-25', 'Samedi', 'Mars'),
('2023-03-26', 'Dimanche', 'Mars'),
('2023-03-27', 'Lundi', 'Mars'),
('2023-03-28', 'Mardi', 'Mars'),
('2023-03-29', 'Mercredi', 'Mars'),
('2023-03-30', 'Jeudi', 'Mars'),
('2023-03-31', 'Vendredi', 'Mars'),
('2023-04-01', 'Samedi', 'Avril'),
('2023-04-02', 'Dimanche', 'Avril'),
('2023-04-03', 'Lundi', 'Avril'),
('2023-04-04', 'Mardi', 'Avril'),
('2023-04-05', 'Mercredi', 'Avril'),
('2023-04-06', 'Jeudi', 'Avril'),
('2023-04-07', 'Vendredi', 'Avril'),
('2023-04-08', 'Samedi', 'Avril'),
('2023-04-09', 'Dimanche', 'Avril'),
('2023-04-10', 'Lundi', 'Avril'),
('2023-04-11', 'Mardi', 'Avril'),
('2023-04-12', 'Mercredi', 'Avril'),
('2023-04-13', 'Jeudi', 'Avril'),
('2023-04-14', 'Vendredi', 'Avril'),
('2023-04-15', 'Samedi', 'Avril'),
('2023-04-16', 'Dimanche', 'Avril'),
('2023-04-17', 'Lundi', 'Avril'),
('2023-04-18', 'Mardi', 'Avril'),
('2023-04-19', 'Mercredi', 'Avril'),
('2023-04-20', 'Jeudi', 'Avril'),
('2023-04-21', 'Vendredi', 'Avril'),
('2023-04-22', 'Samedi', 'Avril'),
('2023-04-23', 'Dimanche', 'Avril'),
('2023-04-24', 'Lundi', 'Avril'),
('2023-04-25', 'Mardi', 'Avril'),
('2023-04-26', 'Mercredi', 'Avril'),
('2023-04-27', 'Jeudi', 'Avril'),
('2023-04-28', 'Vendredi', 'Avril'),
('2023-04-29', 'Samedi', 'Avril'),
('2023-04-30', 'Dimanche', 'Avril'),
('2023-05-01', 'Lundi', 'Mai'),
('2023-05-02', 'Mardi', 'Mai'),
('2023-05-03', 'Mercredi', 'Mai'),
('2023-05-04', 'Jeudi', 'Mai'),
('2023-05-05', 'Vendredi', 'Mai'),
('2023-05-06', 'Samedi', 'Mai'),
('2023-05-07', 'Dimanche', 'Mai'),
('2023-05-08', 'Lundi', 'Mai'),
('2023-05-09', 'Mardi', 'Mai'),
('2023-05-10', 'Mercredi', 'Mai'),
('2023-05-11', 'Jeudi', 'Mai'),
('2023-05-12', 'Vendredi', 'Mai'),
('2023-05-13', 'Samedi', 'Mai'),
('2023-05-14', 'Dimanche', 'Mai'),
('2023-05-15', 'Lundi', 'Mai'),
('2023-05-16', 'Mardi', 'Mai'),
('2023-05-17', 'Mercredi', 'Mai'),
('2023-05-18', 'Jeudi', 'Mai'),
('2023-05-19', 'Vendredi', 'Mai'),
('2023-05-20', 'Samedi', 'Mai'),
('2023-05-21', 'Dimanche', 'Mai'),
('2023-05-22', 'Lundi', 'Mai'),
('2023-05-23', 'Mardi', 'Mai'),
('2023-05-24', 'Mercredi', 'Mai'),
('2023-05-25', 'Jeudi', 'Mai'),
('2023-05-26', 'Vendredi', 'Mai'),
('2023-05-27', 'Samedi', 'Mai'),
('2023-05-28', 'Dimanche', 'Mai'),
('2023-05-29', 'Lundi', 'Mai'),
('2023-05-30', 'Mardi', 'Mai'),
('2023-05-31', 'Mercredi', 'Mai'),
('2023-06-01', 'Jeudi', 'Juin'),
('2023-06-02', 'Vendredi', 'Juin'),
('2023-06-03', 'Samedi', 'Juin'),
('2023-06-04', 'Dimanche', 'Juin'),
('2023-06-05', 'Lundi', 'Juin'),
('2023-06-06', 'Mardi', 'Juin'),
('2023-06-07', 'Mercredi', 'Juin'),
('2023-06-08', 'Jeudi', 'Juin'),
('2023-06-09', 'Vendredi', 'Juin'),
('2023-06-10', 'Samedi', 'Juin'),
('2023-06-11', 'Dimanche', 'Juin'),
('2023-06-12', 'Lundi', 'Juin'),
('2023-06-13', 'Mardi', 'Juin'),
('2023-06-14', 'Mercredi', 'Juin'),
('2023-06-15', 'Jeudi', 'Juin'),
('2023-06-16', 'Vendredi', 'Juin'),
('2023-06-17', 'Samedi', 'Juin'),
('2023-06-18', 'Dimanche', 'Juin'),
('2023-06-19', 'Lundi', 'Juin'),
('2023-06-20', 'Mardi', 'Juin'),
('2023-06-21', 'Mercredi', 'Juin'),
('2023-06-22', 'Jeudi', 'Juin'),
('2023-06-23', 'Vendredi', 'Juin'),
('2023-06-24', 'Samedi', 'Juin'),
('2023-06-25', 'Dimanche', 'Juin'),
('2023-06-26', 'Lundi', 'Juin'),
('2023-06-27', 'Mardi', 'Juin'),
('2023-06-28', 'Mercredi', 'Juin'),
('2023-06-29', 'Jeudi', 'Juin'),
('2023-06-30', 'Vendredi', 'Juin'),
('2023-07-01', 'Samedi', 'Juillet'),
('2023-07-02', 'Dimanche', 'Juillet'),
('2023-07-03', 'Lundi', 'Juillet'),
('2023-07-04', 'Mardi', 'Juillet'),
('2023-07-05', 'Mercredi', 'Juillet'),
('2023-07-06', 'Jeudi', 'Juillet'),
('2023-07-07', 'Vendredi', 'Juillet'),
('2023-07-08', 'Samedi', 'Juillet'),
('2023-07-09', 'Dimanche', 'Juillet'),
('2023-07-10', 'Lundi', 'Juillet'),
('2023-07-11', 'Mardi', 'Juillet'),
('2023-07-12', 'Mercredi', 'Juillet'),
('2023-07-13', 'Jeudi', 'Juillet'),
('2023-07-14', 'Vendredi', 'Juillet'),
('2023-07-15', 'Samedi', 'Juillet'),
('2023-07-16', 'Dimanche', 'Juillet'),
('2023-07-17', 'Lundi', 'Juillet'),
('2023-07-18', 'Mardi', 'Juillet'),
('2023-07-19', 'Mercredi', 'Juillet'),
('2023-07-20', 'Jeudi', 'Juillet'),
('2023-07-21', 'Vendredi', 'Juillet'),
('2023-07-22', 'Samedi', 'Juillet'),
('2023-07-23', 'Dimanche', 'Juillet'),
('2023-07-24', 'Lundi', 'Juillet'),
('2023-07-25', 'Mardi', 'Juillet'),
('2023-07-26', 'Mercredi', 'Juillet'),
('2023-07-27', 'Jeudi', 'Juillet'),
('2023-07-28', 'Vendredi', 'Juillet'),
('2023-07-29', 'Samedi', 'Juillet'),
('2023-07-30', 'Dimanche', 'Juillet'),
('2023-07-31', 'Lundi', 'Juillet'),
('2023-08-01', 'Mardi', 'Août'),
('2023-08-02', 'Mercredi', 'Août'),
('2023-08-03', 'Jeudi', 'Août'),
('2023-08-04', 'Vendredi', 'Août'),
('2023-08-05', 'Samedi', 'Août'),
('2023-08-06', 'Dimanche', 'Août'),
('2023-08-07', 'Lundi', 'Août'),
('2023-08-08', 'Mardi', 'Août'),
('2023-08-09', 'Mercredi', 'Août'),
('2023-08-10', 'Jeudi', 'Août'),
('2023-08-11', 'Vendredi', 'Août'),
('2023-08-12', 'Samedi', 'Août'),
('2023-08-13', 'Dimanche', 'Août'),
('2023-08-14', 'Lundi', 'Août'),
('2023-08-15', 'Mardi', 'Août'),
('2023-08-16', 'Mercredi', 'Août'),
('2023-08-17', 'Jeudi', 'Août'),
('2023-08-18', 'Vendredi', 'Août'),
('2023-08-19', 'Samedi', 'Août'),
('2023-08-20', 'Dimanche', 'Août'),
('2023-08-21', 'Lundi', 'Août'),
('2023-08-22', 'Mardi', 'Août'),
('2023-08-23', 'Mercredi', 'Août'),
('2023-08-24', 'Jeudi', 'Août'),
('2023-08-25', 'Vendredi', 'Août'),
('2023-08-26', 'Samedi', 'Août'),
('2023-08-27', 'Dimanche', 'Août'),
('2023-08-28', 'Lundi', 'Août'),
('2023-08-29', 'Mardi', 'Août'),
('2023-08-30', 'Mercredi', 'Août'),
('2023-08-31', 'Jeudi', 'Août'),
('2023-09-01', 'Vendredi', 'Septembre'),
('2023-09-02', 'Samedi', 'Septembre'),
('2023-09-03', 'Dimanche', 'Septembre'),
('2023-09-04', 'Lundi', 'Septembre'),
('2023-09-05', 'Mardi', 'Septembre'),
('2023-09-06', 'Mercredi', 'Septembre'),
('2023-09-07', 'Jeudi', 'Septembre'),
('2023-09-08', 'Vendredi', 'Septembre'),
('2023-09-09', 'Samedi', 'Septembre'),
('2023-09-10', 'Dimanche', 'Septembre'),
('2023-09-11', 'Lundi', 'Septembre'),
('2023-09-12', 'Mardi', 'Septembre'),
('2023-09-13', 'Mercredi', 'Septembre'),
('2023-09-14', 'Jeudi', 'Septembre'),
('2023-09-15', 'Vendredi', 'Septembre'),
('2023-09-16', 'Samedi', 'Septembre'),
('2023-09-17', 'Dimanche', 'Septembre'),
('2023-09-18', 'Lundi', 'Septembre'),
('2023-09-19', 'Mardi', 'Septembre'),
('2023-09-20', 'Mercredi', 'Septembre'),
('2023-09-21', 'Jeudi', 'Septembre'),
('2023-09-22', 'Vendredi', 'Septembre'),
('2023-09-23', 'Samedi', 'Septembre'),
('2023-09-24', 'Dimanche', 'Septembre'),
('2023-09-25', 'Lundi', 'Septembre'),
('2023-09-26', 'Mardi', 'Septembre'),
('2023-09-27', 'Mercredi', 'Septembre'),
('2023-09-28', 'Jeudi', 'Septembre'),
('2023-09-29', 'Vendredi', 'Septembre'),
('2023-09-30', 'Samedi', 'Septembre'),
('2023-10-01', 'Dimanche', 'Octobre'),
('2023-10-02', 'Lundi', 'Octobre'),
('2023-10-03', 'Mardi', 'Octobre'),
('2023-10-04', 'Mercredi', 'Octobre'),
('2023-10-05', 'Jeudi', 'Octobre'),
('2023-10-06', 'Vendredi', 'Octobre'),
('2023-10-07', 'Samedi', 'Octobre'),
('2023-10-08', 'Dimanche', 'Octobre'),
('2023-10-09', 'Lundi', 'Octobre'),
('2023-10-10', 'Mardi', 'Octobre'),
('2023-10-11', 'Mercredi', 'Octobre'),
('2023-10-12', 'Jeudi', 'Octobre'),
('2023-10-13', 'Vendredi', 'Octobre'),
('2023-10-14', 'Samedi', 'Octobre'),
('2023-10-15', 'Dimanche', 'Octobre'),
('2023-10-16', 'Lundi', 'Octobre'),
('2023-10-17', 'Mardi', 'Octobre'),
('2023-10-18', 'Mercredi', 'Octobre'),
('2023-10-19', 'Jeudi', 'Octobre'),
('2023-10-20', 'Vendredi', 'Octobre'),
('2023-10-21', 'Samedi', 'Octobre'),
('2023-10-22', 'Dimanche', 'Octobre'),
('2023-10-23', 'Lundi', 'Octobre'),
('2023-10-24', 'Mardi', 'Octobre'),
('2023-10-25', 'Mercredi', 'Octobre'),
('2023-10-26', 'Jeudi', 'Octobre'),
('2023-10-27', 'Vendredi', 'Octobre'),
('2023-10-28', 'Samedi', 'Octobre'),
('2023-10-29', 'Dimanche', 'Octobre'),
('2023-10-30', 'Lundi', 'Octobre'),
('2023-10-31', 'Mardi', 'Octobre'),
('2023-11-01', 'Mercredi', 'Novembre'),
('2023-11-02', 'Jeudi', 'Novembre'),
('2023-11-03', 'Vendredi', 'Novembre'),
('2023-11-04', 'Samedi', 'Novembre'),
('2023-11-05', 'Dimanche', 'Novembre'),
('2023-11-06', 'Lundi', 'Novembre'),
('2023-11-07', 'Mardi', 'Novembre'),
('2023-11-08', 'Mercredi', 'Novembre'),
('2023-11-09', 'Jeudi', 'Novembre'),
('2023-11-10', 'Vendredi', 'Novembre'),
('2023-11-11', 'Samedi', 'Novembre'),
('2023-11-12', 'Dimanche', 'Novembre'),
('2023-11-13', 'Lundi', 'Novembre'),
('2023-11-14', 'Mardi', 'Novembre'),
('2023-11-15', 'Mercredi', 'Novembre'),
('2023-11-16', 'Jeudi', 'Novembre'),
('2023-11-17', 'Vendredi', 'Novembre'),
('2023-11-18', 'Samedi', 'Novembre'),
('2023-11-19', 'Dimanche', 'Novembre'),
('2023-11-20', 'Lundi', 'Novembre'),
('2023-11-21', 'Mardi', 'Novembre'),
('2023-11-22', 'Mercredi', 'Novembre'),
('2023-11-23', 'Jeudi', 'Novembre'),
('2023-11-24', 'Vendredi', 'Novembre'),
('2023-11-25', 'Samedi', 'Novembre'),
('2023-11-26', 'Dimanche', 'Novembre'),
('2023-11-27', 'Lundi', 'Novembre'),
('2023-11-28', 'Mardi', 'Novembre'),
('2023-11-29', 'Mercredi', 'Novembre'),
('2023-11-30', 'Jeudi', 'Novembre'),
('2023-12-01', 'Vendredi', 'Décembre'),
('2023-12-02', 'Samedi', 'Décembre'),
('2023-12-03', 'Dimanche', 'Décembre'),
('2023-12-04', 'Lundi', 'Décembre'),
('2023-12-05', 'Mardi', 'Décembre'),
('2023-12-06', 'Mercredi', 'Décembre'),
('2023-12-07', 'Jeudi', 'Décembre'),
('2023-12-08', 'Vendredi', 'Décembre'),
('2023-12-09', 'Samedi', 'Décembre'),
('2023-12-10', 'Dimanche', 'Décembre'),
('2023-12-11', 'Lundi', 'Décembre'),
('2023-12-12', 'Mardi', 'Décembre'),
('2023-12-13', 'Mercredi', 'Décembre'),
('2023-12-14', 'Jeudi', 'Décembre'),
('2023-12-15', 'Vendredi', 'Décembre'),
('2023-12-16', 'Samedi', 'Décembre'),
('2023-12-17', 'Dimanche', 'Décembre'),
('2023-12-18', 'Lundi', 'Décembre'),
('2023-12-19', 'Mardi', 'Décembre'),
('2023-12-20', 'Mercredi', 'Décembre'),
('2023-12-21', 'Jeudi', 'Décembre'),
('2023-12-22', 'Vendredi', 'Décembre'),
('2023-12-23', 'Samedi', 'Décembre'),
('2023-12-24', 'Dimanche', 'Décembre'),
('2023-12-25', 'Lundi', 'Décembre'),
('2023-12-26', 'Mardi', 'Décembre'),
('2023-12-27', 'Mercredi', 'Décembre'),
('2023-12-28', 'Jeudi', 'Décembre'),
('2023-12-29', 'Vendredi', 'Décembre'),
('2023-12-30', 'Samedi', 'Décembre'),
('2023-12-31', 'Dimanche', 'Décembre');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `numVoie` int NOT NULL,
  `libelleVoie` varchar(100) NOT NULL,
  `codePostal` int NOT NULL,
  `ville` varchar(50) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `estAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `telephone`, `numVoie`, `libelleVoie`, `codePostal`, `ville`, `motDePasse`, `estAdmin`, `created_at`) VALUES
(7, 'Thicot', 'Richardson', 'rico@gmail.com', '0767104698', 2, 'Allee Beaumarchais', 95200, 'Sarcelles', '$2y$10$FL2FQpDT4/4BHbdv3tkRHenORexTxH1HreXKuvmOxAEl6soN2RXzO', 0, '2023-03-11 00:38:20');

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
-- Structure de la table `commande_burgers`
--

DROP TABLE IF EXISTS `commande_burgers`;
CREATE TABLE IF NOT EXISTS `commande_burgers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `burger_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `burger_id` (`burger_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `nom`, `description`, `prix`, `image`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'Menu du jour', 'Entrée + plat + dessert', '18.50', 'https://example.com/menu-jour.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04'),
(2, 'Menu végétarien', 'Entrée + plat végétarien + dessert', '16.00', 'https://example.com/menu-vegetarien.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04'),
(3, 'Menu enfant', 'Plat enfant + dessert + boisson', '9.00', 'https://example.com/menu-enfant.jpg', 1, '2023-02-28 20:18:04', '2023-02-28 20:18:04'),
(4, 'Menu Bokit + Coca 33cl ', 'azerty', '25.00', 'includes/images/bokit.jpg', 1, '2023-03-13 21:53:40', '2023-03-13 21:53:40');

-- --------------------------------------------------------

--
-- Structure de la table `place_disponible`
--

DROP TABLE IF EXISTS `place_disponible`;
CREATE TABLE IF NOT EXISTS `place_disponible` (
  `calendrier_date` date NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `heure` time NOT NULL,
  `nombrePlace` int NOT NULL,
  PRIMARY KEY (`calendrier_date`,`id`,`heure`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int NOT NULL,
  `calendrier_date` date NOT NULL,
  `nom` varchar(255) NOT NULL,
  `nombre_personnes` int NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse_email` varchar(255) NOT NULL,
  `heure_reservation` time NOT NULL,
  PRIMARY KEY (`id_reservation`,`calendrier_date`),
  KEY `calendrier_date` (`calendrier_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déclencheurs `reservation`
--
DROP TRIGGER IF EXISTS `trig_reservation`;
DELIMITER $$
CREATE TRIGGER `trig_reservation` AFTER INSERT ON `reservation` FOR EACH ROW BEGIN
    UPDATE place_disponible SET nombrePlace = nombrePlace - NEW.nombre_personnes 
    WHERE calendrier_date = NEW.calendrier_date AND heure = heure AND id = id;
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
