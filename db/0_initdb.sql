-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 17 mai 2025 à 20:24
-- Version du serveur : 8.0.30
-- Version de PHP : 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cinephoria`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int NOT NULL,
  `film_id_id` int NOT NULL,
  `user_id_id` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cinemas`
--

CREATE TABLE `cinemas` (
  `id` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse1` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse2` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `technologies` json NOT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cinemas`
--

INSERT INTO `cinemas` (`id`, `nom`, `adresse1`, `adresse2`, `cp`, `ville`, `technologies`) VALUES
(1, 'Cinephoria Nantes', '8 Allée la Pérouse', NULL, '44800', 'Saint-Herblain', '[]'),
(2, 'Cinephoria Bordeaux', '23 Allée du 7ème Art', NULL, '33400', 'Talence', '[]'),
(3, 'Cinephoria Toulouse', 'Place Marcel Bouilloux-Lafont', NULL, '31400', 'Toulouse', '[]'),
(4, 'Cinephoria Paris', 'Place du Maquis du Vercors', NULL, '75020', 'Paris', '[]'),
(5, 'Cinephoria Lille', '21 Avenue de l\'Avenir', NULL, '59650', 'Villeneuve-d\'Ascq', '[]'),
(6, 'Cinephoria Charleroi', 'Grand\'Rue 141/143', NULL, '6000', 'Charleroi, Belgique', '[]'),
(7, 'Cinephoria Liège', 'Chaussée de Tongres 200', NULL, '4000', 'Liège, Belgique', '[]');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250213145248', '2025-02-23 23:00:29', 619),
('DoctrineMigrations\\Version20250219225957', '2025-02-23 23:00:30', 42),
('DoctrineMigrations\\Version20250219232454', '2025-02-23 23:00:30', 43),
('DoctrineMigrations\\Version20250219233548', '2025-02-23 23:00:30', 64),
('DoctrineMigrations\\Version20250219233643', '2025-02-23 23:00:30', 19),
('DoctrineMigrations\\Version20250219234457', '2025-02-23 23:00:30', 38),
('DoctrineMigrations\\Version20250219235723', '2025-02-23 23:00:30', 21),
('DoctrineMigrations\\Version20250225165556', '2025-02-25 16:56:07', 114),
('DoctrineMigrations\\Version20250227230520', '2025-02-28 00:05:28', 160);

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `id` int NOT NULL,
  `titre` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affiche` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` json NOT NULL COMMENT '(DC2Type:json)',
  `age_mini` int NOT NULL,
  `coup_de_coeur` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `duree` time NOT NULL,
  `date_ajout` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `realisateur` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acteurs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avertissement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `films`
--

INSERT INTO `films` (`id`, `titre`, `affiche`, `description`, `genre`, `age_mini`, `coup_de_coeur`, `score`, `duree`, `date_ajout`, `realisateur`, `acteurs`, `avertissement`) VALUES
(2, 'Sonic 3 - le film', '2024-12-25-sonic-3-le-film', 'Sonic, Knuckles et Tails se retrouvent face à un nouvel adversaire, Shadow, mystérieux et puissant ennemi aux pouvoirs inédits. Dépassée sur tous les plans, la Team Sonic va devoir former une alliance improbable pour tenter d’arrêter Shadow et protéger notre planète.', '[\"aventure\", \"animation\"]', 8, 1, NULL, '01:49:00', '2024-12-25 00:00:00', 'Jeff Fowler', 'Ben Schwartz, Idris Elba, Colleen O\'Shaughnessey', NULL),
(7, 'Paddington au Pérou', '2025-02-05-paddington-au-perou', 'Alors que Paddington rend visite à sa tante Lucy bien-aimée, qui réside désormais à la Maison des ours retraités au Pérou, la famille Brown et notre ours préféré plongent dans un voyage inattendu et plein de mystères, à travers la forêt amazonienne et jusqu\'aux sommets des montagnes du Machu Picchu.', '[\"aventure\", \"comedie\", \"famille\"]', 6, 1, NULL, '01:45:00', '2025-02-05 00:00:00', 'Dougal Wilson', 'Guillaume Gallienne, Ben Whishaw, Hugh Bonneville', NULL),
(13, 'God Save the Tuche', '2025-02-05-god-save-the-tuche', 'Les Tuche mènent à nouveau une vie paisible à Bouzolles. Mais lorsque le petit-fils de Jeff et Cathy est sélectionné pour un stage de football à Londres, c’est l’occasion rêvée pour toute la famille d’aller découvrir l’Angleterre et de rencontrer la famille royale. Entre chocs culturels et maladresses, les Tuche se retrouvent plongés au cœur de la royauté anglaise, qui n’est pas près d’oublier leur séjour !', '[\"comedie\"]', 0, NULL, NULL, '01:35:00', '2025-02-05 00:00:00', 'Jean-Paul Rouve', 'Jean-Paul Rouve, Isabelle Nanty, Claire Nadeau', NULL),
(24, 'Le Secret de Khéops', '2025-03-05-le-secret-de-kheops', 'Le trésor du pharaon Khéops a-t-il été découvert pendant la campagne d’Égypte de Napoléon, ramené en France, puis caché à Paris ? Christian Robinson, archéologue flamboyant aux méthodes peu orthodoxes, en est persuadé, depuis la découverte d’une mystérieuse inscription lors de nouvelles fouilles au Caire. Bien décidé à déchiffrer les indices laissés par Dominique Vivant Denon, le premier directeur du Louvre, Christian Robinson se lance alors dans une quête du trésor hors du commun à travers Paris, des archives poussiéreuses du Louvre jusqu’aux cabinets secrets de la Malmaison. Il embarque dans son aventure sa fille et son petit-fils, dans l’espoir insensé de réaliser à Paris la plus grande découverte archéologique du XXIe siècle…', '[\"aventure\"]', 0, NULL, NULL, '01:38:00', '2025-03-05 00:00:00', 'Barbara Schulz', 'Fabrice Luchini, Julia Piaton, Gavril Dartevelle', NULL),
(31, '100 millions !', '2025-03-26-100-millions', 'Ouvrier dans une imprimerie, Patrick est un vétéran de la lutte contre le patronat. C’est un leader syndical respecté de tous, un maestro des piquets de grève, qui porte haut les couleurs de la fraternité ouvrière et du combat contre les trop riches… Mais Patrick vient d’hériter de cent millions… Pour tout le monde - sa femme Suzanne, ses enfants, et même ses collègues - c’est l’occasion inespérée de changer de vie. Tout le monde… sauf Patrick, désormais syndicaliste multimillionnaire, mais qui n’a aucune intention de bouleverser son quotidien, et encore moins de renoncer à ses idéaux…', '[\"comedie\"]', 0, NULL, NULL, '01:37:00', '2025-03-26 00:00:00', 'Nath Dumont', 'Kad Merad, Michèle Laroque, Martin Karmann', NULL),
(32, 'Novocaine', '2025-03-26-novocaine', 'Lorsque la fille de ses rêves est kidnappée, Nate, un homme ordinaire, transforme son incapacité à ressentir la douleur en une force inattendue dans son combat pour la retrouver.', '[\"action\", \"thriller\"]', 12, NULL, NULL, '01:50:00', '2025-03-26 00:00:00', 'Dan Berk, Robert Olsen', 'Jack Quaid, Amber Midthunder, Ray Nicholson', 'Cette comédie \"gore\" enchaîne les scènes de violence qui peuvent perturber un public sensible.'),
(33, 'Les Condés', '2025-03-26-les-condes', 'À Marseille, la Police Nationale n’y arrive plus ! Le ministre de l’Intérieur décide donc de créer une brigade de super flics avec un super salaire pour motiver le plus possible les candidats. Dès le lendemain, une file interminable de profils improbables se forme devant les commissariats de la ville.\r\n\r\nParmi les postulants retenus se trouvent un menteur, un endetté, un conspirationniste, un pseudo rappeur et un raciste. Et si ces futurs Condés devenaient la meilleure chance de l’École de Police ?', '[\"comedie\"]', 0, NULL, NULL, '01:24:00', '2025-03-26 00:00:00', 'Nordine Salhi, Ryad Luc Montel', 'Nordine Salhi, Ichem Bougheraba, Arriles Amrani', NULL),
(34, 'Blanche Neige', '2025-03-19-blanche-neige', '\"Blanche-Neige\" des studios Disney est une nouvelle version du classique de 1937 en prises de vues réelles. Avec Rachel Zegler dans le rôle principal et Gal Gadot dans celui de sa belle-mère, la Méchante Reine. Cette aventure magique retourne aux sources du conte intemporel avec les adorables Timide, Prof, Simplet, Grincheux, Joyeux, Dormeur et Atchoum.', '[\"aventure\", \"fantastique\"]', 0, NULL, NULL, '01:49:00', '2025-03-19 00:00:00', 'Marc Webb', 'Rachel Zegler, Gal Gadot, Andrew Burnap', NULL),
(35, 'Les Bodin’s partent en vrille', '2025-03-26-les-bodins-partent-en-vrille', 'Quand Maria Bodin, fermière autoritaire et revêche, et son fils Christian, apprennent qu’une usine de fromage industrielle s’apprête à s’installer dans leur petit village, ils sont prêts à tout pour défendre leur fromagerie artisanale. Du Salon de l’agriculture au désert marocain, ils ne reculeront devant rien pour faire capoter ce projet d’usine : chantage, baston, courses-poursuites, une fois de plus, les Bodin’s vont braver tous les dangers pour sauver leurs valeurs et leurs traditions.', '[\"comedie\"]', 0, NULL, NULL, '01:45:00', '2025-03-26 00:00:00', 'Frédéric Forestier', 'Vincent Dubois, Jean-Christian Fraiscinet, Guillaume Clerice', NULL),
(36, 'Moon Le Panda', '2025-04-09-moon-le-panda', 'Tian a 12 ans quand il est envoyé chez sa grand-mère à cause de ses mauvais résultats à l\'école. Loin de la ville, dans les mystérieuses montagnes chinoises, il se lie d’amitié en secret avec un panda qu’il nomme Moon. C’est le début d’une incroyable aventure qui va changer à tout jamais sa vie et celle de sa famille.', '[\"aventure\", \"famille\"]', 6, 1, NULL, '01:40:00', '2025-04-09 00:00:00', 'Gilles de Maistre', 'Noé Liu Martane, Sylvia Chang, Yé Liu', NULL),
(37, 'Doux Jésus', '2025-04-09-doux-jesus', 'Sœur Lucie, religieuse dévouée, décide de fuir son couvent au bout de 20 ans pour retrouver son amour de jeunesse. C\'est pour elle le début d\'une aventure extraordinaire qui mettra sa foi à l\'épreuve et la confrontera au monde d’aujourd’hui plein de surprises et de tentations.', '[\"comedie\"]', 0, NULL, NULL, '01:26:00', '2025-04-09 00:00:00', 'Frédéric Quiring', 'Marilou Berry, Isabelle Nanty, Barbara Bolotner', NULL),
(39, 'Zion', '2025-04-09-zion', 'En Guadeloupe, Chris partage son temps entre deals, aventures sans lendemain et rodéos en moto. Repéré par Odell, le caïd du quartier voisin, Chris se voit confier une livraison à risque. Malgré la mise en garde de son meilleur ami, il accepte la mission. Mais le jour de la livraison, il découvre qu\'un bébé a été déposé devant sa porte. Commence alors pour lui, une course infernale qui le mènera à un choix crucial...', '[\"action\", \"thriller\"]', 0, NULL, NULL, '01:39:00', '2025-04-09 00:00:00', 'Nelson Foix', 'Sloan Decombes, Philippe Calodat, Zebrist', 'La tension constante du film et la présence d\'un bébé au milieu des scènes de violence sont susceptibles d\'impressionner un jeune public.'),
(40, 'The Amateur', '2025-04-09-the-amateur', 'Charlie Heller, un cryptographe de la CIA aussi brillant qu’introverti, voit son existence basculer lorsque sa femme décède durant une attaque terroriste perpétrée à Londres. Déplorant l’inaction de sa hiérarchie, il prend alors l’affaire en mains et se met à la recherche des assassins, embarquant pour un dangereux voyage partout à travers le monde pour assouvir sa vengeance.', '[\"drame\", \"thriller\"]', 0, NULL, NULL, '02:03:00', '2025-04-09 00:00:00', 'James Hawes', 'Rami Malek, Laurence Fishburne, Rachel Brosnahan', NULL),
(41, 'Piégé', '2025-04-09-piege', 'Un voleur s\'introduit dans une voiture de luxe et se retrouve piégé à l\'intérieur. Il découvre que son énigmatique propriétaire en a le contrôle total et qu’il va exercer sur lui une vengeance diabolique.', '[\"action\", \"thriller\"]', 12, NULL, NULL, '01:35:00', '2025-04-09 00:00:00', 'David Yarovesky', 'Bill Skarsgård, Anthony Hopkins, Ashley Cartwright', 'Certaines scènes particulièrement violentes peuvent perturber un jeune public.'),
(42, 'Rapide', '2025-04-16-rapide', 'Max a toujours aimé aller vite. Elle ne sait pas faire autrement. Alors quand elle découvre le karting, c’est une évidence : elle sera championne de F1. Les compétitions juniors s’enchainent, les victoires aussi. Pourtant, à 17 ans, aucune écurie ne la retient. Sa faute principale : être une jeune femme dans un sport d’hommes. Face à ce monde qui lui tourne le dos, seul un ancien pilote de deuxième zone totalement fantasque croit encore en son potentiel. Un seul but : faire de Max la plus rapide.', '[\"action\", \"comedie\"]', 0, NULL, NULL, '01:38:00', '2025-04-16 00:00:00', 'Morgan S. Dalibert', 'Paola Locatelli, Alban Lenoir, Anne Marivin', NULL),
(43, 'Aimons-nous vivants', '2025-04-16-aimons-nous-vivants', 'Dans le train pour Genève, Victoire, une passagère envahissante, croise Antoine Toussaint, son idole, une grande vedette de la chanson française.\n\nEntre lui, au bout du rouleau, et elle, débordante d’énergie, la rencontre sera explosive…', '[\"comedie\", \"romance\"]', 0, NULL, NULL, '01:30:00', '2025-04-16 00:00:00', 'Jean-Pierre Améris', 'Gérard Darmon, Valérie Lemercier, Patrick Timsit', NULL),
(44, 'Des jours meilleurs', '2025-04-23-des-jours-meilleurs', 'A la suite d’un accident de voiture, Suzanne perd la garde de ses trois enfants. Elle n’a plus le choix et doit se soigner dans un centre pour alcooliques. A peine arrivée, elle y rencontre Alice et Diane, deux femmes au caractère bien trempé… Denis, éducateur sportif, va tenter de les réunir autour du même objectif : participer au rallye des Dunes dans le désert marocain. Il devra s’armer de beaucoup de patience et de pédagogie pour préparer cet improbable équipage à atteindre son objectif.', '[\"comedie_dramatique\"]', 0, NULL, NULL, '01:43:00', '2025-04-23 00:00:00', 'Elsa Bennett, Hippolyte Dard', 'Valérie Bonneton, Michèle Laroque, Sabrina Ouazani', NULL),
(45, 'La Légende d\'Ochi', '2025-04-23-la-legende-dochi', 'Dans un village isolé des Carpates, Yuri, une jeune fille élevée dans la crainte des mystérieuses créatures de la forêt appelées Ochis, se voit interdire de sortir après la tombée de la nuit. Un jour, elle découvre un bébé Ochi abandonné par sa meute. Déterminée à le ramener auprès des siens, Yuri va défier les interdits et s’engage dans une aventure extraordinaire au cœur des secrets de la forêt.', '[\"aventure\", \"famille\", \"fantastique\"]', 8, 1, NULL, '01:35:00', '2025-04-23 00:00:00', 'Isaiah Saxon', 'Helena Zengel, Willem Dafoe, Emily Watson', NULL),
(46, 'Drop Game', '2025-04-23-drop-game', 'Violet, une jeune veuve qui pour son premier rendez-vous depuis des années, se rend dans un restaurant très chic où celui qu’elle doit y retrouver, Henry, est encore plus charmant que séduisant. Mais leur alchimie naissante va vite être gâchée quand Violet se voit harcelée puis terrorisée par une série de messages anonymes sur son téléphone. Contrainte au silence, elle doit suivre les instructions qu’elle reçoit, sous peine que la silhouette encapuchonnée des caméras de sécurité de sa propre maison ne tue son jeune fils gardé par sa tante, la sœur de Violet. Si elle ne fait pas exactement ce qui lui est ordonné, ceux qu\'elle aime le plus mourront.', '[\"thriller\"]', 0, NULL, NULL, '01:40:00', '2025-04-23 00:00:00', 'Christopher Landon', 'Meghann Fahy, Brandon Sklenar, Violett Beane', 'L\'ambiance angoissante du film qui met en jeu la vie d\'un enfant très jeune et la scène d\'ouverture récurrente de violences conjugales sont susceptibles d\'impressionner un jeune public.'),
(47, 'De mauvaise foi', '2025-05-07-de-mauvaise-foi', 'Un notaire vieille France doit impérativement sauver son château délabré et empêcher le mariage de sa fille avec un golden boy prétentieux. La fortune promise par une comtesse mourante à un jeune artiste bohème, pourrait régler tous ses problèmes. À condition que le futur héritier devienne un bon catholique, et tombe amoureux de la jolie fiancée.', '[\"comedie\"]', 0, 1, NULL, '01:34:00', '2025-05-07 00:00:00', 'Albéric Saint-Martin', 'Pascal Demolon, Philippe Duquesne, Herrade Von Meier', NULL),
(48, 'Anges & Cie', '2025-05-07-anges-cie', 'Nous ne pouvons pas les voir. Ils sont toujours à nos côtés sans que nous le sachions. Ce sont nos protecteurs et nos guides... Bienvenue dans le monde des anges gardiens ! Paul et Léa n’auraient jamais dû se rencontrer. Mais depuis, ils sont irrésistiblement attirés l’un par l’autre. Raphaëlle et Gabriel, deux anges que tout oppose, sont obligés de faire équipe pour tout remettre en ordre et empêcher ces deux humains de tomber amoureux. Si les anges échouent, Raphaëlle l’ambitieuse pourra dire adieu à sa promotion d’Archange. Quant à Gabriel le fumiste, il sera déchu et devra passer l’éternité sur Terre. L’enfer…', '[\"comedie\"]', 0, NULL, NULL, '01:31:00', '2025-05-07 00:00:00', 'Vladimir Rodionov', 'Élodie Fontan, Romain Lancry, Shirine Boutella', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `id` int NOT NULL,
  `cinema_id_id` int NOT NULL,
  `places` int NOT NULL,
  `technologies` json NOT NULL COMMENT '(DC2Type:json)',
  `salle_nom` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`id`, `cinema_id_id`, `places`, `technologies`, `salle_nom`) VALUES
(1, 1, 168, '[\"imax\", \"3d\"]', 'Salle IMAX'),
(2, 1, 96, '[\"4dx-ice\", \"3d\"]', 'Salle ICE - 4DX'),
(3, 1, 80, '[\"onyx\", \"3d\"]', 'Salle Onyx'),
(4, 2, 168, '[\"imax\", \"3d\"]', 'Salle IMAX'),
(5, 2, 96, '[\"4dx-ice\", \"3d\"]', 'Salle ICE - 4DX'),
(6, 2, 80, '[\"onyx\", \"3d\"]', 'Salle Onyx'),
(7, 3, 168, '[\"imax\", \"3d\"]', 'Salle IMAX'),
(8, 3, 96, '[\"4dx-ice\", \"3d\"]', 'Salle ICE - 4DX'),
(9, 3, 80, '[\"onyx\", \"3d\"]', 'Salle Onyx'),
(10, 4, 168, '[\"imax\", \"3d\"]', 'Salle IMAX'),
(11, 4, 96, '[\"4dx-ice\", \"3d\"]', 'Salle ICE - 4DX'),
(12, 4, 80, '[\"onyx\", \"3d\"]', 'Salle Onyx'),
(13, 5, 168, '[\"imax\", \"3d\"]', 'Salle IMAX'),
(14, 5, 96, '[\"4dx-ice\", \"3d\"]', 'Salle ICE - 4DX'),
(15, 5, 80, '[\"onyx\", \"3d\"]', 'Salle Onyx'),
(16, 6, 168, '[\"imax\", \"3d\"]', 'Salle IMAX'),
(17, 6, 96, '[\"4dx-ice\", \"3d\"]', 'Salle ICE - 4DX'),
(18, 6, 80, '[\"onyx\", \"3d\"]', 'Salle Onyx'),
(19, 7, 168, '[\"imax\", \"3d\"]', 'Salle IMAX'),
(20, 7, 96, '[\"4dx-ice\", \"3d\"]', 'Salle ICE - 4DX'),
(21, 7, 80, '[\"onyx\", \"3d\"]', 'Salle Onyx'),
(22, 1, 144, '[\"3d\"]', 'Salle 4'),
(23, 1, 120, '[\"3d\"]', 'Salle 5'),
(24, 2, 144, '[\"3d\"]', 'Salle 4'),
(25, 2, 120, '[\"3d\"]', 'Salle 5'),
(26, 3, 144, '[\"3d\"]', 'Salle 4'),
(27, 3, 120, '[\"3d\"]', 'Salle 5'),
(28, 4, 144, '[\"3d\"]', 'Salle 4'),
(29, 4, 120, '[\"3d\"]', 'Salle 5'),
(30, 5, 144, '[\"3d\"]', 'Salle 4'),
(31, 5, 120, '[\"3d\"]', 'Salle 5'),
(32, 6, 144, '[\"3d\"]', 'Salle 4'),
(33, 6, 120, '[\"3d\"]', 'Salle 5'),
(34, 7, 144, '[\"3d\"]', 'Salle 4'),
(35, 7, 120, '[\"3d\"]', 'Salle 5');

-- --------------------------------------------------------

--
-- Structure de la table `seances`
--

CREATE TABLE `seances` (
  `id` int NOT NULL,
  `film_id_id` int NOT NULL,
  `salle_id_id` int NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `cinema_id` int NOT NULL,
  `technologies` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seances`
--

INSERT INTO `seances` (`id`, `film_id_id`, `salle_id_id`, `date_debut`, `date_fin`, `cinema_id`, `technologies`) VALUES
(2, 2, 2, '2025-03-05 20:00:00', '2025-03-05 21:59:00', 1, NULL),
(9, 2, 2, '2025-03-06 10:00:00', '2025-03-06 11:59:00', 1, NULL),
(10, 7, 2, '2025-03-06 13:00:00', '2025-03-06 14:55:00', 1, NULL),
(24, 13, 3, '2025-03-06 20:00:00', '2025-03-06 21:45:00', 1, NULL),
(27, 2, 2, '2025-03-07 10:00:00', '2025-03-07 11:59:00', 1, NULL),
(28, 7, 2, '2025-03-07 13:00:00', '2025-03-07 14:55:00', 1, NULL),
(42, 13, 3, '2025-03-07 20:00:00', '2025-03-07 21:45:00', 1, NULL),
(45, 2, 2, '2025-03-08 10:00:00', '2025-03-08 11:59:00', 1, NULL),
(46, 7, 2, '2025-03-08 13:00:00', '2025-03-08 14:55:00', 1, NULL),
(60, 13, 3, '2025-03-08 20:00:00', '2025-03-08 21:45:00', 1, NULL),
(63, 2, 2, '2025-03-09 10:00:00', '2025-03-09 11:59:00', 1, NULL),
(64, 7, 2, '2025-03-09 13:00:00', '2025-03-09 14:55:00', 1, NULL),
(78, 13, 3, '2025-03-09 20:00:00', '2025-03-09 21:45:00', 1, NULL),
(81, 2, 2, '2025-03-10 10:00:00', '2025-03-10 11:59:00', 1, NULL),
(82, 7, 2, '2025-03-10 13:00:00', '2025-03-10 14:55:00', 1, NULL),
(96, 13, 3, '2025-03-10 20:00:00', '2025-03-10 21:45:00', 1, NULL),
(99, 2, 2, '2025-03-11 10:00:00', '2025-03-11 11:59:00', 1, NULL),
(100, 7, 2, '2025-03-11 13:00:00', '2025-03-11 14:55:00', 1, NULL),
(114, 13, 3, '2025-03-11 20:00:00', '2025-03-11 21:45:00', 1, NULL),
(117, 2, 5, '2025-03-05 20:00:00', '2025-03-05 21:59:00', 2, NULL),
(124, 2, 5, '2025-03-06 10:00:00', '2025-03-06 11:59:00', 2, NULL),
(125, 7, 5, '2025-03-06 13:00:00', '2025-03-06 14:55:00', 2, NULL),
(139, 13, 6, '2025-03-06 20:00:00', '2025-03-06 21:45:00', 2, NULL),
(142, 2, 5, '2025-03-07 10:00:00', '2025-03-07 11:59:00', 2, NULL),
(143, 7, 5, '2025-03-07 13:00:00', '2025-03-07 14:55:00', 2, NULL),
(157, 13, 6, '2025-03-07 20:00:00', '2025-03-07 21:45:00', 2, NULL),
(160, 2, 5, '2025-03-08 10:00:00', '2025-03-08 11:59:00', 2, NULL),
(161, 7, 5, '2025-03-08 13:00:00', '2025-03-08 14:55:00', 2, NULL),
(175, 13, 6, '2025-03-08 20:00:00', '2025-03-08 21:45:00', 2, NULL),
(178, 2, 5, '2025-03-09 10:00:00', '2025-03-09 11:59:00', 2, NULL),
(179, 7, 5, '2025-03-09 13:00:00', '2025-03-09 14:55:00', 2, NULL),
(193, 13, 6, '2025-03-09 20:00:00', '2025-03-09 21:45:00', 2, NULL),
(196, 2, 5, '2025-03-10 10:00:00', '2025-03-10 11:59:00', 2, NULL),
(197, 7, 5, '2025-03-10 13:00:00', '2025-03-10 14:55:00', 2, NULL),
(211, 13, 6, '2025-03-10 20:00:00', '2025-03-10 21:45:00', 2, NULL),
(214, 2, 5, '2025-03-11 10:00:00', '2025-03-11 11:59:00', 2, NULL),
(215, 7, 5, '2025-03-11 13:00:00', '2025-03-11 14:55:00', 2, NULL),
(229, 13, 6, '2025-03-11 20:00:00', '2025-03-11 21:45:00', 2, NULL),
(232, 2, 8, '2025-03-05 20:00:00', '2025-03-05 21:59:00', 3, NULL),
(239, 2, 8, '2025-03-06 10:00:00', '2025-03-06 11:59:00', 3, NULL),
(240, 7, 8, '2025-03-06 13:00:00', '2025-03-06 14:55:00', 3, NULL),
(254, 13, 9, '2025-03-06 20:00:00', '2025-03-06 21:45:00', 3, NULL),
(257, 2, 8, '2025-03-07 10:00:00', '2025-03-07 11:59:00', 3, NULL),
(258, 7, 8, '2025-03-07 13:00:00', '2025-03-07 14:55:00', 3, NULL),
(272, 13, 9, '2025-03-07 20:00:00', '2025-03-07 21:45:00', 3, NULL),
(275, 2, 8, '2025-03-08 10:00:00', '2025-03-08 11:59:00', 3, NULL),
(276, 7, 8, '2025-03-08 13:00:00', '2025-03-08 14:55:00', 3, NULL),
(290, 13, 9, '2025-03-08 20:00:00', '2025-03-08 21:45:00', 3, NULL),
(293, 2, 8, '2025-03-09 10:00:00', '2025-03-09 11:59:00', 3, NULL),
(294, 7, 8, '2025-03-09 13:00:00', '2025-03-09 14:55:00', 3, NULL),
(308, 13, 9, '2025-03-09 20:00:00', '2025-03-09 21:45:00', 3, NULL),
(311, 2, 8, '2025-03-10 10:00:00', '2025-03-10 11:59:00', 3, NULL),
(312, 7, 8, '2025-03-10 13:00:00', '2025-03-10 14:55:00', 3, NULL),
(326, 13, 9, '2025-03-10 20:00:00', '2025-03-10 21:45:00', 3, NULL),
(329, 2, 8, '2025-03-11 10:00:00', '2025-03-11 11:59:00', 3, NULL),
(330, 7, 8, '2025-03-11 13:00:00', '2025-03-11 14:55:00', 3, NULL),
(344, 13, 9, '2025-03-11 20:00:00', '2025-03-11 21:45:00', 3, NULL),
(577, 2, 11, '2025-03-05 20:00:00', '2025-03-05 21:59:00', 4, NULL),
(584, 2, 11, '2025-03-06 10:00:00', '2025-03-06 11:59:00', 4, NULL),
(585, 7, 11, '2025-03-06 13:00:00', '2025-03-06 14:55:00', 4, NULL),
(602, 2, 11, '2025-03-07 10:00:00', '2025-03-07 11:59:00', 4, NULL),
(603, 7, 11, '2025-03-07 13:00:00', '2025-03-07 14:55:00', 4, NULL),
(620, 2, 11, '2025-03-08 10:00:00', '2025-03-08 11:59:00', 4, NULL),
(621, 7, 11, '2025-03-08 13:00:00', '2025-03-08 14:55:00', 4, NULL),
(638, 2, 11, '2025-03-09 10:00:00', '2025-03-09 11:59:00', 4, NULL),
(639, 7, 11, '2025-03-09 13:00:00', '2025-03-09 14:55:00', 4, NULL),
(656, 2, 11, '2025-03-10 10:00:00', '2025-03-10 11:59:00', 4, NULL),
(657, 7, 11, '2025-03-10 13:00:00', '2025-03-10 14:55:00', 4, NULL),
(674, 2, 11, '2025-03-11 10:00:00', '2025-03-11 11:59:00', 4, NULL),
(675, 7, 11, '2025-03-11 13:00:00', '2025-03-11 14:55:00', 4, NULL),
(692, 2, 14, '2025-03-05 20:00:00', '2025-03-05 21:59:00', 5, NULL),
(699, 2, 14, '2025-03-06 10:00:00', '2025-03-06 11:59:00', 5, NULL),
(700, 7, 14, '2025-03-06 13:00:00', '2025-03-06 14:55:00', 5, NULL),
(714, 13, 15, '2025-03-06 20:00:00', '2025-03-06 21:45:00', 5, NULL),
(717, 2, 14, '2025-03-07 10:00:00', '2025-03-07 11:59:00', 5, NULL),
(718, 7, 14, '2025-03-07 13:00:00', '2025-03-07 14:55:00', 5, NULL),
(732, 13, 15, '2025-03-07 20:00:00', '2025-03-07 21:45:00', 5, NULL),
(735, 2, 14, '2025-03-08 10:00:00', '2025-03-08 11:59:00', 5, NULL),
(736, 7, 14, '2025-03-08 13:00:00', '2025-03-08 14:55:00', 5, NULL),
(750, 13, 15, '2025-03-08 20:00:00', '2025-03-08 21:45:00', 5, NULL),
(753, 2, 14, '2025-03-09 10:00:00', '2025-03-09 11:59:00', 5, NULL),
(754, 7, 14, '2025-03-09 13:00:00', '2025-03-09 14:55:00', 5, NULL),
(768, 13, 15, '2025-03-09 20:00:00', '2025-03-09 21:45:00', 5, NULL),
(771, 2, 14, '2025-03-10 10:00:00', '2025-03-10 11:59:00', 5, NULL),
(772, 7, 14, '2025-03-10 13:00:00', '2025-03-10 14:55:00', 5, NULL),
(786, 13, 15, '2025-03-10 20:00:00', '2025-03-10 21:45:00', 5, NULL),
(789, 2, 14, '2025-03-11 10:00:00', '2025-03-11 11:59:00', 5, NULL),
(790, 7, 14, '2025-03-11 13:00:00', '2025-03-11 14:55:00', 5, NULL),
(804, 13, 15, '2025-03-11 20:00:00', '2025-03-11 21:45:00', 5, NULL),
(807, 2, 17, '2025-03-05 20:00:00', '2025-03-05 21:59:00', 6, NULL),
(814, 2, 17, '2025-03-06 10:00:00', '2025-03-06 11:59:00', 6, NULL),
(815, 7, 17, '2025-03-06 13:00:00', '2025-03-06 14:55:00', 6, NULL),
(829, 13, 18, '2025-03-06 20:00:00', '2025-03-06 21:45:00', 6, NULL),
(832, 2, 17, '2025-03-07 10:00:00', '2025-03-07 11:59:00', 6, NULL),
(833, 7, 17, '2025-03-07 13:00:00', '2025-03-07 14:55:00', 6, NULL),
(847, 13, 18, '2025-03-07 20:00:00', '2025-03-07 21:45:00', 6, NULL),
(850, 2, 17, '2025-03-08 10:00:00', '2025-03-08 11:59:00', 6, NULL),
(851, 7, 17, '2025-03-08 13:00:00', '2025-03-08 14:55:00', 6, NULL),
(865, 13, 18, '2025-03-08 20:00:00', '2025-03-08 21:45:00', 6, NULL),
(868, 2, 17, '2025-03-09 10:00:00', '2025-03-09 11:59:00', 6, NULL),
(869, 7, 17, '2025-03-09 13:00:00', '2025-03-09 14:55:00', 6, NULL),
(883, 13, 18, '2025-03-09 20:00:00', '2025-03-09 21:45:00', 6, NULL),
(886, 2, 17, '2025-03-10 10:00:00', '2025-03-10 11:59:00', 6, NULL),
(887, 7, 17, '2025-03-10 13:00:00', '2025-03-10 14:55:00', 6, NULL),
(901, 13, 18, '2025-03-10 20:00:00', '2025-03-10 21:45:00', 6, NULL),
(904, 2, 17, '2025-03-11 10:00:00', '2025-03-11 11:59:00', 6, NULL),
(905, 7, 17, '2025-03-11 13:00:00', '2025-03-11 14:55:00', 6, NULL),
(919, 13, 18, '2025-03-11 20:00:00', '2025-03-11 21:45:00', 6, NULL),
(922, 2, 20, '2025-03-05 20:00:00', '2025-03-05 21:59:00', 7, NULL),
(929, 2, 20, '2025-03-06 10:00:00', '2025-03-06 11:59:00', 7, NULL),
(930, 7, 20, '2025-03-06 13:00:00', '2025-03-06 14:55:00', 7, NULL),
(944, 13, 21, '2025-03-06 20:00:00', '2025-03-06 21:45:00', 7, NULL),
(947, 2, 20, '2025-03-07 10:00:00', '2025-03-07 11:59:00', 7, NULL),
(948, 7, 20, '2025-03-07 13:00:00', '2025-03-07 14:55:00', 7, NULL),
(962, 13, 21, '2025-03-07 20:00:00', '2025-03-07 21:45:00', 7, NULL),
(965, 2, 20, '2025-03-08 10:00:00', '2025-03-08 11:59:00', 7, NULL),
(966, 7, 20, '2025-03-08 13:00:00', '2025-03-08 14:55:00', 7, NULL),
(980, 13, 21, '2025-03-08 20:00:00', '2025-03-08 21:45:00', 7, NULL),
(983, 2, 20, '2025-03-09 10:00:00', '2025-03-09 11:59:00', 7, NULL),
(984, 7, 20, '2025-03-09 13:00:00', '2025-03-09 14:55:00', 7, NULL),
(998, 13, 21, '2025-03-09 20:00:00', '2025-03-09 21:45:00', 7, NULL),
(1001, 2, 20, '2025-03-10 10:00:00', '2025-03-10 11:59:00', 7, NULL),
(1002, 7, 20, '2025-03-10 13:00:00', '2025-03-10 14:55:00', 7, NULL),
(1016, 13, 21, '2025-03-10 20:00:00', '2025-03-10 21:45:00', 7, NULL),
(1019, 2, 20, '2025-03-11 10:00:00', '2025-03-11 11:59:00', 7, NULL),
(1020, 7, 20, '2025-03-11 13:00:00', '2025-03-11 14:55:00', 7, NULL),
(1034, 13, 21, '2025-03-11 20:00:00', '2025-03-11 21:45:00', 7, NULL),
(1047, 24, 1, '2025-03-08 12:20:00', '2025-03-08 14:08:00', 1, '[\"\"]'),
(1048, 24, 3, '2025-03-08 15:20:00', '2025-03-08 17:08:00', 1, '[\"\"]'),
(1051, 24, 23, '2025-03-08 19:30:00', '2025-03-08 21:18:00', 1, '[\"\"]'),
(1052, 24, 23, '2025-03-08 21:40:00', '2025-03-08 23:28:00', 1, '[\"\"]'),
(1056, 7, 23, '2025-03-08 10:00:00', '2025-03-08 11:55:00', 1, '[\"\"]'),
(1058, 13, 3, '2025-03-08 22:00:00', '2025-03-08 23:45:00', 1, '[\"\"]'),
(1059, 31, 1, '2025-03-27 10:30:00', '2025-03-27 12:17:00', 1, '[\"IMAX\"]'),
(1060, 31, 1, '2025-03-27 13:00:00', '2025-03-27 14:47:00', 1, '[\"IMAX\"]'),
(1062, 31, 1, '2025-03-27 18:00:00', '2025-03-27 19:47:00', 1, '[\"IMAX\"]'),
(1063, 31, 1, '2025-03-27 20:30:00', '2025-03-27 22:17:00', 1, '[\"IMAX\"]'),
(1064, 32, 2, '2025-03-27 10:30:00', '2025-03-27 12:30:00', 1, '[\"IMAX\"]'),
(1065, 32, 2, '2025-03-27 13:00:00', '2025-03-27 15:00:00', 1, '[\"IMAX\"]'),
(1066, 32, 2, '2025-03-27 15:30:00', '2025-03-27 17:30:00', 1, '[\"IMAX\"]'),
(1068, 32, 2, '2025-03-27 20:30:00', '2025-03-27 22:30:00', 1, '[\"IMAX\"]'),
(1069, 33, 22, '2025-03-27 10:00:00', '2025-03-27 11:34:00', 1, '[\"IMAX\"]'),
(1070, 34, 3, '2025-03-27 10:30:00', '2025-03-27 12:29:00', 1, '[\"IMAX\"]'),
(1071, 34, 3, '2025-03-27 13:00:00', '2025-03-27 14:59:00', 1, '[\"IMAX\"]'),
(1072, 34, 3, '2025-03-27 20:30:00', '2025-03-27 22:29:00', 1, '[\"IMAX\"]'),
(1076, 35, 22, '2025-03-27 12:00:00', '2025-03-27 13:55:00', 1, '[\"IMAX\"]'),
(1077, 35, 22, '2025-03-27 14:30:00', '2025-03-27 16:25:00', 1, '[\"IMAX\"]'),
(1080, 24, 22, '2025-03-27 21:10:00', '2025-03-27 22:58:00', 1, '[\"IMAX\"]'),
(1084, 33, 23, '2025-03-27 16:40:00', '2025-03-27 18:14:00', 1, '[\"IMAX\"]'),
(1085, 13, 23, '2025-03-27 18:30:00', '2025-03-27 20:15:00', 1, '[\"IMAX\"]'),
(1088, 31, 1, '2025-03-28 10:20:00', '2025-03-28 12:07:00', 1, '[\"IMAX\"]'),
(1089, 31, 1, '2025-03-28 12:20:00', '2025-03-28 14:07:00', 1, '[\"IMAX\"]'),
(1090, 31, 1, '2025-03-28 14:20:00', '2025-03-28 16:07:00', 1, '[\"IMAX\"]'),
(1093, 31, 1, '2025-03-28 21:00:00', '2025-03-28 22:47:00', 1, '[\"IMAX\"]'),
(1094, 32, 2, '2025-03-28 10:20:00', '2025-03-28 12:20:00', 1, '[\"4DX\"]'),
(1095, 32, 2, '2025-03-28 12:40:00', '2025-03-28 14:40:00', 1, '[\"4DX\"]'),
(1096, 32, 2, '2025-03-28 15:00:00', '2025-03-28 17:00:00', 1, '[\"4DX\"]'),
(1098, 7, 2, '2025-03-28 20:00:00', '2025-03-28 21:55:00', 1, '[\"4DX\"]'),
(1100, 34, 3, '2025-03-28 10:20:00', '2025-03-28 12:19:00', 1, '[\"ONYX\"]'),
(1101, 34, 3, '2025-03-28 12:30:00', '2025-03-28 14:29:00', 1, '[\"ONYX\"]'),
(1103, 24, 3, '2025-03-28 17:20:00', '2025-03-28 19:08:00', 1, '[\"ONYX\"]'),
(1104, 34, 3, '2025-03-28 19:20:00', '2025-03-28 21:19:00', 1, '[\"ONYX\"]'),
(1105, 34, 3, '2025-03-28 21:30:00', '2025-03-28 23:29:00', 1, '[\"ONYX\"]'),
(1106, 33, 22, '2025-03-28 10:20:00', '2025-03-28 11:54:00', 1, '[\"\"]'),
(1107, 33, 22, '2025-03-28 12:10:00', '2025-03-28 13:44:00', 1, '[\"\"]'),
(1109, 33, 22, '2025-03-28 15:50:00', '2025-03-28 17:24:00', 1, '[\"\"]'),
(1111, 33, 22, '2025-03-28 20:00:00', '2025-03-28 21:34:00', 1, '[\"\"]'),
(1112, 33, 22, '2025-03-28 22:00:00', '2025-03-28 23:34:00', 1, '[\"\"]'),
(1113, 35, 23, '2025-03-28 10:20:00', '2025-03-28 12:15:00', 1, '[\"\"]'),
(1114, 35, 23, '2025-03-28 12:30:00', '2025-03-28 14:25:00', 1, '[\"\"]'),
(1115, 13, 23, '2025-03-28 14:40:00', '2025-03-28 16:25:00', 1, '[\"\"]'),
(1116, 13, 23, '2025-03-28 16:40:00', '2025-03-28 18:25:00', 1, '[\"\"]'),
(1117, 35, 23, '2025-03-28 18:40:00', '2025-03-28 20:35:00', 1, '[\"\"]'),
(1118, 13, 23, '2025-03-28 20:50:00', '2025-03-28 22:35:00', 1, '[\"\"]'),
(1119, 34, 23, '2025-03-29 10:00:00', '2025-03-29 11:59:00', 1, '[\"\"]'),
(1125, 24, 22, '2025-03-29 18:50:00', '2025-03-29 20:38:00', 1, '[\"\"]'),
(1126, 35, 22, '2025-03-29 21:00:00', '2025-03-29 22:55:00', 1, '[\"\"]'),
(1129, 33, 23, '2025-03-29 19:30:00', '2025-03-29 21:04:00', 1, '[\"\"]'),
(1130, 33, 23, '2025-03-29 21:30:00', '2025-03-29 23:04:00', 1, '[\"\"]'),
(1131, 2, 2, '2025-03-29 10:00:00', '2025-03-29 11:59:00', 1, '[\"4DX\"]'),
(1132, 7, 2, '2025-03-29 12:30:00', '2025-03-29 14:25:00', 1, '[\"4DX\"]'),
(1134, 32, 2, '2025-03-29 17:30:00', '2025-03-29 19:30:00', 1, '[\"4DX\"]'),
(1137, 13, 1, '2025-03-29 12:30:00', '2025-03-29 14:15:00', 1, '[\"IMAX\"]'),
(1138, 31, 1, '2025-03-29 14:40:00', '2025-03-29 16:27:00', 1, '[\"IMAX\"]'),
(1139, 34, 1, '2025-03-29 17:00:00', '2025-03-29 18:59:00', 1, '[\"IMAX\"]'),
(1140, 34, 1, '2025-03-29 19:20:00', '2025-03-29 21:19:00', 1, '[\"IMAX\"]'),
(1141, 32, 1, '2025-03-29 21:30:00', '2025-03-29 23:30:00', 1, '[\"IMAX\"]'),
(1142, 7, 3, '2025-03-29 10:00:00', '2025-03-29 11:55:00', 1, '[\"ONYX\"]'),
(1144, 24, 3, '2025-03-29 15:20:00', '2025-03-29 17:08:00', 1, '[\"ONYX\"]'),
(1146, 34, 3, '2025-03-29 20:00:00', '2025-03-29 21:59:00', 1, '[\"3D\"]'),
(1148, 2, 1, '2025-04-28 10:00:00', '2025-04-28 11:59:00', 1, '[\"\"]'),
(1149, 2, 1, '2025-04-28 12:30:00', '2025-04-28 14:29:00', 1, '[\"3D\"]'),
(1150, 7, 1, '2025-04-28 15:00:00', '2025-04-28 16:55:00', 1, '[\"3D\"]'),
(1151, 7, 2, '2025-04-28 10:00:00', '2025-04-28 11:55:00', 1, '[\"\"]'),
(1152, 2, 1, '2025-04-29 10:00:00', '2025-04-29 11:59:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1153, 2, 1, '2025-04-29 12:20:00', '2025-04-29 14:19:00', 1, '[[[[[[[\"3D\"]]]]]]]'),
(1155, 7, 2, '2025-04-29 10:00:00', '2025-04-29 11:55:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1156, 45, 2, '2025-04-29 12:20:00', '2025-04-29 14:05:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1158, 7, 1, '2025-04-29 14:50:00', '2025-04-29 16:45:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1160, 13, 1, '2025-04-29 19:20:00', '2025-04-29 21:05:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1165, 2, 2, '2025-04-29 14:50:00', '2025-04-29 16:49:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1166, 45, 2, '2025-04-29 17:10:00', '2025-04-29 18:55:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1167, 42, 2, '2025-04-29 19:20:00', '2025-04-29 21:08:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1168, 45, 2, '2025-04-29 21:30:00', '2025-04-29 23:15:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1169, 2, 3, '2025-04-29 12:20:00', '2025-04-29 14:19:00', 1, '[[[[[[[\"3D\"]]]]]]]'),
(1170, 45, 3, '2025-04-29 19:20:00', '2025-04-29 21:05:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1171, 13, 3, '2025-04-29 17:00:00', '2025-04-29 18:45:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1172, 36, 3, '2025-04-29 10:00:00', '2025-04-29 11:50:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1173, 39, 22, '2025-04-29 12:20:00', '2025-04-29 14:09:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1174, 40, 3, '2025-04-29 21:30:00', '2025-04-29 23:43:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1175, 44, 22, '2025-04-29 14:50:00', '2025-04-29 16:43:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1176, 44, 22, '2025-04-29 17:10:00', '2025-04-29 19:03:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1177, 42, 1, '2025-04-29 21:30:00', '2025-04-29 23:18:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1178, 42, 3, '2025-04-29 14:50:00', '2025-04-29 16:38:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1179, 43, 22, '2025-04-29 10:00:00', '2025-04-29 11:40:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1180, 41, 22, '2025-04-29 22:00:00', '2025-04-29 23:45:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1181, 46, 23, '2025-04-29 17:00:00', '2025-04-29 18:50:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1182, 46, 23, '2025-04-29 19:20:00', '2025-04-29 21:10:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1183, 43, 23, '2025-04-29 14:50:00', '2025-04-29 16:30:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1184, 37, 23, '2025-04-29 12:40:00', '2025-04-29 14:16:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1185, 31, 23, '2025-04-29 21:40:00', '2025-04-29 23:27:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1186, 24, 23, '2025-04-29 10:00:00', '2025-04-29 11:48:00', 1, '[[[[[[[\"\"]]]]]]]'),
(1187, 24, 1, '2025-04-29 17:10:00', '2025-04-29 18:58:00', 1, '[[[\"\"]]]'),
(1189, 32, 22, '2025-04-29 19:30:00', '2025-04-29 21:30:00', 1, '[[[\"\"]]]');

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

CREATE TABLE `tarifs` (
  `id` int NOT NULL,
  `cinema_id_id` int NOT NULL,
  `tarif_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8F91ABF0E6286007` (`film_id_id`),
  ADD KEY `IDX_8F91ABF09D86650F` (`user_id_id`);

--
-- Index pour la table `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_799D45AAF4CB0151` (`cinema_id_id`);

--
-- Index pour la table `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FC699FF1E6286007` (`film_id_id`),
  ADD KEY `IDX_FC699FF192419D3E` (`salle_id_id`);

--
-- Index pour la table `tarifs`
--
ALTER TABLE `tarifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F9B8C496F4CB0151` (`cinema_id_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `seances`
--
ALTER TABLE `seances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1190;

--
-- AUTO_INCREMENT pour la table `tarifs`
--
ALTER TABLE `tarifs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `FK_8F91ABF09D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_8F91ABF0E6286007` FOREIGN KEY (`film_id_id`) REFERENCES `films` (`id`);

--
-- Contraintes pour la table `salles`
--
ALTER TABLE `salles`
  ADD CONSTRAINT `FK_799D45AAF4CB0151` FOREIGN KEY (`cinema_id_id`) REFERENCES `cinemas` (`id`);

--
-- Contraintes pour la table `seances`
--
ALTER TABLE `seances`
  ADD CONSTRAINT `FK_FC699FF192419D3E` FOREIGN KEY (`salle_id_id`) REFERENCES `salles` (`id`),
  ADD CONSTRAINT `FK_FC699FF1E6286007` FOREIGN KEY (`film_id_id`) REFERENCES `films` (`id`);

--
-- Contraintes pour la table `tarifs`
--
ALTER TABLE `tarifs`
  ADD CONSTRAINT `FK_F9B8C496F4CB0151` FOREIGN KEY (`cinema_id_id`) REFERENCES `cinemas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
