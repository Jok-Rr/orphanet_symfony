<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812134405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD external_link TINYINT(1) NOT NULL, ADD external_url VARCHAR(255) DEFAULT NULL, ADD header LONGTEXT DEFAULT NULL, ADD hero_pic VARCHAR(255) DEFAULT NULL, DROP created_at, DROP updated_at, DROP author, CHANGE content content LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD author VARCHAR(255) NOT NULL, DROP external_link, DROP external_url, DROP header, DROP hero_pic, CHANGE content content LONGTEXT NOT NULL');
    }
}
