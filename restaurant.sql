-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 01 juin 2025 à 20:51
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

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
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `idavis` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_avis` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idavis`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`idavis`, `nom`, `email`, `message`, `date_avis`) VALUES
(1, 'duran pond', 'duranpond@gmail.com', 'Un vrai d&eacute;lice ! Le plat &eacute;tait savoureux, joliment pr&eacute;sent&eacute; et le service impeccable. Merci &agrave; toute l&#039;&eacute;quipe', '2025-06-01 18:31:23'),
(2, 'alice david', 'alicedavid@gmail.com', 'Nous avons pass&eacute; une excellente soir&eacute;e chez [Nom du restaurant] ! Le personnel &eacute;tait tr&egrave;s accueillant et la nourriture d&eacute;licieuse. Nous reviendrons avec plaisir', '2025-06-01 18:32:19'),
(3, 'donald trump', 'donaldtrump@gmail.com', 'Une d&eacute;couverte incroyable ! Nous avons &eacute;t&eacute; enchant&eacute;s par la qualit&eacute; des produits et l&#039;attention port&eacute;e &agrave; chaque d&eacute;tail.', '2025-06-01 18:36:23'),
(4, 'user', 'user2025@gmail.com', 'La nourriture &eacute;tait bonne mais le service &eacute;tait un peu lent ce soir-l&agrave;. Nous esp&eacute;rons que c&#039;&eacute;tait exceptionnel.', '2025-06-01 18:38:16');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `idcommande` int NOT NULL AUTO_INCREMENT,
  `idtable` int DEFAULT NULL,
  `etat` enum('en preparation','servi','en attente','') NOT NULL,
  `datecommande` datetime DEFAULT CURRENT_TIMESTAMP,
  `autredetails` text,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idcommande`),
  KEY `idtable` (`idtable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `detailscommande`
--

DROP TABLE IF EXISTS `detailscommande`;
CREATE TABLE IF NOT EXISTS `detailscommande` (
  `iddetailcommande` int NOT NULL AUTO_INCREMENT,
  `idcommande` int DEFAULT NULL,
  `idplat` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `prixunitaire` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`iddetailcommande`),
  KEY `idcommande` (`idcommande`),
  KEY `idplat` (`idplat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employeur`
--

DROP TABLE IF EXISTS `employeur`;
CREATE TABLE IF NOT EXISTS `employeur` (
  `idemployeur` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  PRIMARY KEY (`idemployeur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `employeur`
--

INSERT INTO `employeur` (`idemployeur`, `email`, `motdepasse`) VALUES
(1, 'nisankenza@gmail.com', '$2y$10$.Rt5Os/mUrRsCXDzgQfb4uunS5ehfk2Mh26FFoa4P0Nm8DO03fbHG'),
(2, 'duranpond@gmail.com', '$2y$10$OYF3.RpkHCSlNgRP3DdgNeMVQtyS51WVlgUeT8Zmi.BdNx6aAh0eG');

-- --------------------------------------------------------

--
-- Structure de la table `plat`
--

DROP TABLE IF EXISTS `plat`;
CREATE TABLE IF NOT EXISTS `plat` (
  `idplat` int NOT NULL AUTO_INCREMENT,
  `nomplat` varchar(255) DEFAULT NULL,
  `description` text,
  `prix` decimal(10,2) DEFAULT NULL,
  `categorie` enum('dessert','plat principale','boisson','entree') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idplat`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plat`
--

INSERT INTO `plat` (`idplat`, `nomplat`, `description`, `prix`, `categorie`, `image`) VALUES
(1, 'Salade César\r\n\r\n', 'Salade fraîche et des legumes avec poulet grillé.', 400.00, 'entree', '\"C:\\Users\\Logitech Tazmalt\\OneDrive\\Bureau\\PROJET\\IMG\\FullMenu\\1.png\"'),
(2, 'Salade composée de saison\r\n\r\n', 'Salade fraîche avec des legumes de saison.', 400.00, 'entree', '\"C:\\Users\\Logitech Tazmalt\\OneDrive\\Bureau\\PROJET\\IMG\\FullMenu\\2.png\"'),
(3, 'Soupe chorba algérienne\r\n\r\n', 'Une soupe traditionnelle parfumée aux épices.', 350.00, 'entree', '\"C:\\Users\\Logitech Tazmalt\\OneDrive\\Bureau\\PROJET\\IMG\\FullMenu\\3.png\"'),
(4, 'Soupe de poisson\r\n\r\n', 'Un délicieux bouillon de la mer.Avec meilleur poissons', 450.00, 'entree', '\"C:\\Users\\Logitech Tazmalt\\OneDrive\\Bureau\\PROJET\\IMG\\FullMenu\\4.png\"'),
(5, 'Tajine de poulet\r\n\r\n', 'Poulet mijoté avec légumes parfumee avec épices.', 750.00, 'plat principale', '\"C:\\Users\\Logitech Tazmalt\\OneDrive\\Bureau\\PROJET\\IMG\\FullMenu\\tajine.png\"'),
(6, 'Couscous\r\n\r\n', 'Couscous viande aux légumes frais bien fait.', 900.00, 'plat principale', '\"C:\\Users\\Logitech Tazmalt\\OneDrive\\Bureau\\PROJET\\IMG\\FullMenu\\5.png\"');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `idreservation` int NOT NULL AUTO_INCREMENT,
  `nomclient` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `numtel` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `datereservation` datetime DEFAULT NULL,
  `nbpersonne` int DEFAULT NULL,
  `occasion` varchar(100) DEFAULT NULL,
  `detailsreservation` text,
  PRIMARY KEY (`idreservation`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`idreservation`, `nomclient`, `email`, `numtel`, `datereservation`, `nbpersonne`, `occasion`, `detailsreservation`) VALUES
(5, 'Zemmour sihame', 'zemmoursihame@gmail.com', '0579303030', '2025-06-23 12:20:00', 2, 'famille', ''),
(6, 'saadi ama', 'rivansaadi@gmail.com', '1293037573', '2025-07-06 14:30:00', 3, 'business', 'pas du glouten'),
(4, 'Moad kenza', 'nisankenza@gmail.com', '0122934810', '2025-06-10 15:10:00', 3, 'anniversaire', 'pas de saumon');

-- --------------------------------------------------------

--
-- Structure de la table `tablerestaurant`
--

DROP TABLE IF EXISTS `tablerestaurant`;
CREATE TABLE IF NOT EXISTS `tablerestaurant` (
  `idtable` int NOT NULL AUTO_INCREMENT,
  `numtable` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idtable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
