-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 12 Juin 2014 à 17:29
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `pioutter`
--
CREATE DATABASE `pioutter` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pioutter`;

-- --------------------------------------------------------

--
-- Structure de la table `piout`
--

CREATE TABLE IF NOT EXISTS `piout` (
  `id_piout` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `contenu` varchar(255) CHARACTER SET utf8 NOT NULL,
  `datepiout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_piout_convers` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_piout`,`id_user`),
  UNIQUE KEY `id_piout` (`id_piout`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Contenu de la table `piout`
--

INSERT INTO `piout` (`id_piout`, `id_user`, `contenu`, `datepiout`, `id_piout_convers`) VALUES
(102, 4, 'gg', '2014-06-11 14:55:40', NULL),
(103, 4, 'gvdfg', '2014-06-12 09:00:48', NULL),
(104, 7, 'Je cours comme un poulet', '2014-06-12 09:19:39', 104),
(106, 6, 'Coucou les enfants', '2014-06-12 09:22:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `piouwers`
--

CREATE TABLE IF NOT EXISTS `piouwers` (
  `id_user_piouwer` int(11) NOT NULL,
  `id_user_piouwed` int(11) NOT NULL,
  PRIMARY KEY (`id_user_piouwer`,`id_user_piouwed`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `piouwers`
--

INSERT INTO `piouwers` (`id_user_piouwer`, `id_user_piouwed`) VALUES
(5, 4),
(5, 6),
(5, 7),
(7, 5);

-- --------------------------------------------------------

--
-- Structure de la table `repiout`
--

CREATE TABLE IF NOT EXISTS `repiout` (
  `id_repiout` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_original` int(11) NOT NULL,
  `id_user_repiout` int(11) NOT NULL,
  `id_piout` int(11) NOT NULL,
  `date_repiout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_repiout`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `repiout`
--

INSERT INTO `repiout` (`id_repiout`, `id_user_original`, `id_user_repiout`, `id_piout`, `date_repiout`) VALUES
(1, 7, 6, 104, '2014-06-12 09:22:02'),
(2, 6, 5, 106, '2014-06-12 09:22:55');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) CHARACTER SET utf8 NOT NULL,
  `mdp` varchar(50) CHARACTER SET utf8 NOT NULL,
  `pseudo` varchar(100) CHARACTER SET utf8 NOT NULL,
  `mail` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sexe` varchar(1) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_user` (`id_user`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `login`, `mdp`, `pseudo`, `mail`, `sexe`) VALUES
(4, 'test2', 'coucou', 'PoussPouss', 'fsdgfs@dgsdg.com', 'M'),
(5, 'test3', 'coucou', 'Calimero', 'calim@ero.com', 'M'),
(6, 'test4', 'coucou', 'NuggetKing', 'calim@ero.com', 'M'),
(7, 'test5', 'coucou', 'ChickenRun', 'calim@ero.com', 'F');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
