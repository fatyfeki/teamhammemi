-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 13 juil. 2025 à 18:43
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ch office track`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_article` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `date_importation` datetime NOT NULL,
  `fournisseur` varchar(100) NOT NULL,
  `info_fournisseur` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `seuil_min` int(100) NOT NULL,
  `unit` varchar(20) NOT NULL DEFAULT 'piece',
  `current_stock` int(11) NOT NULL DEFAULT 0,
  `prix_achat` decimal(10,0) NOT NULL,
  `totale_achat` decimal(10,0) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `nom`, `description`, `marque`, `id_categorie`, `date_importation`, `fournisseur`, `info_fournisseur`, `location`, `seuil_min`, `unit`, `current_stock`, `prix_achat`, `totale_achat`, `image`) VALUES
(5, 'Marquers', 'Marqueurs permanents Ã  pointe fine, encre indÃ©lÃ©bile, utilisable sur carton, plastique, verre, mÃ©tal, etc. SÃ©chage rapide, rÃ©sistant Ã  lâ€™eau et Ã  la lumiÃ¨re. Disponible en rouge, bleu, noir, vert.', 'Pilot', 2, '2025-07-13 17:23:27', 'SociÃ©tÃ© Bureau Pro Tunisie', '', 'service de vente', 5, 'box', 100, 3, 250, 'uploads/product_6873cf6f3e027.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `idx_categorie` (`id_categorie`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
