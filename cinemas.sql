-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 24 fév. 2025 à 06:02
-- Version du serveur : 5.7.43-log
-- Version de PHP : 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sql_cinephoria_g`
--

--
-- Déchargement des données de la table `cinemas`
--

INSERT INTO `cinemas` (`id`, `nom`, `adresse1`, `adresse2`, `cp`, `ville`, `technologies`) VALUES
(1, 'Cinephoria Nantes', '8 Allée la Pérouse', NULL, '44800', 'Saint-Herblain', '[]'),
(2, 'Cinephoria Bordeaux', '23 Allée du 7ème Art', NULL, '33400', 'Talence', '[]'),
(3, 'Cinephoria Toulouse', 'Place Marcel Bouilloux-Lafont', NULL, '31400', 'Toulouse', '[]'),
(4, 'Cinephoria Paris', 'Place du Maquis du Vercors', NULL, '75020', 'Paris', '[]'),
(5, 'Cinephoria Lille', '21 Avenue de l\'Avenir', NULL, '59650', 'Villeneuve-d\'Ascq', '[]'),
(6, 'Cinephoria Charleroi', 'Grand\'Rue 141/143', NULL, '6000', 'Charleroi, Belgique', '[]'),
(7, 'Cinephoria Liège', 'Chaussée de Tongres 200', NULL, '4000', 'Liège, Belgique', '[]');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
