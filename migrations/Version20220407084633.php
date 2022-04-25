<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407084633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY panier_ibfk_4');
        $this->addSql('ALTER TABLE panier CHANGE id_produit id_produit INT DEFAULT NULL');
        $this->addSql('DROP INDEX idx_24cc0df2f7384557 ON panier');
        $this->addSql('CREATE INDEX id_produit ON panier (id_produit)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT panier_ibfk_4 FOREIGN KEY (id_produit) REFERENCES produit (id_produit)');
        $this->addSql('ALTER TABLE produit CHANGE id_produit id_produit INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2F7384557');
        $this->addSql('ALTER TABLE panier CHANGE id_produit id_produit INT NOT NULL');
        $this->addSql('DROP INDEX id_produit ON panier');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F7384557 ON panier (id_produit)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id_produit)');
        $this->addSql('ALTER TABLE produit CHANGE id_produit id_produit INT NOT NULL');
    }
}
