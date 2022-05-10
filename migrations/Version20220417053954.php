<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417053954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Evenement (id INT AUTO_INCREMENT NOT NULL, idc INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type_e VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, date_debut VARCHAR(255) NOT NULL, date_fin VARCHAR(255) NOT NULL, INDEX FK_100 (idc), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Reply (id INT AUTO_INCREMENT NOT NULL, ad INT DEFAULT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', rating INT NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_3C69E9E4A76ED395 (user_id), INDEX FK_1 (ad), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, idpost INT DEFAULT NULL, text VARCHAR(255) NOT NULL, INDEX FK_1 (idpost), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_852BBECDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_sdf (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, nom_sur_carte VARCHAR(255) NOT NULL, num_carte INT NOT NULL, mois_exp VARCHAR(255) NOT NULL, annee_exp INT NOT NULL, cvv VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation_prive (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, numero_tel INT NOT NULL, nbr_prisecharge INT NOT NULL, INDEX IDX_F2A14946A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation_public (id INT AUTO_INCREMENT NOT NULL, paiementpublic_id INT DEFAULT NULL, user_id INT NOT NULL, donation DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_41D1A83851D336CB (paiementpublic_id), INDEX IDX_41D1A838A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reply_like (id INT AUTO_INCREMENT NOT NULL, rep_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_FCCDD58554C549EA (rep_id), INDEX IDX_FCCDD585A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sdf (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(18) NOT NULL, last_name VARCHAR(18) NOT NULL, gender VARCHAR(18) NOT NULL, age INT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Evenement ADD CONSTRAINT FK_89D7EABD6D6DB7FC FOREIGN KEY (idc) REFERENCES category (id)');
        $this->addSql('ALTER TABLE Reply ADD CONSTRAINT FK_3C69E9E477E0ED58 FOREIGN KEY (ad) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE Reply ADD CONSTRAINT FK_3C69E9E4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC89459D2D FOREIGN KEY (idpost) REFERENCES post (id)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation_prive ADD CONSTRAINT FK_F2A14946A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation_public ADD CONSTRAINT FK_41D1A83851D336CB FOREIGN KEY (paiementpublic_id) REFERENCES paiement (id)');
        $this->addSql('ALTER TABLE participation_public ADD CONSTRAINT FK_41D1A838A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reply_like ADD CONSTRAINT FK_FCCDD58554C549EA FOREIGN KEY (rep_id) REFERENCES Reply (id)');
        $this->addSql('ALTER TABLE reply_like ADD CONSTRAINT FK_FCCDD585A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply_like DROP FOREIGN KEY FK_FCCDD58554C549EA');
        $this->addSql('ALTER TABLE Evenement DROP FOREIGN KEY FK_89D7EABD6D6DB7FC');
        $this->addSql('ALTER TABLE Reply DROP FOREIGN KEY FK_3C69E9E477E0ED58');
        $this->addSql('ALTER TABLE participation_public DROP FOREIGN KEY FK_41D1A83851D336CB');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC89459D2D');
        $this->addSql('ALTER TABLE Reply DROP FOREIGN KEY FK_3C69E9E4A76ED395');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECDA76ED395');
        $this->addSql('ALTER TABLE participation_prive DROP FOREIGN KEY FK_F2A14946A76ED395');
        $this->addSql('ALTER TABLE participation_public DROP FOREIGN KEY FK_41D1A838A76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reply_like DROP FOREIGN KEY FK_FCCDD585A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE Evenement');
        $this->addSql('DROP TABLE Reply');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE list_sdf');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE participation_prive');
        $this->addSql('DROP TABLE participation_public');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reply_like');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sdf');
        $this->addSql('DROP TABLE user');
    }
}
