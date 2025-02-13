<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213145248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, film_id_id INT NOT NULL, user_id_id INT NOT NULL, note INT NOT NULL, commentaire VARCHAR(2000) DEFAULT NULL, INDEX IDX_8F91ABF0E6286007 (film_id_id), INDEX IDX_8F91ABF09D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cinemas (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, adresse1 VARCHAR(45) NOT NULL, adresse2 VARCHAR(45) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(45) NOT NULL, technologies JSON NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE films (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(80) NOT NULL, affiche VARCHAR(255) DEFAULT NULL, description VARCHAR(500) NOT NULL, genre VARCHAR(45) NOT NULL, age_mini INT NOT NULL, coup_de_coeur INT DEFAULT NULL, score INT DEFAULT NULL, duree TIME NOT NULL, date_ajout DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salles (id INT AUTO_INCREMENT NOT NULL, cinema_id_id INT NOT NULL, places INT NOT NULL, technologies JSON NOT NULL COMMENT \'(DC2Type:json)\', salle_nom VARCHAR(45) NOT NULL, INDEX IDX_799D45AAF4CB0151 (cinema_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seances (id INT AUTO_INCREMENT NOT NULL, film_id_id INT NOT NULL, salle_id_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_FC699FF1E6286007 (film_id_id), INDEX IDX_FC699FF192419D3E (salle_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarifs (id INT AUTO_INCREMENT NOT NULL, cinema_id_id INT NOT NULL, tarif_type VARCHAR(50) NOT NULL, tarif_nom VARCHAR(50) NOT NULL, tarif INT NOT NULL, INDEX IDX_F9B8C496F4CB0151 (cinema_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0E6286007 FOREIGN KEY (film_id_id) REFERENCES films (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE salles ADD CONSTRAINT FK_799D45AAF4CB0151 FOREIGN KEY (cinema_id_id) REFERENCES cinemas (id)');
        $this->addSql('ALTER TABLE seances ADD CONSTRAINT FK_FC699FF1E6286007 FOREIGN KEY (film_id_id) REFERENCES films (id)');
        $this->addSql('ALTER TABLE seances ADD CONSTRAINT FK_FC699FF192419D3E FOREIGN KEY (salle_id_id) REFERENCES salles (id)');
        $this->addSql('ALTER TABLE tarifs ADD CONSTRAINT FK_F9B8C496F4CB0151 FOREIGN KEY (cinema_id_id) REFERENCES cinemas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0E6286007');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF09D86650F');
        $this->addSql('ALTER TABLE salles DROP FOREIGN KEY FK_799D45AAF4CB0151');
        $this->addSql('ALTER TABLE seances DROP FOREIGN KEY FK_FC699FF1E6286007');
        $this->addSql('ALTER TABLE seances DROP FOREIGN KEY FK_FC699FF192419D3E');
        $this->addSql('ALTER TABLE tarifs DROP FOREIGN KEY FK_F9B8C496F4CB0151');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE cinemas');
        $this->addSql('DROP TABLE films');
        $this->addSql('DROP TABLE salles');
        $this->addSql('DROP TABLE seances');
        $this->addSql('DROP TABLE tarifs');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
