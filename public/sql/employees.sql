-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 04 jan. 2024 à 15:26
-- Version du serveur : 8.0.35-0ubuntu0.22.04.1
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id`, `name`) VALUES
(1, 'Informatique'),
(2, 'Commercial'),
(3, 'Comptable');

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
  `departementId` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `employee`
--

INSERT INTO `employee` (`id`, `last_name`, `first_name`, `birth_date`, `hire_date`, `salary`, `departementId`) VALUES
(1, 'Cuset', 'Jean', '1966-06-02', '1995-05-15', 2400, '1'),
(2, 'Dian', 'Charles', '1972-08-30', '2007-04-01', 1800, '1'),
(3, 'Paco', 'Alain', '1958-04-25', '2002-06-06', 2100, '2'),
(4, 'Perez', 'Amanda', '1972-01-11', '1999-03-11', 1700, '1'),
(5, 'Jeanu', 'Thierry', '1970-07-11', '1998-01-01', 1600, '2'),
(6, 'Taque', 'Stephane', '1965-04-08', '2008-02-01', 2000, '2'),
(7, 'Devos', 'Yahn', '1965-07-08', '2009-02-01', 2400, '1'),
(8, 'Tettu', 'Sylvain', '1975-07-11', '2006-02-01', 2000, '2'),
(9, 'Triet', 'Jacques', '1968-11-08', '2005-10-01', 3000, '1'),
(10, 'Jolivet', 'Olivier', '1973-02-23', '2000-11-06', 1800, '1'),
(11, 'Jollet', 'Marc', '1965-04-28', '1999-02-01', 4000, '2'),
(12, 'Milan', 'Adrien', '1980-04-08', '2008-02-01', 2000, '3'),
(13, 'Cerceau', 'Gilles', '1975-03-18', '2008-02-01', 2000, '3'),
(14, 'Tuche', 'Yves', '1965-04-08', '2006-02-01', 2000, '3'),
(15, 'Trichet', 'Antoine', '1978-11-08', '2006-02-01', 1600, '3'),
(16, 'Alan', 'Steven', '1976-01-21', '2006-02-01', 2800, '1'),
(17, 'Dilou', 'Tristan', '1978-01-18', '2006-02-01', 2500, '1'),
(18, 'Jaspe', 'Anouk', '1980-04-08', '2008-02-01', 2000, '1'),
(19, 'Anvers', 'Tonio', '1967-06-06', '2008-02-01', 2400, '1'),
(20, 'Clouzot', 'Edouard', '1955-04-08', '1998-02-01', 5000, '2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
