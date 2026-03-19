<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260319161730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription ADD chien_id INT NOT NULL, ADD cours_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D67ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6BFCF400E ON inscription (chien_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D67ECF78B0 ON inscription (cours_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6BFCF400E');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D67ECF78B0');
        $this->addSql('DROP INDEX IDX_5E90F6D6BFCF400E ON inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D67ECF78B0 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP chien_id, DROP cours_id');
    }
}
