<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407091835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY panier_ibfk_4');
        $this->addSql('DROP INDEX id_produit ON panier');
        $this->addSql('ALTER TABLE produit MODIFY id_produit INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE produit CHANGE id_produit id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT panier_ibfk_4 FOREIGN KEY (id_produit) REFERENCES produit (id_produit)');
        $this->addSql('CREATE INDEX id_produit ON panier (id_produit)');
        $this->addSql('ALTER TABLE produit MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE produit CHANGE id id_produit INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD PRIMARY KEY (id_produit)');
    }
}
