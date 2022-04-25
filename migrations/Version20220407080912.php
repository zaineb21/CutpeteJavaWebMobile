<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407080912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_panier id_panier INT NOT NULL, CHANGE code_promo code_promo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE id_produit id_produit INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE id_utilisateur id_utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_panier id_panier INT AUTO_INCREMENT NOT NULL, CHANGE code_promo code_promo INT NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE id_produit id_produit INT NOT NULL');
    }
}
