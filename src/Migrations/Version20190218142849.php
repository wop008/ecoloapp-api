<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190218142849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, number INT NOT NULL, street VARCHAR(100) NOT NULL, postal_code INT NOT NULL, city VARCHAR(100) NOT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emballage (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emballage_produit (emballage_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_B08E1DC9787EB836 (emballage_id), INDEX IDX_B08E1DC9F347EFB (produit_id), PRIMARY KEY(emballage_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label_produit (label_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_9524450E33B92F39 (label_id), INDEX IDX_9524450EF347EFB (produit_id), PRIMARY KEY(label_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque_produit (marque_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_F07F4F324827B9B2 (marque_id), INDEX IDX_F07F4F32F347EFB (produit_id), PRIMARY KEY(marque_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, quantite INT NOT NULL, origine VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, username VARCHAR(75) NOT NULL, email VARCHAR(150) NOT NULL, password VARCHAR(190) NOT NULL, roles LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE emballage_produit ADD CONSTRAINT FK_B08E1DC9787EB836 FOREIGN KEY (emballage_id) REFERENCES emballage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emballage_produit ADD CONSTRAINT FK_B08E1DC9F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE label_produit ADD CONSTRAINT FK_9524450E33B92F39 FOREIGN KEY (label_id) REFERENCES label (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE label_produit ADD CONSTRAINT FK_9524450EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_produit ADD CONSTRAINT FK_F07F4F324827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_produit ADD CONSTRAINT FK_F07F4F32F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE emballage_produit DROP FOREIGN KEY FK_B08E1DC9787EB836');
        $this->addSql('ALTER TABLE label_produit DROP FOREIGN KEY FK_9524450E33B92F39');
        $this->addSql('ALTER TABLE marque_produit DROP FOREIGN KEY FK_F07F4F324827B9B2');
        $this->addSql('ALTER TABLE emballage_produit DROP FOREIGN KEY FK_B08E1DC9F347EFB');
        $this->addSql('ALTER TABLE label_produit DROP FOREIGN KEY FK_9524450EF347EFB');
        $this->addSql('ALTER TABLE marque_produit DROP FOREIGN KEY FK_F07F4F32F347EFB');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE emballage');
        $this->addSql('DROP TABLE emballage_produit');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE label_produit');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE marque_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
    }
}
