-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 juil. 2025 à 09:22
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
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `code_admin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `code_admin`) VALUES
(1, 'Admin', 'Principal', 'admin@gmail.com', '$2y$10$tCWRKxjWav9Tx6fsC.wl3uNlU2s/X6wRotYPMMktp5XwD7VgSG9uC', 'ADMIN2024');

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
  `seuil_min` int(100) NOT NULL,
  `unit` varchar(20) NOT NULL DEFAULT 'piece',
  `current_stock` int(11) NOT NULL DEFAULT 0,
  `prix_unitaire` decimal(10,0) NOT NULL,
  `totale_achat` decimal(10,0) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `nom`, `description`, `marque`, `id_categorie`, `date_importation`, `fournisseur`, `seuil_min`, `unit`, `current_stock`, `prix_unitaire`, `totale_achat`, `image`) VALUES
(13, 'Ballpoint Pen	', 'Blue ink pen, smooth writing	', 'BIC', 2, '2025-07-15 21:11:00', 'OfficeDepot	', 5, 'piece', 10, 1, 8, '6876a82623351_1752606758.jpg'),
(14, 'Lever Arch File	', 'Large binder, A4, 75mm spine	Large binder, A4, 75mm spine	', 'Esselte', 4, '2025-07-15 21:41:00', 'FilingPro	', 6, 'set', 10, 10, 100, '6876af27746d2_1752608551.jpg'),
(16, 'Screen Wipes	', '100 wipes for electronics	', 'Fellowes', 6, '2025-07-15 21:53:00', 'CleanPro	', 5, 'pack', 3, 100, 200, '6876b25f35c01_1752609375.jpg'),
(17, 'USB Flash Drive	', '32GB USB 3.0 memory stick	', 'SanDisk', 5, '2025-07-15 21:57:00', 'TechStore', 5, 'piece', 0, 65, 390, '6876b2f390714_1752609523.jpg'),
(22, 'Wireless Mouse	', 'Optical mouse, 2.4GHz wireless	', 'Logitech', 5, '2025-07-16 11:26:00', 'DigitalWave', 5, 'piece', 6, 80, 480, '68777106696cb_1752658182.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `nom_categorie`, `description`, `icon`, `date_creation`) VALUES
(2, 'Stationery', 'Basic writing and paper supplies.', 'fa-file-alt', '2025-07-13 17:21:46'),
(4, 'Filing', 'Tools for document storage and sorting.', 'fa-book', '2025-07-15 20:52:29'),
(5, 'It equipment', 'Computer-related tools and gadgets.', 'fa-laptop', '2025-07-15 20:52:52'),
(6, 'Cleaning', 'Maintenance and hygiene supplies.', 'fa-broom', '2025-07-15 20:53:19');

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
(4, 'CMD-2025-9488', '2025-07-18 08:59:25', '2025-07-22', 'ffdd', 1, 'en_attente', 'urgent', 1925.00),
(5, 'CMD-2025-3382', '2025-07-18 09:10:35', '2025-07-22', 'Fournisseur principal', 4, 'en_attente', 'urgent', 325.00);

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE `demandes` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_article` int(11) DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `urgent` varchar(10) NOT NULL,
  `reason` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `demandes`
--

INSERT INTO `demandes` (`id`, `id_utilisateur`, `id_article`, `product_name`, `category`, `quantity`, `urgent`, `reason`, `comment`, `file_name`, `created_at`, `status`) VALUES
(12, 3, NULL, '', '', 0, '', NULL, NULL, NULL, '2025-07-16 11:20:40', 'pending'),
(13, 3, NULL, '', '', 0, '', NULL, NULL, NULL, '2025-07-16 11:36:38', 'pending'),
(14, 3, NULL, 'Ballpoint Pen	', 'Stationery', 1, 'yes', '', '', NULL, '2025-07-16 12:12:23', 'pending'),
(15, 3, NULL, 'Lever Arch File	', 'Filing', 1, 'yes', '', '', NULL, '2025-07-16 12:12:23', 'pending'),
(16, 3, NULL, 'Ballpoint Pen	', 'Stationery', 1, 'yes', '', '', NULL, '2025-07-16 18:44:30', 'pending'),
(17, 4, NULL, 'Lever Arch File	', 'Filing', 4, 'yes', '', '', NULL, '2025-07-17 07:26:22', 'pending'),
(18, 4, NULL, 'Wireless Mouse	', 'It equipment', 6, 'yes', '', '', NULL, '2025-07-17 07:26:22', 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `id_article` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lignecommande`
--

CREATE TABLE `lignecommande` (
  `id_ligne_commande` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL COMMENT 'Prix au moment de la commande',
  `reçu` int(11) DEFAULT 0 COMMENT 'Quantité déjà livrée'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lignecommande`
--

INSERT INTO `lignecommande` (`id_ligne_commande`, `id_commande`, `id_article`, `quantite`, `prix_unitaire`, `reçu`) VALUES
(1, 1, 10, 10, 1.00, 0),
(2, 2, 10, 10, 1.00, 0),
(3, 3, 10, 10, 1.00, 0),
(4, 4, 9, 35, 55.00, 0);

-- --------------------------------------------------------

--
-- Structure de la table `lignedemandes`
--

CREATE TABLE `lignedemandes` (
  `id_ligne_demande` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `id_demandes` int(11) NOT NULL,
  `id_article` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lignedemandes`
--

INSERT INTO `lignedemandes` (`id_ligne_demande`, `quantite`, `id_demandes`, `id_article`) VALUES
(1, 1, 12, 13),
(2, 1, 13, 16);

-- --------------------------------------------------------

--
-- Structure de la table `mouvementstock`
--

CREATE TABLE `mouvementstock` (
  `id_mouvement` int(11) NOT NULL,
  `type_mouvement` enum('entrée','sortie') NOT NULL,
  `date_mouvement` date NOT NULL,
  `quantite` int(11) NOT NULL,
  `id_article` int(11) DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mouvementstock`
--

INSERT INTO `mouvementstock` (`id_mouvement`, `type_mouvement`, `date_mouvement`, `quantite`, `id_article`, `id_utilisateur`, `commentaire`) VALUES
(1, 'entrée', '2025-07-17', 8, 9, 1, ''),
(2, 'sortie', '2025-07-17', 10, 9, 1, ''),
(3, 'sortie', '2025-07-17', 20, 10, 1, ''),
(4, 'entrée', '2025-07-17', 10, 12, 1, 'Quick restock from alerts'),
(5, 'entrée', '2025-07-17', 1, 11, 1, 'Quick restock from alerts'),
(6, 'entrée', '2025-07-17', 1, 9, 1, 'Quick restock from alerts'),
(7, 'sortie', '2025-07-17', 31, 9, 1, ''),
(8, 'entrée', '2025-07-17', 2, 9, 1, ''),
(9, 'entrée', '2025-07-17', 2, 11, 1, ''),
(10, 'sortie', '2025-07-17', 2, 9, 1, ''),
(11, 'entrée', '2025-07-17', 1, 11, 1, ''),
(12, 'sortie', '2025-07-18', 6, 17, 4, ''),
(13, '', '2025-07-18', 1, 16, 4, '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `fonction` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `PhoneNumber`, `mot_de_passe`, `fonction`) VALUES
(1, 'Mohamed', 'ben salah', 'salah@gmail.com', '53203669', '$2y$10$3FxiMqtbao9BsqDfUa5tdO0AiXY5V6QDh9uj86fJq61BWq/Jwrzi6', 'responsable'),
(2, 'Emna', 'Njeh', 'emnanjeh@gmail.com', '53203669', '$2y$10$5T9tyCEhuJJzZAenh5jc8epZWfS1RsHcZ4wGuRkpbQ8IduiZ6kgQ6', 'utilisateur'),
(3, 'wiem', 'ben massouad', 'wiem25@gmaim.com', '24587963', '$2y$10$9K1z.CrIqA2IdH5hMSqKhuBUj9x5mnXdoQEoABT7A10hv1IgR6RCG', 'utilisateur'),
(4, 'Feki', 'Fatma', 'fatmafeki@gmail.com', '2403669', '$2y$10$AG4LoiE6zNXml6iBcqFl7e3UWjYQfWqToXGfdElNLNkCzM09CKeCu', 'utilisateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `idx_categorie` (`id_categorie`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_utilisateur` (`id_utilisateur`),
  ADD KEY `idx_article` (`id_article`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_article` (`id_article`);

--
-- Index pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
  ADD PRIMARY KEY (`id_ligne_commande`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `lignedemandes`
--
ALTER TABLE `lignedemandes`
  ADD PRIMARY KEY (`id_ligne_demande`),
  ADD KEY `id_demandes` (`id_demandes`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `mouvementstock`
--
ALTER TABLE `mouvementstock`
  ADD PRIMARY KEY (`id_mouvement`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
  MODIFY `id_ligne_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `lignedemandes`
--
ALTER TABLE `lignedemandes`
  MODIFY `id_ligne_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `mouvementstock`
--
ALTER TABLE `mouvementstock`
  MODIFY `id_mouvement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `fk_demandes_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_demandes_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD CONSTRAINT `fk_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `lignedemandes`
--
ALTER TABLE `lignedemandes`
  ADD CONSTRAINT `lignedemandes_ibfk_1` FOREIGN KEY (`id_demandes`) REFERENCES `demandes` (`id`),
  ADD CONSTRAINT `lignedemandes_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
