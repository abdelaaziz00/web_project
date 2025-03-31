-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 29 mars 2025 à 00:19
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
-- Base de données : `prof_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `ID_ANNONCE` int(11) NOT NULL,
  `ID_COUR` int(11) NOT NULL,
  `TITRE` varchar(200) DEFAULT NULL,
  `CONTENU` text DEFAULT NULL,
  `DATE_PUBLICATION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`ID_ANNONCE`, `ID_COUR`, `TITRE`, `CONTENU`, `DATE_PUBLICATION`) VALUES
(1, 1, 'Welcome to the Course', 'We are excited to start this journey.', '2025-03-22 13:59:27');

-- --------------------------------------------------------

--
-- Structure de la table `associer_cour_reference`
--

CREATE TABLE `associer_cour_reference` (
  `ID_COUR` int(11) NOT NULL,
  `ID_RESSOURCE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `associer_cour_reference`
--

INSERT INTO `associer_cour_reference` (`ID_COUR`, `ID_RESSOURCE`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `choisir_suggestion`
--

CREATE TABLE `choisir_suggestion` (
  `ID` int(11) NOT NULL,
  `ID_SEGGECTION` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `choisir_suggestion`
--

INSERT INTO `choisir_suggestion` (`ID`, `ID_SEGGECTION`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `ID_CONTACT2` int(11) NOT NULL,
  `ID2` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `NOM` char(50) DEFAULT NULL,
  `MESSAGE` text DEFAULT NULL,
  `DATE_ENVOI` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`ID_CONTACT2`, `ID2`, `ID`, `NOM`, `MESSAGE`, `DATE_ENVOI`) VALUES
(1, 1, 1, 'Jane Smith', 'Looking forward to the course!', '2025-03-22 13:59:27');

-- --------------------------------------------------------

--
-- Structure de la table `cour`
--

CREATE TABLE `cour` (
  `ID_COUR` int(11) NOT NULL,
  `ID2` int(11) NOT NULL,
  `SUJET` varchar(100) DEFAULT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `SYLLABUS` text DEFAULT NULL,
  `MDP_COURE` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cour`
--

INSERT INTO `cour` (`ID_COUR`, `ID2`, `SUJET`, `DESCRIPTION`, `SYLLABUS`, `MDP_COURE`) VALUES
(1, 1, 'Introduction to Computer Science', 'Basics of computer science principles.', 'syllabus.pdf', 'coursepassword');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `ID` int(11) NOT NULL,
  `NOM` char(50) DEFAULT NULL,
  `PRENOM` char(50) DEFAULT NULL,
  `PHOTO_PROFIL` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `MDP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`ID`, `NOM`, `PRENOM`, `PHOTO_PROFIL`, `EMAIL`, `MDP`) VALUES
(1, 'Smith', 'Jane', 'jane_smith.jpg', 'jane.smith@example.com', 'password456');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `ID_COUR` int(11) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`ID_COUR`, `ID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `ID2` int(11) NOT NULL,
  `NOM` char(50) DEFAULT NULL,
  `PRENOM` char(50) DEFAULT NULL,
  `PHOTO_PROFIL` varchar(50) DEFAULT NULL,
  `LIEN_GOOGLE_SCHOLAR` varchar(100) DEFAULT NULL,
  `BIOGRAPHIE` text DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `MDP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`ID2`, `NOM`, `PRENOM`, `PHOTO_PROFIL`, `LIEN_GOOGLE_SCHOLAR`, `BIOGRAPHIE`, `EMAIL`, `MDP`) VALUES
(1, 'Doe', 'John', 'john_doe.jpg', 'https://scholar.google.com/johndoe', 'Expert in computer science.', 'john.doe@example.com', '1111');

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `ID_PUB` int(11) NOT NULL,
  `ID2` int(11) NOT NULL,
  `SUJET` varchar(100) DEFAULT NULL,
  `AUTEURS` text DEFAULT NULL,
  `ANNEE` date DEFAULT NULL,
  `FICHIER_PDF` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`ID_PUB`, `ID2`, `SUJET`, `AUTEURS`, `ANNEE`, `FICHIER_PDF`) VALUES
(1, 1, 'Research on AI', 'John Doe', '2025-01-01', 'ai_research.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `qcm`
--

CREATE TABLE `qcm` (
  `ID_QCM` int(11) NOT NULL,
  `ID_COUR` int(11) NOT NULL,
  `TITRE_QCM` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `qcm`
--

INSERT INTO `qcm` (`ID_QCM`, `ID_COUR`, `TITRE_QCM`) VALUES
(1, 1, 'Quiz 1');

-- --------------------------------------------------------

--
-- Structure de la table `question_qcm`
--

CREATE TABLE `question_qcm` (
  `ID_QCM_QUESTION` int(11) NOT NULL,
  `ID_QCM` int(11) NOT NULL,
  `QCM_QUESTION` varchar(100) DEFAULT NULL,
  `TYPE_QUESTION` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `question_qcm`
--

INSERT INTO `question_qcm` (`ID_QCM_QUESTION`, `ID_QCM`, `QCM_QUESTION`, `TYPE_QUESTION`) VALUES
(1, 1, 'What is a computer?', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reference`
--

CREATE TABLE `reference` (
  `ID_RESSOURCE` int(11) NOT NULL,
  `TITRE` varchar(200) DEFAULT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `FICHIER` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reference`
--

INSERT INTO `reference` (`ID_RESSOURCE`, `TITRE`, `DESCRIPTION`, `FICHIER`) VALUES
(1, 'Lecture Notes', 'Notes for the first lecture.', 'lecture1.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `suggestion`
--

CREATE TABLE `suggestion` (
  `ID_SEGGECTION` int(11) NOT NULL,
  `ID_QCM_QUESTION` int(11) NOT NULL,
  `SEGGECTION` varchar(150) DEFAULT NULL,
  `CORECT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `suggestion`
--

INSERT INTO `suggestion` (`ID_SEGGECTION`, `ID_QCM_QUESTION`, `SEGGECTION`, `CORECT`) VALUES
(0, 1, 'An electronic device', 0),
(1, 1, 'An electronic device', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`ID_ANNONCE`),
  ADD KEY `FK_DIFFUSER` (`ID_COUR`);

--
-- Index pour la table `associer_cour_reference`
--
ALTER TABLE `associer_cour_reference`
  ADD PRIMARY KEY (`ID_COUR`,`ID_RESSOURCE`),
  ADD KEY `FK_ASSOCIER2` (`ID_RESSOURCE`);

--
-- Index pour la table `choisir_suggestion`
--
ALTER TABLE `choisir_suggestion`
  ADD PRIMARY KEY (`ID`,`ID_SEGGECTION`),
  ADD KEY `FK_COOSE2` (`ID_SEGGECTION`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID_CONTACT2`),
  ADD KEY `FK_ENVOYER` (`ID`),
  ADD KEY `FK_RECEVOIRE` (`ID2`);

--
-- Index pour la table `cour`
--
ALTER TABLE `cour`
  ADD PRIMARY KEY (`ID_COUR`),
  ADD KEY `FK_ASSOCIATION_15` (`ID2`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`ID_COUR`,`ID`),
  ADD KEY `FK_INSCRIRE2` (`ID`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`ID2`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`ID_PUB`),
  ADD KEY `FK_PUBLIER` (`ID2`);

--
-- Index pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD PRIMARY KEY (`ID_QCM`),
  ADD KEY `FK_COUR_QCM` (`ID_COUR`);

--
-- Index pour la table `question_qcm`
--
ALTER TABLE `question_qcm`
  ADD PRIMARY KEY (`ID_QCM_QUESTION`),
  ADD KEY `FK_BELONG` (`ID_QCM`);

--
-- Index pour la table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`ID_RESSOURCE`);

--
-- Index pour la table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`ID_SEGGECTION`),
  ADD KEY `FK_HAVE` (`ID_QCM_QUESTION`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `ID_ANNONCE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `associer_cour_reference`
--
ALTER TABLE `associer_cour_reference`
  MODIFY `ID_COUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `choisir_suggestion`
--
ALTER TABLE `choisir_suggestion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID_CONTACT2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cour`
--
ALTER TABLE `cour`
  MODIFY `ID_COUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `ID_COUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `professeur`
--
ALTER TABLE `professeur`
  MODIFY `ID2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `ID_PUB` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `qcm`
--
ALTER TABLE `qcm`
  MODIFY `ID_QCM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `question_qcm`
--
ALTER TABLE `question_qcm`
  MODIFY `ID_QCM_QUESTION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reference`
--
ALTER TABLE `reference`
  MODIFY `ID_RESSOURCE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `FK_DIFFUSER` FOREIGN KEY (`ID_COUR`) REFERENCES `cour` (`ID_COUR`);

--
-- Contraintes pour la table `associer_cour_reference`
--
ALTER TABLE `associer_cour_reference`
  ADD CONSTRAINT `FK_ASSOCIER` FOREIGN KEY (`ID_COUR`) REFERENCES `cour` (`ID_COUR`),
  ADD CONSTRAINT `FK_ASSOCIER2` FOREIGN KEY (`ID_RESSOURCE`) REFERENCES `reference` (`ID_RESSOURCE`);

--
-- Contraintes pour la table `choisir_suggestion`
--
ALTER TABLE `choisir_suggestion`
  ADD CONSTRAINT `FK_COOSE` FOREIGN KEY (`ID`) REFERENCES `etudiant` (`ID`),
  ADD CONSTRAINT `FK_COOSE2` FOREIGN KEY (`ID_SEGGECTION`) REFERENCES `suggestion` (`ID_SEGGECTION`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_ENVOYER` FOREIGN KEY (`ID`) REFERENCES `etudiant` (`ID`),
  ADD CONSTRAINT `FK_RECEVOIRE` FOREIGN KEY (`ID2`) REFERENCES `professeur` (`ID2`);

--
-- Contraintes pour la table `cour`
--
ALTER TABLE `cour`
  ADD CONSTRAINT `FK_ASSOCIATION_15` FOREIGN KEY (`ID2`) REFERENCES `professeur` (`ID2`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_INSCRIRE` FOREIGN KEY (`ID_COUR`) REFERENCES `cour` (`ID_COUR`),
  ADD CONSTRAINT `FK_INSCRIRE2` FOREIGN KEY (`ID`) REFERENCES `etudiant` (`ID`);

--
-- Contraintes pour la table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `FK_PUBLIER` FOREIGN KEY (`ID2`) REFERENCES `professeur` (`ID2`);

--
-- Contraintes pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `FK_COUR_QCM` FOREIGN KEY (`ID_COUR`) REFERENCES `cour` (`ID_COUR`);

--
-- Contraintes pour la table `question_qcm`
--
ALTER TABLE `question_qcm`
  ADD CONSTRAINT `FK_BELONG` FOREIGN KEY (`ID_QCM`) REFERENCES `qcm` (`ID_QCM`);

--
-- Contraintes pour la table `suggestion`
--
ALTER TABLE `suggestion`
  ADD CONSTRAINT `FK_HAVE` FOREIGN KEY (`ID_QCM_QUESTION`) REFERENCES `question_qcm` (`ID_QCM_QUESTION`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
