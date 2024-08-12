<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240812125141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_area (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_6874B8FDBD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture_area ADD CONSTRAINT FK_6874B8FDBD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture_area DROP FOREIGN KEY FK_6874B8FDBD0F409C');
        $this->addSql('DROP TABLE picture_area');
    }
}
