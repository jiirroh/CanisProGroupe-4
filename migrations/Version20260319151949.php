<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260319151949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nom VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE chien ADD proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE chien ADD CONSTRAINT FK_13A4067E76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('CREATE INDEX IDX_13A4067E76C50E4A ON chien (proprietaire_id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(180) NOT NULL, ADD prenom VARCHAR(180) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin');
        $this->addSql('ALTER TABLE chien DROP FOREIGN KEY FK_13A4067E76C50E4A');
        $this->addSql('DROP INDEX IDX_13A4067E76C50E4A ON chien');
        $this->addSql('ALTER TABLE chien DROP proprietaire_id');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom');
    }
}
