-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 juil. 2025 à 09:41
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
(11, 'entrée', '2025-07-17', 1, 11, 1, '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `mouvementstock`
--
ALTER TABLE `mouvementstock`
  ADD PRIMARY KEY (`id_mouvement`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `mouvementstock`
--
ALTER TABLE `mouvementstock`
  MODIFY `id_mouvement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
