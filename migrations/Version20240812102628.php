<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240812102628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture_area DROP FOREIGN KEY FK_6874B8FDBD0F409C');
        $this->addSql('DROP TABLE picture_area');
        $this->addSql('ALTER TABLE area ADD image_path VARCHAR(255) DEFAULT NULL, DROP image_files');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_area (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, file_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6874B8FDBD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture_area ADD CONSTRAINT FK_6874B8FDBD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE area ADD image_files LONGTEXT DEFAULT NULL, DROP image_path');
    }
}
