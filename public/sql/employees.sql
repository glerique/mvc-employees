-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 03 mai 2021 à 15:00
-- Version du serveur :  8.0.23-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `employees`
--

-- --------------------------------------------------------

--
-- Structure de la table `employee`
--

CREATE TABLE `employee` (
  `id` int NOT NULL,
  `last_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `first_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `birth_date` date NOT NULL,
  `hire_date` date NOT NULL,
  `salary` int NOT NULL DEFAULT '0',
  `departement` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `employee`
--

INSERT INTO `employee` (`id`, `last_name`, `first_name`, `birth_date`, `hire_date`, `salary`, `departement`) VALUES
(1, 'Cuset', 'Jean', '1966-06-02', '1995-05-15', 2400, 'informatique'),
(2, 'Dian', 'Charles', '1972-08-30', '2007-04-01', 1800, 'commercial'),
(3, 'Paco', 'Alain', '1958-04-25', '2002-06-06', 2100, 'commercial'),
(4, 'Perez', 'Amanda', '1972-01-11', '1999-03-11', 1700, 'comptable'),
(5, 'Jeanu', 'Thierry', '1970-07-11', '1998-01-01', 1600, 'comptable'),
(6, 'Taque', 'Stephane', '1965-04-08', '2008-02-01', 2000, 'informatique'),
(7, 'Devos', 'Yahn', '1965-07-08', '2009-02-01', 2400, 'informatique'),
(8, 'Tettu', 'Sylvain', '1975-07-11', '2006-02-01', 2000, 'comptable'),
(9, 'Triet', 'Jacques', '1968-11-08', '2005-10-01', 3000, 'informatique'),
(10, 'Jolivet', 'Olivier', '1973-02-23', '2000-11-06', 1800, 'commercial'),
(11, 'Jollet', 'Marc', '1965-04-28', '1999-02-01', 4000, 'informatique'),
(12, 'Milan', 'Adrien', '1980-04-08', '2008-02-01', 2000, 'commercial'),
(13, 'Cerceau', 'Gilles', '1975-03-18', '2008-02-01', 2000, 'informatique'),
(14, 'Tuche', 'Yves', '1965-04-08', '2006-02-01', 2000, 'commercial'),
(15, 'Trichet', 'Antoine', '1978-11-08', '2006-02-01', 1600, 'informatique'),
(16, 'Alan', 'Steven', '1976-01-21', '2006-02-01', 2800, 'informatique'),
(17, 'Dilou', 'Tristan', '1978-01-18', '2006-02-01', 2500, 'informatique'),
(18, 'Jaspe', 'Anouk', '1980-04-08', '2008-02-01', 2000, 'comptable'),
(19, 'Anvers', 'Tonio', '1967-06-06', '2008-02-01', 2400, 'comptable'),
(20, 'Clouzot', 'Edouard', '1955-04-08', '1998-02-01', 5000, 'commercial');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
