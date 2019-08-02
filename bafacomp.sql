-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 02 Août 2019 à 15:30
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bafa`
--

-- --------------------------------------------------------

--
-- Structure de la table `bafacomp`
--

CREATE TABLE `bafacomp` (
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `Themes` text NOT NULL,
  `Lieu` text NOT NULL,
  `Accueil` text NOT NULL,
  `Infos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `bafacomp`
--

INSERT INTO `bafacomp` (`dateDebut`, `dateFin`, `Themes`, `Lieu`, `Accueil`, `Infos`) VALUES
('2019-08-17', '2019-08-24', 'General', 'NANTES ', 'Internat ', 'https://www.afocal.fr/bafa/stage-bafa-0819023.html'),
('2019-10-19', '2019-10-26', 'General', 'NANTES ', 'Internat ', 'https://www.afocal.fr/bafa/stage-bafa-0819031.html');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
