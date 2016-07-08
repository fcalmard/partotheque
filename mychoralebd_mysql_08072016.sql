-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 08 Juillet 2016 à 14:50
-- Version du serveur: 5.5.49-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mychoralebd.mysql`
--

-- --------------------------------------------------------

--
-- Structure de la table `Accompagnements`
--

CREATE TABLE IF NOT EXISTS `Accompagnements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `typeaccLibelle_idx` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Accompagnements`
--

INSERT INTO `Accompagnements` (`id`, `active`, `libelle`, `datecreateAt`) VALUES
(1, 1, 'Orchestre', '2016-05-11 00:00:00'),
(4, 1, 'Clavier', '2016-05-12 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `Avancements`
--

CREATE TABLE IF NOT EXISTS `Avancements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `typeavtLibelle_idx` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Avancements`
--

INSERT INTO `Avancements` (`id`, `active`, `libelle`, `datecreateAt`) VALUES
(1, 1, 'En cours', NULL),
(2, 1, 'Supprimée', NULL),
(3, 1, 'Validé', NULL),
(4, 1, 'Clôturé', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Compositeurs`
--

CREATE TABLE IF NOT EXISTS `Compositeurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationalite` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datenaiss` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datedeces` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `historique` longtext COLLATE utf8_unicode_ci,
  `datecreateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Compositeurs_nom_idx` (`nom`,`prenom`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Contenu de la table `Compositeurs`
--

INSERT INTO `Compositeurs` (`id`, `active`, `nom`, `prenom`, `nationalite`, `datenaiss`, `datedeces`, `historique`, `datecreateAt`) VALUES
(1, 1, 'Mozart', 'Wolfgang Amadeus', NULL, '27 janvier 1756', '5 décembre 1791', NULL, '0000-00-00 00:00:00'),
(3, 1, 'Berthier', 'Jacques', 'francais', 'né le 27 juin 1923', 'mort le 27 juin 1994', 'Jacques Berthier (né le 27 juin 1923 à Auxerre - mort le 27 juin 1994 à Paris) est un compositeur et organiste, connu entre autres pour sa large contribution à la composition des chants de la Communauté de Taizé. Né à Auxerre (Bourgogne), ses deux parents étaient musiciens. Initié d''abord par eux, il étudia le piano, l''orgue, l''harmonie et la composition. Après la guerre il entra à l''École César-Franck de Paris où il eut, entre autres professeurs, Édouard Souberbielle et Guy de Lioncourt (avec la fille duquel il se maria). Il fut alors organiste de la cathédrale Saint-Étienne d''Auxerre succédant à son père Paul Berthier entre 1953 et 1960, puis de Saint-Ignace-de-Loyola, l''église des Jésuites à Paris, de 1961 à sa mort. Par ailleurs, il était l''oncle de la chanteuse France Gall. C''est en 1955 qu''il commença à composer pour Taizé, en ce temps-là communauté monastique d''une vingtaine de frères. En 1975, la Communauté fit à nouveau appel à lui pour la composition de chants méditatifs, souvent brefs mais repris longuement, voie de la prière commune à Taizé. Ce concept liturgique fut apporté par le défunt Frère Robert, qui recueillait et rédigeait les textes avant de les envoyer à Berthier avec des directives de mise en forme. La capacité de ce dernier à trouver l''accent juste des mots, même dans des langues qui lui étaient étrangères, et la créativité dont il fit preuve dans la mélodie et l''harmonie des voix ont contribué à la renommée de ce que l''on appelle souvent la " musique de Taizé ". En parallèle de ce travail, Jacques Berthier composa pour les paroisses catholiques traditionnelles, pour les grands rassemblements, pour les communautés monastiques, dans un style très personnel et qui fut toujours inspiré des modes grégoriens. Il mourut chez lui à Paris en 1994, et tint à ce que sa propre musique ne fut pas jouée lors de ses funérailles à l''église Saint-Sulpice. En 2006, le Jubilate Deo Award lui fut décerné à titre posthume, accepté par Frère Jean-Marie (Taizé). En plus de vingt ans, Berthier a laissé un important corpus (232 chants dans 20 langues différentes) aujourd''hui largement repris dans d''autres communautés et de par le monde. Il est également l''auteur de messes pour orgue, d''une cantate en forme de croix et une cantate pour Sainte Cécile.', '2016-04-27 00:00:00'),
(4, 1, 'Palestrina', 'Giovanni Pierluigi', 'Italien', NULL, '1594', 'da Palestrina (1525?-1594)', '2016-04-27 00:00:00'),
(5, 1, 'Bach', 'Johann Sebastian', 'allemand', 'né à Eisenach le 31 mars (21 mars) 1685', 'mort à Leipzig le 28 juillet 1750', NULL, '2016-04-27 00:00:00'),
(6, 1, 'Mawby', 'Collin', 'anglais', '1936-06-27 00:00:00', '', '1936 (age 79–80)', '0000-00-00 00:00:00'),
(7, 1, 'ROBERT\r\n', 'Philippe\r\n', '', '', '', '', '2016-04-27 00:00:00'),
(10, 1, 'Bach', 'Carl Philipp Emanuel', 'allemand', '8 mars 1714', 'Hambourg le 14 décembre 1788,', 'Carl Philipp Emanuel Bach, né à Weimar, alors dans le duché de Saxe-Weimar, le 8 mars 1714 et mort à Hambourg le 14 décembre 1788, est un musicien, compositeur et musicologue allemand.', '2016-05-20 10:15:09');

-- --------------------------------------------------------

--
-- Structure de la table `Fonctions`
--

CREATE TABLE IF NOT EXISTS `Fonctions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2C26824CA4D60759` (`libelle`),
  UNIQUE KEY `codeFonction_idx` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Contenu de la table `Fonctions`
--

INSERT INTO `Fonctions` (`id`, `active`, `code`, `libelle`, `datecreateAt`) VALUES
(1, 1, 'Acclamatio', 'Acclamation', '0000-00-00 00:00:00'),
(2, 1, 'Communion', 'Communion', '0000-00-00 00:00:00'),
(3, 1, 'Entrée', 'Entrée', '0000-00-00 00:00:00'),
(4, 1, 'Kyrie', 'Kyrie', '0000-00-00 00:00:00'),
(5, 1, 'acte pénit', 'acte pénitentiel', '2016-06-30 09:53:46'),
(6, 1, 'Introït', 'Introït', '2016-06-30 09:55:25'),
(7, 1, 'Agnus Dei', 'Agnus Dei', '2016-06-30 09:59:22'),
(8, 1, 'Alleluia', 'Alleluia', '2016-06-30 10:00:48'),
(9, 1, 'Amen', 'Amen', '2016-06-30 10:01:29'),
(10, 1, 'Anamèse', 'Anamèse', '2016-06-30 10:01:56');

-- --------------------------------------------------------

--
-- Structure de la table `Genres`
--

CREATE TABLE IF NOT EXISTS `Genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `historique` longtext COLLATE utf8_unicode_ci,
  `datecreateAt` datetime NOT NULL,
  `typesmus_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AF47E020A4D60759` (`libelle`),
  UNIQUE KEY `codeGenres_idx` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Genres`
--

INSERT INTO `Genres` (`id`, `active`, `code`, `libelle`, `historique`, `datecreateAt`, `typesmus_id`) VALUES
(1, 1, 'religieux', 'Religieux', NULL, '2016-05-04 11:01:50', 1),
(2, 1, 'ChansonPop', 'Chanson populaire', NULL, '2016-05-04 17:17:14', 3),
(3, 1, 'Gregorien', 'Gregorien', NULL, '2016-06-29 15:09:47', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Langues`
--

CREATE TABLE IF NOT EXISTS `Langues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_DE200FC5A4D60759` (`libelle`),
  UNIQUE KEY `codeLangues_idx` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Langues`
--

INSERT INTO `Langues` (`id`, `active`, `code`, `libelle`, `datecreateAt`) VALUES
(1, 1, 'fr', 'Francais', '2016-06-30 15:20:58'),
(2, 1, 'la', 'Latin', '2016-06-30 15:44:15'),
(3, 1, 'an', 'Anglais', '2016-06-30 15:45:39'),
(4, 1, 'al', 'Allemand', '2016-06-30 15:46:34'),
(5, 1, 'it', 'Italien', '2016-06-30 15:58:44');

-- --------------------------------------------------------

--
-- Structure de la table `langues_oeuvres`
--

CREATE TABLE IF NOT EXISTS `langues_oeuvres` (
  `langues_id` int(11) NOT NULL,
  `oeuvres_id` int(11) NOT NULL,
  PRIMARY KEY (`langues_id`,`oeuvres_id`),
  KEY `IDX_48D4CC6928EAE92` (`langues_id`),
  KEY `IDX_48D4CC694928CE22` (`oeuvres_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `langues_oeuvres`
--

INSERT INTO `langues_oeuvres` (`langues_id`, `oeuvres_id`) VALUES
(1, 10),
(1, 11),
(1, 13),
(1, 14),
(3, 10),
(3, 11),
(4, 12),
(5, 11);

-- --------------------------------------------------------

--
-- Structure de la table `Logins`
--

CREATE TABLE IF NOT EXISTS `Logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datecreateAt` datetime NOT NULL,
  `Utilisateurs_id` int(11) DEFAULT NULL,
  `Login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1BFD292892C575B` (`Utilisateurs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Menus`
--

CREATE TABLE IF NOT EXISTS `Menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_menu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `libelle_menu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lnk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `bo_home` tinyint(1) NOT NULL,
  `affdansmenu` tinyint(1) NOT NULL,
  `affdansbo` tinyint(1) NOT NULL,
  `ordreaff` int(11) NOT NULL,
  `tooltip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_mensup` int(11) DEFAULT NULL,
  `formaff` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ImageBo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_menu_idx` (`code_menu`),
  UNIQUE KEY `UNIQ_B3B427CBCB9BEFE4` (`libelle_menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Contenu de la table `Menus`
--

INSERT INTO `Menus` (`id`, `code_menu`, `libelle_menu`, `lnk`, `datecreateAt`, `actif`, `bo_home`, `affdansmenu`, `affdansbo`, `ordreaff`, `tooltip`, `id_mensup`, `formaff`, `ImageBo`) VALUES
(1, 'menus', 'Menus', 'menus', '2016-05-25 10:57:46', 1, 0, 1, 0, 5, 'gestion des menus', 9, '', NULL),
(3, 'Cpsitrs', 'Compositeurs', 'compositeurs', '2016-05-26 00:00:00', 1, 0, 0, 0, 2, 'gestion des compositeurs', 8, '', NULL),
(4, 'tempslitur', 'Temps liturgiques', 'tempsliturgiques', '2016-05-26 00:00:00', 1, 0, 0, 0, 1, 'Temps liturgiques', 9, '', NULL),
(5, 'voix', 'Voix', 'voix', '2016-05-26 00:00:00', 1, 0, 0, 0, 2, 'gestion des voix', 9, '', NULL),
(6, 'oeuvres', 'liste Oeuvres', 'oeuvres', '2016-05-26 00:00:00', 1, 0, 0, 0, 1, 'gestion des oeuvres', 8, '', NULL),
(8, 'mOeuvres', 'Oeuvres', '#', '0000-00-00 00:00:00', 1, 0, 0, 0, 1, 'Oeuvres', NULL, '', NULL),
(9, 'admin', 'Paramétres', '#', '2016-05-26 12:44:53', 1, 0, 1, 0, 3, 'Administration', NULL, '', NULL),
(10, 'classifica', 'Classification', '#', '2016-06-03 10:17:32', 1, 0, 1, 0, 2, NULL, NULL, '', NULL),
(11, 'TypeMusiqu', 'Type de Musique', 'typesmusiques', '2016-06-03 10:39:42', 1, 0, 1, 0, 0, NULL, 10, '', NULL),
(12, 'accompagne', 'Accompagnements', 'accompagnements', '2016-06-03 11:42:34', 1, 0, 1, 0, 0, NULL, 10, '', NULL),
(13, 'profils', 'Profils', 'profils', '2016-06-03 15:26:43', 1, 0, 1, 0, 7, NULL, 9, '', NULL),
(14, 'genres', 'Genres', 'genres', '2016-06-03 15:31:48', 1, 0, 1, 0, 3, NULL, 9, '', NULL),
(15, 'utilisateu', 'Utilisateurs', 'utilisateurs', '2016-06-03 15:35:53', 1, 0, 1, 0, 8, NULL, 9, '', NULL),
(16, 'avancement', 'Avancements', 'avancements', '2016-06-03 15:38:05', 1, 0, 1, 0, 4, NULL, 9, '', NULL),
(17, 'fonctions', 'Fonctions liturgiques', 'fonctions', '0000-00-00 00:00:00', 1, 0, 0, 0, 9, NULL, 9, '', NULL),
(18, 'langues', 'Langues', 'langues', '2016-06-30 15:10:23', 1, 0, 1, 0, 10, NULL, 9, '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `menus_profils`
--

CREATE TABLE IF NOT EXISTS `menus_profils` (
  `menus_id` int(11) NOT NULL,
  `profils_id` int(11) NOT NULL,
  PRIMARY KEY (`menus_id`,`profils_id`),
  KEY `IDX_495FCA0214041B84` (`menus_id`),
  KEY `IDX_495FCA02B9881AFB` (`profils_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Oeuvres`
--

CREATE TABLE IF NOT EXISTS `Oeuvres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` tinyint(1) DEFAULT NULL,
  `titreOeuvre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `anonyme` tinyint(1) DEFAULT NULL,
  `tps_litur_id` int(11) DEFAULT NULL,
  `fonction_id` int(11) DEFAULT NULL,
  `cote` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `voix_id` int(11) DEFAULT NULL,
  `siecle` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  `compositeur_id` int(11) DEFAULT NULL,
  `duree` double DEFAULT '0',
  `commentaire` longtext COLLATE utf8_unicode_ci,
  `genre_id` int(11) DEFAULT NULL,
  `avancement_id` int(11) DEFAULT NULL,
  `traductiontitreOeuvre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `traductionfile` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accompagnement_id` int(11) DEFAULT NULL,
  `fichiertraduction` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sscategvoix_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titreOeuvre_idx` (`titreOeuvre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Contenu de la table `Oeuvres`
--

INSERT INTO `Oeuvres` (`id`, `actif`, `titreOeuvre`, `anonyme`, `tps_litur_id`, `fonction_id`, `cote`, `voix_id`, `siecle`, `reference`, `datecreateAt`, `compositeur_id`, `duree`, `commentaire`, `genre_id`, `avancement_id`, `traductiontitreOeuvre`, `traductionfile`, `accompagnement_id`, `fichiertraduction`, `sscategvoix_id`) VALUES
(7, 1, 'Alleluia de Mawby', 0, 2, NULL, NULL, NULL, NULL, '5245', '2016-04-24 16:11:16', 6, 0, NULL, 1, NULL, NULL, NULL, NULL, '', NULL),
(9, 1, 'Bone Pastor', 0, NULL, NULL, NULL, 3, NULL, '52422', '2016-04-25 18:30:36', 4, 0, 'Cette prière a été récitée autrefois pour la dévotion privée à l''altitude pendant la messe. Il vient des deux derniers versets de Lauda Sion, qui a été composée par saint Thomas d''Aquin (1225-1274) pour la fête de Corpus Christi.', NULL, NULL, 'bon Pasteur', '/tmp/phpQinzVm', NULL, '59c6243f2b1fe80aa528ddfa3bf77f20.pdf', NULL),
(10, 1, 'Messe de St Jean Baptiste', NULL, NULL, NULL, NULL, NULL, NULL, '52422', '2016-04-27 14:04:40', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL),
(11, 1, 'Il fait danser le monde', NULL, NULL, NULL, NULL, NULL, 'XX', '504', '2016-04-27 14:38:40', 3, NULL, 'adaptation d''apres un chorale de Bach', NULL, NULL, NULL, NULL, NULL, '', NULL),
(12, 1, 'Magnificat', NULL, NULL, NULL, NULL, 2, NULL, 'ref', '2016-04-27 14:39:47', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10),
(13, 1, 'Nous Chanterons Pour Toi Seigneur', 1, 3, NULL, NULL, NULL, NULL, 'ref333', '2016-04-27 14:47:34', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL),
(14, 1, 'Voici le pain partagé', NULL, NULL, 2, NULL, NULL, NULL, '5245', '2016-04-27 14:58:18', 5, NULL, NULL, 1, 1, NULL, NULL, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `oeuvres_langues`
--

CREATE TABLE IF NOT EXISTS `oeuvres_langues` (
  `oeuvres_id` int(11) NOT NULL,
  `langues_id` int(11) NOT NULL,
  PRIMARY KEY (`oeuvres_id`,`langues_id`),
  KEY `IDX_FDEE5C054928CE22` (`oeuvres_id`),
  KEY `IDX_FDEE5C0528EAE92` (`langues_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Partitions`
--

CREATE TABLE IF NOT EXISTS `Partitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `pathfichier` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `historique` longtext COLLATE utf8_unicode_ci,
  `datecreateAt` datetime NOT NULL,
  `Oeuvres_id` int(11) DEFAULT NULL,
  `duree` double DEFAULT '0',
  `oeuvre_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partitionFile` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_idx` (`id`),
  UNIQUE KEY `UNIQ_F3AA53AAA4D60759` (`libelle`),
  KEY `IDX_F3AA53AA675CDF2` (`Oeuvres_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Contenu de la table `Partitions`
--

INSERT INTO `Partitions` (`id`, `active`, `pathfichier`, `historique`, `datecreateAt`, `Oeuvres_id`, `duree`, `oeuvre_id`, `libelle`, `partitionFile`) VALUES
(11, 1, '6befcbcd0960dad7113d9764f1fbcb32.pdf', NULL, '2016-05-10 09:31:26', NULL, NULL, 10, 'passion', '/tmp/phpjrkg8z'),
(14, 1, '6befcbcd0960dad7113d9764f1fbcb32.pdf', NULL, '2016-05-10 09:42:41', NULL, NULL, 10, 'passion2', '/tmp/php3I8XS3'),
(16, 1, '59c6243f2b1fe80aa528ddfa3bf77f20.pdf', NULL, '2016-05-13 18:42:08', NULL, NULL, 10, 'passion4', '/tmp/phpKPbzaI'),
(17, 1, '59c6243f2b1fe80aa528ddfa3bf77f20.pdf', NULL, '2016-05-13 19:03:35', NULL, NULL, 10, 'passion5', '/tmp/phpMwr8TN'),
(18, 1, '59c6243f2b1fe80aa528ddfa3bf77f20.pdf', NULL, '2016-05-13 19:04:38', NULL, NULL, 10, 'passion6', '/tmp/phpQcpwwJ'),
(19, 1, '', NULL, '2016-05-13 19:24:44', NULL, NULL, 10, 'passion40', NULL),
(20, 1, '', NULL, '2016-05-13 19:32:37', NULL, NULL, 10, 'passion41', NULL),
(21, 1, '', NULL, '2016-05-16 18:36:25', NULL, 15, 11, 'passion10', NULL),
(22, 1, '6befcbcd0960dad7113d9764f1fbcb32.pdf', NULL, '2016-07-05 14:29:09', NULL, NULL, 10, 'passion101', '/tmp/phpHagqGc');

-- --------------------------------------------------------

--
-- Structure de la table `Profils`
--

CREATE TABLE IF NOT EXISTS `Profils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CodeProfil` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `LibelleProfil` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  `actif` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BA3E26C216EB6A82` (`LibelleProfil`),
  UNIQUE KEY `CodeProfil_idx` (`CodeProfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Profils`
--

INSERT INTO `Profils` (`id`, `CodeProfil`, `LibelleProfil`, `datecreateAt`, `actif`) VALUES
(1, 'admin', 'Administrateurs', '2016-05-25 13:55:36', 1),
(2, 'visiteur', 'Visiteurs', '2016-05-30 00:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `profils_menus`
--

CREATE TABLE IF NOT EXISTS `profils_menus` (
  `menus_id` int(11) NOT NULL,
  `profils_id` int(11) NOT NULL,
  PRIMARY KEY (`profils_id`,`menus_id`),
  KEY `IDX_81AF3EE914041B84` (`menus_id`),
  KEY `IDX_81AF3EE9B9881AFB` (`profils_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `profils_menus`
--

INSERT INTO `profils_menus` (`menus_id`, `profils_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(6, 2),
(8, 1),
(8, 2),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Souscategvoix`
--

CREATE TABLE IF NOT EXISTS `Souscategvoix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voix_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `commentaire` longtext COLLATE utf8_unicode_ci,
  `datecreateAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8664A81BA4D60759` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Contenu de la table `Souscategvoix`
--

INSERT INTO `Souscategvoix` (`id`, `voix_id`, `active`, `libelle`, `commentaire`, `datecreateAt`) VALUES
(1, 54, 1, 'SAB', 'Soprane...', '2016-07-05 00:00:00'),
(2, 4, 1, 'SAB2', NULL, '2016-07-05 00:00:00'),
(3, 1, 0, 'SATB', NULL, '2016-07-06 00:00:00'),
(9, 5, 1, 'zzzzzzzzzzzzzzzzzzzz', NULL, '2016-07-06 20:25:53'),
(10, 2, 1, 'Solo high', NULL, '2016-07-07 12:29:58'),
(11, 5, 1, 'vvvvvvvvvvvvvvvvvvvv', 'vfdxcvxcvv', '2016-07-07 12:42:49'),
(12, 5, 1, 'xxxxxxxxxxxxxxxxxx', NULL, '2016-07-07 12:45:04'),
(13, 4, 1, 'aaaaaaaaaaaaaaaaaaaaa', NULL, '2016-07-07 12:46:48');

-- --------------------------------------------------------

--
-- Structure de la table `TempsLiturgiques`
--

CREATE TABLE IF NOT EXISTS `TempsLiturgiques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tpslLibelle_idx` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

--
-- Contenu de la table `TempsLiturgiques`
--

INSERT INTO `TempsLiturgiques` (`id`, `active`, `libelle`, `datecreateAt`) VALUES
(1, 1, 'Temps ordinaire', '2016-04-27 00:00:00'),
(2, 1, 'Carême', '0000-00-00 00:00:00'),
(3, 1, '08-nov.\r\n', '2016-04-27 00:00:00'),
(4, 1, '4° dim Carême\r\n', '2016-04-27 00:00:00'),
(5, 1, 'Acclamation', '2016-04-27 00:00:00'),
(6, 1, 'annonce de la Foi', '2016-04-27 00:00:00'),
(7, 1, 'Ascension\r\n', '2016-04-27 00:00:00'),
(8, 1, 'Avent\r\n', '2016-04-27 00:00:00'),
(9, 1, 'Avent/Carême\r\n', '2016-04-27 00:00:00'),
(10, 1, 'Carême et Pâques\r\n', '2016-04-27 00:00:00'),
(11, 1, 'Communion\r\n', '2016-04-27 00:00:00'),
(12, 1, 'Complies\r\n', '2016-04-27 00:00:00'),
(13, 1, 'Défunts\r\n', '2016-04-27 00:00:00'),
(14, 1, 'Dimanche ap.Asc\r\n', '2016-04-27 00:00:00'),
(15, 1, 'Eglise\r\n', '2016-04-27 00:00:00'),
(16, 1, 'Epiphanie\r\n', '2016-04-27 00:00:00'),
(17, 1, 'Fête du Christ Roi\r\n', '2016-04-27 00:00:00'),
(18, 1, 'Funér/Mystère de D\r\n', '2016-04-27 00:00:00'),
(19, 1, 'Funérailles\r\n', '2016-04-27 00:00:00'),
(20, 0, 'Grégorien\r\n', '2016-04-27 00:00:00'),
(21, 1, 'Invocation\r\n', '2016-04-27 00:00:00'),
(22, 1, 'Litanies\r\n', '2016-04-27 00:00:00'),
(23, 1, 'Louange\r\n', '2016-04-27 00:00:00'),
(24, 1, 'Louange, Pâques\r\n', '2016-04-27 00:00:00'),
(25, 1, 'Marie/Noël\r\n', '2016-04-27 00:00:00'),
(26, 1, 'Messe chorale\r\n', '2016-04-27 00:00:00'),
(27, 1, 'Messe ST Jean Bapt\r\n', '2016-04-27 00:00:00'),
(28, 1, 'Messe Vienne la paix\r\n', '2016-04-27 00:00:00'),
(29, 1, 'Mystère de dieu\r\n', '2016-04-27 00:00:00'),
(30, 1, 'Noël\r\n', '2016-04-27 00:00:00'),
(31, 1, 'Offertoire\r\n', '2016-04-27 00:00:00'),
(32, 1, 'Office\r\n', '2016-04-27 00:00:00'),
(34, 1, 'Ordi/témoignage\r\n', '2016-04-27 00:00:00'),
(35, 1, 'Ordination\r\n', '2016-04-27 00:00:00'),
(36, 1, 'Pâques', '2016-04-27 00:00:00'),
(37, 1, 'Passion', '2016-04-27 00:00:00'),
(38, 1, 'Pénitence\r\n', '2016-04-27 00:00:00'),
(39, 1, 'Pentecôte\r\n', '2016-04-27 00:00:00'),
(40, 1, 'Rameaux\r\n', '2016-04-27 00:00:00'),
(41, 1, 'Rassemblement\r\n', '2016-04-27 00:00:00'),
(42, 1, 'Réponds\r\n', '2016-04-27 00:00:00'),
(43, 1, 'Semaine Sainte\r\n', '2016-04-27 00:00:00'),
(44, 1, 'Témoignage\r\n', '2016-04-27 00:00:00'),
(45, 1, 'Toussaint\r\n', '2016-04-27 00:00:00'),
(46, 1, 'Trinité\r\n', '2016-04-27 00:00:00'),
(47, 1, 'Trop pr l''Unité\r\n', '2016-04-27 00:00:00'),
(48, 1, 'Vendredi saint\r\n', '2016-04-27 00:00:00'),
(49, 1, 'Vêpres\r\n', '2016-04-27 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `Typesmusiques`
--

CREATE TABLE IF NOT EXISTS `Typesmusiques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `typemLibelle_idx` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Typesmusiques`
--

INSERT INTO `Typesmusiques` (`id`, `active`, `libelle`, `datecreateAt`) VALUES
(1, 1, 'Musique sacrée', '2016-04-27 00:00:00'),
(2, 1, 'Musique liturgique', '2016-04-27 00:00:00'),
(3, 1, 'Musique profane', '2016-04-27 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE IF NOT EXISTS `Utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Passwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL,
  `idPays` int(11) NOT NULL,
  `datecreateAt` datetime NOT NULL,
  `Profils_id` int(11) NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_idx` (`Login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`id`, `Login`, `Passwd`, `Nom`, `Prenom`, `actif`, `idPays`, `datecreateAt`, `Profils_id`, `Email`) VALUES
(1, 'francois', '82da79805c6ad197248a24bd5237f7ff', 'CALEMARD', 'francois', 1, 0, '2016-05-28 00:00:00', 1, 'fcalemard@gmail.com'),
(5, 'zachary', 'bc00af5b80b76229bbbf5594a18fc61b', 'zachary', NULL, 1, 0, '2016-06-01 18:57:39', 2, 'ouccelo@free.fr');

-- --------------------------------------------------------

--
-- Structure de la table `Voix`
--

CREATE TABLE IF NOT EXISTS `Voix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL,
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datecreateAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `libelleVoix_idx` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=63 ;

--
-- Contenu de la table `Voix`
--

INSERT INTO `Voix` (`id`, `active`, `libelle`, `datecreateAt`) VALUES
(1, 1, '3VH/3VM', '2016-04-27 00:00:00'),
(2, 1, 'Unisson', '2016-05-10 00:00:00'),
(3, 1, '4VM', '2016-04-27 00:00:00'),
(4, 1, '1VE', '2016-05-10 00:00:00'),
(5, 1, '1VE,4VM', '2016-05-10 00:00:00'),
(6, 1, '2VM', '2016-05-10 00:00:00'),
(7, 1, '2VE', '2016-05-10 00:00:00'),
(8, 1, '2VE/3VE', '0000-00-00 00:00:00'),
(9, 0, '2VE/4VM', '2016-05-10 00:00:00'),
(11, 1, '2VH', '2016-05-10 00:00:00'),
(13, 1, '2VX', '2016-05-10 00:00:00'),
(14, 1, '2x4VM', '2016-05-10 00:00:00'),
(15, 1, '3VE', '2016-05-10 00:00:00'),
(16, 1, '3VE,3VM', '2016-05-10 00:00:00'),
(17, 1, '3VE,VH', '2016-05-10 00:00:00'),
(18, 1, '3VE/4VM', '2016-05-10 00:00:00'),
(19, 1, '3VE/VM', '2016-05-10 00:00:00'),
(20, 1, '3VEH', '2016-05-10 00:00:00'),
(21, 1, '3VH', '2016-05-10 00:00:00'),
(23, 1, '3VH/4VM', '2016-05-10 00:00:00'),
(24, 1, '3VM', '2016-05-10 00:00:00'),
(25, 1, '3VM, Unisson', '2016-05-10 00:00:00'),
(26, 1, '3VM,3VM', '2016-05-10 00:00:00'),
(27, 1, '3VM/4VM', '2016-05-10 00:00:00'),
(28, 1, '3VM/VE', '2016-05-10 00:00:00'),
(29, 1, '4V canon', '2016-05-10 00:00:00'),
(30, 1, '4VE', '2016-05-10 00:00:00'),
(31, 1, '4VE/4VM', '2016-05-10 00:00:00'),
(32, 1, '4VH', '2016-05-10 00:00:00'),
(34, 1, '4VM et 1V', '2016-05-12 00:00:00'),
(35, 1, '4VM,3VE', '2016-05-12 00:00:00'),
(37, 1, '4VM,VE', '2016-05-10 00:00:00'),
(38, 1, '4VM/2VE', '2016-05-10 00:00:00'),
(39, 1, '4VM/3VE', '2016-05-10 00:00:00'),
(40, 1, '4VM/SA', '2016-05-10 00:00:00'),
(41, 1, '4VM/VE', '2016-05-10 00:00:00'),
(42, 1, '4VM+solo', '2016-05-10 00:00:00'),
(43, 1, '4VM+VE', '2016-05-10 00:00:00'),
(44, 1, '5VM', '2016-05-10 00:00:00'),
(45, 1, '6VE', '2016-05-10 00:00:00'),
(46, 1, '6VM', '2016-05-10 00:00:00'),
(47, 1, '6VM/7VM', '2016-05-10 00:00:00'),
(48, 1, '7VM', '2016-05-10 00:00:00'),
(49, 1, '8VM', '2016-05-10 00:00:00'),
(50, 1, '9 VM', '2016-05-10 00:00:00'),
(51, 1, 'duo', '2016-05-10 00:00:00'),
(52, 1, 'Grégorien', '2016-05-10 00:00:00'),
(53, 1, 'Harmon.', '2016-05-10 00:00:00'),
(54, 1, 'Solo', '2016-05-10 00:00:00'),
(55, 1, 'Solo Basse', '2016-05-10 00:00:00'),
(56, 1, 'solo S', '2016-05-10 00:00:00'),
(57, 1, 'Solo/4VM', '2016-05-10 00:00:00'),
(58, 1, 'solo+4VM', '2016-05-10 00:00:00'),
(59, 1, 'SoloS+Ch', '2016-05-10 00:00:00'),
(60, 1, 'triple cho', '2016-05-10 00:00:00'),
(61, 1, 'U/3VM', '2016-05-10 00:00:00'),
(62, 1, 'Unis/3VE', '2016-05-10 00:00:00');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `langues_oeuvres`
--
ALTER TABLE `langues_oeuvres`
  ADD CONSTRAINT `FK_48D4CC6928EAE92` FOREIGN KEY (`langues_id`) REFERENCES `Langues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_48D4CC694928CE22` FOREIGN KEY (`oeuvres_id`) REFERENCES `Oeuvres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Logins`
--
ALTER TABLE `Logins`
  ADD CONSTRAINT `FK_1BFD292892C575B` FOREIGN KEY (`Utilisateurs_id`) REFERENCES `Utilisateurs` (`id`);

--
-- Contraintes pour la table `menus_profils`
--
ALTER TABLE `menus_profils`
  ADD CONSTRAINT `FK_495FCA0214041B84` FOREIGN KEY (`menus_id`) REFERENCES `Menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_495FCA02B9881AFB` FOREIGN KEY (`profils_id`) REFERENCES `Profils` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `oeuvres_langues`
--
ALTER TABLE `oeuvres_langues`
  ADD CONSTRAINT `FK_FDEE5C0528EAE92` FOREIGN KEY (`langues_id`) REFERENCES `Langues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_FDEE5C054928CE22` FOREIGN KEY (`oeuvres_id`) REFERENCES `Oeuvres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Partitions`
--
ALTER TABLE `Partitions`
  ADD CONSTRAINT `FK_F3AA53AA675CDF2` FOREIGN KEY (`Oeuvres_id`) REFERENCES `Oeuvres` (`id`);

--
-- Contraintes pour la table `profils_menus`
--
ALTER TABLE `profils_menus`
  ADD CONSTRAINT `FK_81AF3EE914041B84` FOREIGN KEY (`menus_id`) REFERENCES `Menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_81AF3EE9B9881AFB` FOREIGN KEY (`profils_id`) REFERENCES `Profils` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
