-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 juil. 2025 à 10:05
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `reference` varchar(20) NOT NULL COMMENT 'Format: CMD-YYYY-NNNN',
  `date_creation` datetime NOT NULL DEFAULT current_timestamp(),
  `date_livraison_prevue` date DEFAULT NULL,
  `fournisseur` varchar(100) NOT NULL COMMENT 'Nom du fournisseur',
  `id_utilisateur` int(11) DEFAULT NULL COMMENT 'Créateur de la commande',
  `statut` enum('en_attente','en_cours','livree','annulee') NOT NULL DEFAULT 'en_attente',
  `notes` text DEFAULT NULL,
  `total_ht` decimal(12,2) DEFAULT 0.00 COMMENT 'Total hors taxes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `reference`, `date_creation`, `date_livraison_prevue`, `fournisseur`, `id_utilisateur`, `statut`, `notes`, `total_ht`) VALUES
(1, 'CMD-2025-9481', '2025-07-15 23:02:19', '2025-08-12', 'Fournisseur principal', 1, 'en_attente', 'urgent', 10.00),
(2, 'CMD-2025-5500', '2025-07-15 23:03:21', '2025-08-12', 'F001', 1, 'en_attente', 'urgent', 10.00),
(3, 'CMD-2025-7100', '2025-07-15 23:36:30', '2025-08-26', 'F001', 1, 'en_attente', 'urgent', 10.00),
(4, 'CMD-2025-9488', '2025-07-18 08:59:25', '2025-07-22', 'ffdd', 1, 'en_attente', 'urgent', 1925.00);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
