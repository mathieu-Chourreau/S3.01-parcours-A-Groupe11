-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 13 mars 2024 à 02:22
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae3.01`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenirrc`
--

DROP TABLE IF EXISTS `appartenirrc`;
CREATE TABLE IF NOT EXISTS `appartenirrc` (
  `identifiantR` int NOT NULL,
  `identifiantC` int NOT NULL,
  PRIMARY KEY (`identifiantR`,`identifiantC`),
  KEY `identifiantC` (`identifiantC`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `appartenirrc`
--

INSERT INTO `appartenirrc` (`identifiantR`, `identifiantC`) VALUES
(1, 1),
(2, 1),
(3, 6),
(4, 3),
(5, 1),
(6, 6),
(7, 3),
(8, 6),
(9, 3),
(10, 3),
(11, 3),
(12, 1),
(13, 6),
(14, 6),
(15, 3),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 3),
(21, 1),
(22, 6),
(23, 5),
(24, 6),
(25, 6),
(26, 1);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `identifiant` int NOT NULL,
  `note` decimal(2,1) NOT NULL,
  `commentaire` varchar(100) DEFAULT NULL,
  `date_publication` date NOT NULL,
  `identifiantU` int NOT NULL,
  `identifiantR` int NOT NULL,
  PRIMARY KEY (`identifiant`),
  KEY `identifiantR` (`identifiantR`),
  KEY `identifiantU` (`identifiantU`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`identifiant`, `note`, `commentaire`, `date_publication`, `identifiantU`, `identifiantR`) VALUES
(1, 4.7, 'La cuisson du steak était parfaite', '0000-00-00', 1, 4),
(2, 3.5, 'Le curry était un peu trop épicé pour moi, mais le poulet était bien cuit.', '0000-00-00', 2, 5),
(3, 4.2, 'Une salade fraîche et délicieuse. Les saveurs se marient parfaitement.', '0000-00-00', 3, 6),
(4, 4.8, 'Le saumon était incroyablement savoureux. La sauce à la crème fraîche était divine.', '0000-00-00', 4, 7),
(5, 4.5, 'Le risotto était crémeux et délicieux. Les champignons ajoutent une belle texture.', '0000-00-00', 1, 8),
(6, 4.0, 'Le tartare de bœuf était frais et délicieux. Un régal pour les amateurs de viande crue.', '0000-00-00', 2, 9),
(7, 3.8, 'Les pâtes étaient délicieuses, mais la sauce était un peu trop riche pour moi.', '0000-00-00', 3, 10),
(8, 4.6, 'Les crevettes étaient parfaitement grillées et lajout de citron parfait.', '0000-00-00', 4, 11),
(9, 3.9, 'Un bon curry végétarien, mais je pense quil aurait pu être un peu plus épicé.', '0000-00-00', 1, 12),
(10, 4.4, 'Une pizza simple mais délicieuse. La croûte était parfaite.', '0000-00-00', 2, 13);

-- --------------------------------------------------------

--
-- Structure de la table `avoir`
--

DROP TABLE IF EXISTS `avoir`;
CREATE TABLE IF NOT EXISTS `avoir` (
  `identifiantV` int NOT NULL,
  `identifiantL` int NOT NULL,
  PRIMARY KEY (`identifiantV`,`identifiantL`),
  KEY `identifiantL` (`identifiantL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avoir`
--

INSERT INTO `avoir` (`identifiantV`, `identifiantL`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categorieingredient`
--

DROP TABLE IF EXISTS `categorieingredient`;
CREATE TABLE IF NOT EXISTS `categorieingredient` (
  `identifiant` int NOT NULL,
  `categorie` varchar(30) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorieingredient`
--

INSERT INTO `categorieingredient` (`identifiant`, `categorie`) VALUES
(1, 'Viande rouge'),
(2, 'Viande blanche'),
(3, 'Legume'),
(4, 'Poisson'),
(5, 'Feculent'),
(6, 'Produit laitier'),
(7, 'huile'),
(8, 'Epice');

-- --------------------------------------------------------

--
-- Structure de la table `categorierecette`
--

DROP TABLE IF EXISTS `categorierecette`;
CREATE TABLE IF NOT EXISTS `categorierecette` (
  `identifiant` int NOT NULL,
  `gout` varchar(10) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorierecette`
--

INSERT INTO `categorierecette` (`identifiant`, `gout`) VALUES
(1, 'Salé'),
(2, 'Sucré'),
(3, 'Épicé'),
(4, 'Amer'),
(5, 'Acide'),
(6, 'Végétarien');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `Ingredient_id` varchar(70) NOT NULL,
  `Recette_id` int NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`Ingredient_id`,`Recette_id`),
  KEY `Recette_id` (`Recette_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`Ingredient_id`, `Recette_id`, `quantite`) VALUES
('Saumon', 7, 250),
('Herbes de Provence', 6, 10),
('Huile d olive', 6, 5),
('Feta', 6, 15),
('Concombre', 6, 15),
('Tomate', 6, 15),
('Salade', 6, 140),
('Riz', 5, 200),
('Curry', 5, 10),
('Blanc de poulet', 5, 290),
('Steak de bœuf', 11, 300),
('Lardons', 4, 130),
('Basilic', 4, 20),
('Mozzarella', 4, 50),
('Tomate', 4, 50),
('Pate a pizza', 4, 150),
('Paprika', 3, 100),
('Mozzarella', 3, 100),
('Riz', 3, 300),
('Curry', 3, 50),
('Curry', 2, 30),
('Ail', 2, 20),
('Crevettes', 2, 250),
('Sel', 1, 5),
('Poivre', 1, 5),
('Creme', 1, 50),
('Parmesan', 1, 50),
('Lardons', 1, 150),
('Pates', 1, 200),
('Aneth', 7, 30),
('Riz', 8, 150),
('Champignon', 8, 100),
('Parmesan', 8, 50),
('Tartare de bœuf', 9, 150),
('Pain complet', 9, 50),
('Cote de porc', 10, 200),
('Pommes de terre', 10, 100),
('Creme', 7, 50),
('Pâtes', 12, 250),
('Sauce Carbonara', 12, 150),
('Parmesan râpé', 12, 30),
('Œufs', 13, 4),
('Légumes variés', 13, 200),
('Sel', 13, 5),
('Poivre', 13, 5),
('Riz', 14, 200),
('Légumes sautés', 14, 150),
('Sauce soja', 14, 20),
('Poulet grillé', 15, 150),
('Pain pour sandwich', 15, 2),
('Légumes frais', 15, 100),
('Pâtes', 16, 250),
('Sauce tomate', 16, 150),
('Fromage râpé', 16, 30),
('Pâtes', 17, 250),
('Lardons', 17, 150),
('Sauce Carbonara', 17, 150),
('Parmesan râpé', 17, 30),
('Sel', 17, 5),
('Poivre', 17, 5),
('Persil', 17, 10),
('Poulet', 18, 200),
('Tomates', 18, 150),
('Concombres', 18, 100),
('Vinaigrette', 18, 30),
('Spaghetti', 19, 300),
('Sauce Bolognaise', 19, 200),
('Parmesan', 19, 30),
('Poulet', 20, 250),
('Légumes variés', 20, 150),
('Salsa', 20, 50),
('Guacamole', 20, 50),
('Riz', 21, 200),
('Légumes sautés', 21, 150),
('Jambon', 21, 100),
('Œufs', 21, 3),
('Œufs', 22, 4),
('Fromage', 22, 50),
('Légumes variés', 22, 200),
('Poulet grillé', 22, 150),
('Sauce au yaourt', 22, 30),
('Poulet', 23, 300),
('Citron', 23, 1),
('Quinoa', 24, 150),
('Légumes variés', 24, 100),
('Herbes', 24, 10),
('Vinaigrette légère', 24, 30),
('Pâtes', 25, 250),
('Sauce Alfredo', 25, 150),
('Brocolis', 25, 100),
('Parmesan', 25, 30),
('Poulet', 26, 400),
('Lait de coco', 26, 200),
('Légumes variés', 26, 150),
('Riz basmati', 26, 150);

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `nom` varchar(70) NOT NULL,
  `prixKg` decimal(4,1) NOT NULL,
  `identifiantC` int NOT NULL,
  PRIMARY KEY (`nom`),
  KEY `identifiantC` (`identifiantC`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredient`
--

INSERT INTO `ingredient` (`nom`, `prixKg`, `identifiantC`) VALUES
('Steak de bœuf', 13.0, 1),
('Cote de porc', 9.5, 1),
('Agneau', 15.0, 1),
('Bœuf hache', 11.8, 1),
('Ragout de bœuf', 14.0, 1),
('Lardons', 10.5, 1),
('Jarret de bœuf', 16.0, 1),
('Merguez', 8.3, 1),
('Tartare de bœuf', 16.5, 1),
('Bœuf stroganoff', 14.8, 1),
('Blanc de poulet', 11.0, 2),
('Cuisse de poulet', 8.5, 2),
('Dinde', 10.0, 2),
('Escalope de dinde', 8.0, 2),
('Poulet roti', 11.3, 2),
('Aiguillettes de poulet', 10.8, 2),
('Cuisses de dinde', 9.8, 2),
('Filet de poulet', 12.5, 2),
('Poitrine de poulet', 10.3, 2),
('Poulet pane', 9.0, 2),
('Tomate', 2.3, 3),
('Carotte', 1.2, 3),
('Courgette', 2.5, 3),
('Brocoli', 1.9, 3),
('Poivron', 1.8, 3),
('Aubergine', 3.0, 3),
('Oignon', 1.3, 3),
('Champignon', 3.5, 3),
('Salade', 2.8, 3),
('Epinards', 2.4, 3),
('Concombre', 2.4, 3),
('Ail', 2.0, 3),
('Saumon', 16.0, 4),
('Crevettes', 17.5, 4),
('Thon en conserve', 5.8, 4),
('Filet de tilapia', 10.0, 4),
('Morue', 12.5, 4),
('Sardines', 8.3, 4),
('Truite', 14.8, 4),
('Bar', 19.0, 4),
('Calamars', 16.8, 4),
('Anchois', 11.5, 4),
('Riz', 3.7, 5),
('Pates', 2.5, 5),
('Quinoa', 5.0, 5),
('Pommes de terre', 2.0, 5),
('Ble entier', 3.3, 5),
('Couscous', 2.8, 5),
('Orge', 4.5, 5),
('Pain complet', 2.2, 5),
('Lentilles', 1.9, 5),
('Patates douces', 3.0, 5),
('Pate a pizza', 3.7, 5),
('Lait', 3.0, 6),
('Fromage cheddar', 5.5, 6),
('Yaourt nature', 1.8, 6),
('Beurre', 3.3, 6),
('Creme', 2.5, 6),
('Fromage de chevre', 7.0, 6),
('Parmesan', 9.0, 6),
('Creme glacee vanille', 4.8, 6),
('Feta', 6.0, 6),
('Fromage suisse', 6.5, 6),
('Mozzarella', 5.0, 6),
('Huile d olive', 6.5, 7),
('Huile de tournesol', 5.3, 7),
('Huile de colza', 5.8, 7),
('Cumin', 3.0, 8),
('Paprika', 1.8, 8),
('Curry', 3.3, 8),
('Cannelle', 2.5, 8),
('Gingembre', 5.0, 8),
('Poivre', 1.9, 8),
('Sel', 1.6, 8),
('Herbes de Provence', 4.0, 8),
('Aneth', 1.5, 8),
('Basilic', 1.5, 8),
('Sauce Carbonara', 4.5, 6),
('Parmesan râpé', 10.0, 6),
('Œufs', 2.5, 2),
('Légumes variés', 3.0, 3),
('Légumes sautés', 4.0, 3),
('Sauce soja', 2.3, 7),
('Poulet grillé', 11.0, 2),
('Pain pour sandwich', 2.2, 5),
('Légumes frais', 2.8, 3),
('Sauce tomate', 2.3, 3),
('Fromage râpé', 10.0, 6);

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `identifiant` int NOT NULL,
  `libelle` varchar(10) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `langue`
--

INSERT INTO `langue` (`identifiant`, `libelle`) VALUES
(1, 'Français'),
(2, 'English');

-- --------------------------------------------------------

--
-- Structure de la table `preferencescomplementaires`
--

DROP TABLE IF EXISTS `preferencescomplementaires`;
CREATE TABLE IF NOT EXISTS `preferencescomplementaires` (
  `user_id` int NOT NULL,
  `vege_pref` int NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `tempsCuisine` int NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `preferences_utilisateur`
--

DROP TABLE IF EXISTS `preferences_utilisateur`;
CREATE TABLE IF NOT EXISTS `preferences_utilisateur` (
  `nom_utilisateur` varchar(70) NOT NULL,
  `nom_ingredient` varchar(70) NOT NULL,
  `preference` float(2,1) NOT NULL,
  PRIMARY KEY (`nom_utilisateur`,`nom_ingredient`),
  KEY `nom_ingredient` (`nom_ingredient`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `identifiant` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `instruction` varchar(1000) NOT NULL,
  `temps_min_` int NOT NULL,
  `niveau_difficulte` varchar(10) NOT NULL,
  `grammage` int NOT NULL,
  `identifiantVideo` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`identifiant`),
  UNIQUE KEY `identifiantVideo` (`identifiantVideo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`identifiant`, `nom`, `instruction`, `temps_min_`, `niveau_difficulte`, `grammage`, `identifiantVideo`, `image`) VALUES
(9, 'Tartare de Bœuf', 'Préparez un tartare de bœuf en coupant finement le bœuf, en ajoutant des condiments et en servant avec des toasts.', 25, 'Facile', 200, 7, 'image/tartare-de-boeuf.jpg'),
(7, 'Saumon Grillé', 'Faites griller des filets de saumon avec du citron et servez avec une sauce à base de crème fraîche et daneth.', 30, 'Moyen', 330, 5, 'image/pave-de-saumon-grille.jpg'),
(8, 'Risotto aux Champignons', 'Préparez un délicieux risotto avec du riz, des champignons, du parmesan et du bouillon de légumes.', 35, 'Moyen', 300, 6, 'image/risotto-aux-champignons.jpg'),
(4, 'Pizza Margherita', 'Faites une pizza classique avec une pâte à pizza, de la sauce tomate, de la mozzarella et du basilic.', 25, 'Facile', 400, 11, 'image/pizza-margarita.jpg'),
(11, 'Steak de Bœuf Grillé', 'Préparez un steak de bœuf et faites-le griller à la perfection. Assaisonnez avec du sel et du poivre selon votre goût.', 20, 'Facile', 300, 2, 'image/steak.jpg'),
(5, 'Poulet Curry', 'Cuisinez des morceaux de blanc de poulet avec du curry, des légumes et du lait de coco. Servez avec du riz.', 40, 'Moyen', 500, 3, 'image/poulet-curry.jpg'),
(6, 'Salade Grecque', 'Préparez une salade fraîche avec des tomates, concombres, olives, feta et assaisonnez avec de lhuile dolive et des herbes de Provence.', 15, 'Facile', 200, 4, 'image/salade-grecque.jpg'),
(3, 'Curry Végétarien', 'Préparez un curry végétarien avec des légumes, du lait de coco et du curry. Servez avec du riz.', 40, 'Moyen', 500, 10, 'image/curry-vege.jpg'),
(1, 'Pâtes Carbonara', 'Des pâtes crémeuses avec une sauce Carbonara riche et savoureuse.', 20, 'Facile', 460, 1, 'image/pate-carbonara.jpg'),
(2, 'Crevettes Grillées au Curry', 'Faites griller des crevettes avec du citron et de lail pour une saveur délicieuse.', 20, 'Facile', 300, 9, 'image/crevette-grille-au-curry.jpg'),
(10, 'Poulet-frite', 'Poulet avec des frites.', 30, 'Moyen', 300, 8, 'image/poulet-frite.jpg'),
(12, 'Pâtes à la Carbonara Rapides', 'Cuisinez des pâtes et mélangez-les avec une sauce Carbonara prête à l emploi. Garnissez de parmesan.', 15, 'Facile', 300, 23, 'image/pate-carbo-rapide'),
(13, 'Omelette aux Légumes', 'Battez des œufs, ajoutez des légumes coupés en dés et faites cuire le tout dans une poêle. Simple et nutritif.', 20, 'Facile', 250, 24, 'image/omelette-legume.jpg'),
(14, 'Riz Sauté aux Légumes', 'Faites cuire du riz et mélangez-le avec des légumes sautés. Assaisonnez avec de la sauce soja pour plus de saveur.', 25, 'Facile', 350, 25, 'image/riz-saute-legume.jpg'),
(15, 'Sandwich au Poulet Grillé', 'Faites griller des morceaux de poulet, assemblez-les dans un sandwich avec des légumes frais. Rapide et délicieux.', 15, 'Facile', 200, 26, 'image/sandwitch-poulet.jpg'),
(16, 'Pâtes aux Tomates et Fromage', 'Cuisinez des pâtes, ajoutez une sauce tomate et du fromage râpé. Un repas simple mais savoureux.', 20, 'Facile', 300, 27, 'image/pate-tomate-fromage.jpg'),
(17, 'Salade de Poulet Grillé', 'Préparez une salade fraîche avec des morceaux de poulet grillé, tomates, concombres et vinaigrette.', 20, 'Facile', 300, NULL, 'image/salade-poulet.jpg'),
(18, 'Spaghetti Bolognaise', 'Cuisinez des spaghettis avec une sauce bolognaise savoureuse. Garnissez de parmesan.', 30, 'Moyen', 350, NULL, 'image/pate-bolo.jpg'),
(19, 'Tacos au Poulet', 'Préparez des tacos au poulet avec des légumes frais, salsa et guacamole.', 25, 'Facile', 250, NULL, 'image/tacos-poulet.jpg'),
(20, 'Riz Cantonais', 'Faites cuire du riz avec des légumes sautés, du jambon et des œufs pour un plat délicieux.', 25, 'Moyen', 400, NULL, 'image/riz-cantonais.jpg'),
(21, 'Omelette au Fromage', 'Battez des œufs, ajoutez du fromage et faites cuire une omelette moelleuse.', 15, 'Facile', 200, NULL, 'image/omelette-fromage.jpg'),
(22, 'Wraps aux Légumes', 'Préparez des wraps sains avec des légumes variés, du poulet grillé et de la sauce au yaourt.', 20, 'Facile', 300, NULL, 'image/wrap-legume.jpg'),
(23, 'Poulet au Citron', 'Cuisinez des morceaux de poulet avec une sauce au citron légère. Servez avec du riz.', 30, 'Moyen', 400, NULL, 'image/poulet-citron.jpg'),
(24, 'Salade de Quinoa', 'Faites une salade nutritive avec du quinoa, des légumes, des herbes et une vinaigrette légère.', 20, 'Facile', 250, NULL, 'image/salade-quinoa.jpg'),
(25, 'Pâtes Alfredo aux Brocolis', 'Cuisinez des pâtes Alfredo crémeuses avec des morceaux de brocolis. Ajoutez du parmesan.', 25, 'Moyen', 350, NULL, 'image/pate-brocoli.jpg'),
(26, 'Poulet au Curry Doux', 'Préparez du poulet au curry doux avec du lait de coco, des légumes et du riz basmati.', 35, 'Moyen', 450, NULL, 'image/poulet-curry-doux.jpg'),
(27, 'pate aux lardons', 'des pates avec des lardons', 45, 'Moyen', 0, NULL, NULL),
(28, 'pate aux lardons', 'des pates avec des lardons', 45, 'Moyen', 0, NULL, NULL),
(29, 'pate aux lardons', 'des pates avec des lardons', 45, 'Moyen', 0, NULL, NULL),
(30, 'pate aux lardons', 'des pates avec des lardons', 45, 'Moyen', 0, NULL, NULL),
(31, 'pate aux lardons', 'des pates avec des lardons', 0, 'Moyen', 0, NULL, NULL),
(32, 'djkhkdjs', 'kjdhkjlkjglrk', 0, 'Moyen', 0, NULL, NULL),
(33, 'Salade', 'Salade verte', 0, 'Facile', 0, NULL, NULL),
(34, 'Salaed ', 'zergvzrgv', 0, 'Facile', 0, NULL, NULL),
(35, 'azer', 'azerazer', 0, 'Facile', 0, NULL, NULL),
(36, 'azerazerazerazerazer', 'azerazerazerazer', 0, 'Facile', 0, NULL, NULL),
(37, 'carotte verte', 'verte', 0, 'Facile', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `recetteavalider`
--

DROP TABLE IF EXISTS `recetteavalider`;
CREATE TABLE IF NOT EXISTS `recetteavalider` (
  `id` int NOT NULL,
  `nom` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `grammage` int DEFAULT NULL,
  `tempsPreparation` int DEFAULT NULL,
  `difficulte` varchar(10) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recetteavalider`
--

INSERT INTO `recetteavalider` (`id`, `nom`, `description`, `grammage`, `tempsPreparation`, `difficulte`, `categorie`) VALUES
(1, 'pate aux lardons', 'des pates avec des lardons', NULL, 45, 'Moyen', 'je sais pas'),
(2, 'pate aux lardons', 'des pates avec des lardons', NULL, 0, 'Moyen', 'je sais pas'),
(3, 'djkhkdjs', 'kjdhkjlkjglrk', NULL, 0, 'Moyen', '');

-- --------------------------------------------------------

--
-- Structure de la table `ustensile`
--

DROP TABLE IF EXISTS `ustensile`;
CREATE TABLE IF NOT EXISTS `ustensile` (
  `identifiant` int NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ustensile`
--

INSERT INTO `ustensile` (`identifiant`, `libelle`) VALUES
(1, 'Poêle'),
(2, 'Mixeur'),
(3, 'Couteau'),
(4, 'Plat de cuisson'),
(5, 'Moule à gâteau');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_connexion` datetime NOT NULL,
  `role` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `mail`, `mdp`, `date_creation`, `date_connexion`, `role`) VALUES
(1, 'moi', 'm@m', 'm', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'test1', 'Testing@tesing.com', 'test1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'test2', 'Testing@tesing.com', 'TESTé', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'test3', 'test3@gmail.com', 'test3', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(12, 'test5', 'test5@gmail.com', 'test5', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(11, 'test4', 'test4@gmail.com', 'test4', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(13, 'test6', 'test6@gmail.com', 'test6', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(14, 'test7', 'test7@gmail.com', 'test7', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(15, 'test8', 'test8@gmail.com', '$2y$10$vvex6B4lhYauwPo6vEt5kONeIZY3YyAE5A/JibmJ1CIvmmgyS3PFq', '0000-00-00 00:00:00', '2024-03-10 06:10:49', 0),
(16, 'test9', 'test9@gmail.com', '$2y$10$QQg98aXdSsciZ3gbWgxCUeC0lccEb0IlpyUGpQa1qReeUAvZIZ7PW', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(17, 'azert', 'azert@gmail.com', '$2y$10$A.KonP/XJ/CBBfHqZEnKguc0Ojs4LT8wdJRMQhb.lorfQOoKxtHPO', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(18, 'test10', 'test10@gmail.com', '$2y$10$Depcg9W4P4UAF0oP4JK4..Pv7WTfuVkOGAp4dpj6CBxUWmEzZFKA.', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(19, 'test11', 'test11gmail.com', '$2y$10$JIhG2p6X0teaHtSnsdVhYeYKMkUjpxQkdgw.AelxPYYeFBIY7reNW', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(20, 'test12', 'test12gmail.com', '$2y$10$2MqzltwdLSHFuVcRgEwjoOq7.vOgKuLUGOSU7luSp6GeH7KL7ue1C', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(21, 'test13', 'test13', '$2y$10$qye/py.pI70592fP2NgkAuUUswfiXCITFqhLtjsB3PbO0bIgIOiwK', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(22, 'test14', 'test14', '$2y$10$KCIxTiHp/3OnhxE61aHsie8vY9SYeYGM/CZ3w88B4tg/o.OrcW6D2', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(23, 'test15', 'test15@gmail.com', '$2y$10$mwVgt6PkKIkcO4bz0K4tSe8VrZTNlYpB4AbKEbGzL/2V2ASCGHj.O', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(24, 'test16', 'test16@gmail.com.fr', '$2y$10$UXEo8Ukfs0XwxEfuq7YFLuwxY7nZJlk8gNhcAY2z8PpMtPBeMpXzW', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(25, 'test17', 'test17@gmail.com', '$2y$10$VI8TSuqiJ5yll0WNFxO4Wu083h6w/QCY1YW0IylolGZlZiRr6CvZy', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(26, 'npiel', 'npiel@gmail.com', '$2y$10$YHu74WXZvc0zRA3NBEHg8uVIrtMQ5G.iKf692Z/lY2pqvQRiZPkom', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(27, 'npiel', 'npiel@gmail.com', '$2y$10$XwZo2Ys4XyM3feBAvBQd1.n6GsVPyFFzi/vzmM3gtIiTRNjQN45Xy', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(28, 'test18', 'test18@gmail.com', '$2y$10$LFpzqk7TvGbaRSEug5QSg.Ga76GCFCEQgqHog4GQ8gljAFnjQ8W4W', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(29, 'test19', 'test19@gmail.com', '$2y$10$uwhwbzksLbnETnI8aRxrVusfv43FEpx0XNGKa0T6Kg9SVRNYbhggG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(30, 'test20', 'test20@gmail.com', '$2y$10$iKhzwZkAcdDJaeCDI7wzCejuMKqGTrtUBywnk.3Fdd8ZGJR8RHh5S', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(31, 'toto', 'toto@toto.fr', '$2y$10$BjXYIHfy8eSWxBJJWKYwtuw1TNLxE3UmIfdQ/DnGk8XnHMoqWlqJ6', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(32, 'root', 'root@gmail.com', '$2y$10$a/StsHod.tBHG72zhLNEB.HwS.31LT83NfzXQFoYMB6J9repYLFd6', '2024-03-10 10:10:18', '2024-03-10 10:10:33', 1),
(33, 'leo', 'leo@gmail.com', '$2y$10$zqvEPd6bZXzpv1V9I8nX4O0ED3wWP0TkeDmYy/u9UZLSEFAnVOKZq', '2024-03-12 03:19:41', '2024-03-13 02:09:12', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utiliser`
--

DROP TABLE IF EXISTS `utiliser`;
CREATE TABLE IF NOT EXISTS `utiliser` (
  `identifiantR` int NOT NULL,
  `identifiantU` int NOT NULL,
  PRIMARY KEY (`identifiantR`,`identifiantU`),
  KEY `identifiantU` (`identifiantU`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utiliser`
--

INSERT INTO `utiliser` (`identifiantR`, `identifiantU`) VALUES
(1, 1),
(4, 2),
(5, 3),
(6, 4),
(7, 5),
(8, 1),
(9, 2),
(10, 3),
(11, 4),
(12, 5),
(13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `identifiant` int NOT NULL,
  `duree` int NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`identifiant`, `duree`, `url`) VALUES
(1, 60, 'http'),
(2, 60, 'http'),
(3, 60, 'http'),
(4, 60, 'http'),
(5, 60, 'http'),
(6, 60, 'http'),
(7, 60, 'http'),
(8, 60, 'http'),
(9, 60, 'http'),
(10, 60, 'http'),
(11, 60, 'http');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
