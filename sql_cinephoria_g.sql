SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE avis (
  id int(11) NOT NULL AUTO_INCREMENT,
  film_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  note int(11) NOT NULL,
  commentaire varchar(2000) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY IDX_AVIS_FILM_ID (film_id),
  KEY IDX_AVIS_USER_ID (user_id);
);


CREATE TABLE cinemas (
  id int(11) NOT NULL AUTO_INCREMENT,
  nom varchar(50) NOT NULL,
  adresse1 varchar(45) NOT NULL,
  adresse2 varchar(45) DEFAULT NULL,
  cp varchar(5) NOT NULL,
  ville varchar(45) NOT NULL,
  technologies json NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE films (
  id int(11) NOT NULL AUTO_INCREMENT,
  titre varchar(80) NOT NULL,
  affiche varchar(255) DEFAULT NULL,
  description longtext NOT NULL,
  genre json NOT NULL,
  age_mini int(11) NOT NULL,
  coup_de_coeur int(11) DEFAULT NULL,
  score int(11) DEFAULT NULL,
  duree time NOT NULL,
  date_ajout datetime NOT NULL,
  realisateur varchar(100) DEFAULT NULL,
  acteurs varchar(255) DEFAULT NULL,
  avertissement varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE salles (
  id int(11) NOT NULL AUTO_INCREMENT,
  cinema_id int(11) NOT NULL,
  places int(11) NOT NULL,
  technologies json NOT NULL,
  salle_nom varchar(45) NOT NULL,
  PRIMARY KEY (id),
  KEY IDX_SALLES_CINEMA_ID (cinema_id);
);

CREATE TABLE seances (
  id int(11) NOT NULL AUTO_INCREMENT,
  cinema_id int(11) NOT NULL,
  film_id int(11) NOT NULL,
  salle_id int(11) NOT NULL,
  date_debut datetime NOT NULL,
  date_fin datetime NOT NULL,
  technologies json NULL,
  PRIMARY KEY (id),
  ADD KEY IDX_SEANCES_FILM_ID (film_id),
  ADD KEY IDX_SEANCES_SALLE_ID (salle_id);

);

CREATE TABLE tarifs (
  id int(11) NOT NULL AUTO_INCREMENT,
  cinema_id int(11) NOT NULL,
  tarif_type varchar(50) NOT NULL,
  tarif_nom varchar(50) NOT NULL,
  tarif int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY IDX_TARIFS_CINEMA_ID (cinema_id);
);

CREATE TABLE `user` (
  id int(11) NOT NULL AUTO_INCREMENT,
  email varchar(180) NOT NULL,
  roles json NOT NULL,
  password varchar(255) NOT NULL,
  nom varchar(50) NOT NULL,
  prenom varchar(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY UNIQ_IDENTIFIER_EMAIL (email);
);


ALTER TABLE avis
  ADD CONSTRAINT FK_AVIS_USER_ID FOREIGN KEY (user_id) REFERENCES `user` (id),
  ADD CONSTRAINT FK_AVIS_FILM_ID FOREIGN KEY (film_id) REFERENCES films (id);

ALTER TABLE salles
  ADD CONSTRAINT FK_SALLES_CINEMA_ID FOREIGN KEY (cinema_id) REFERENCES cinemas (id);

ALTER TABLE seances
  ADD CONSTRAINT FK_SEANCES_SALLE_ID FOREIGN KEY (salle_id) REFERENCES salles (id),
  ADD CONSTRAINT FK_SEANCES_FILM_ID FOREIGN KEY (film_id) REFERENCES films (id);

ALTER TABLE tarifs
  ADD CONSTRAINT FK_TARIFS_CINEMA_ID FOREIGN KEY (cinema_id) REFERENCES cinemas (id);


