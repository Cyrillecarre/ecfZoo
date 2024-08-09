<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809114714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, name VARCHAR(255) NOT NULL, race VARCHAR(255) NOT NULL, INDEX IDX_6AAB231FBD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_animal (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_FB4F950F8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_area (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_6874B8FDBD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recommandation_veterinary (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, food VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, medicine VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, state VARCHAR(255) NOT NULL, recommandation VARCHAR(255) DEFAULT NULL, report VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B73ACD478E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FBD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE picture_animal ADD CONSTRAINT FK_FB4F950F8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE picture_area ADD CONSTRAINT FK_6874B8FDBD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE recommandation_veterinary ADD CONSTRAINT FK_B73ACD478E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FBD0F409C');
        $this->addSql('ALTER TABLE picture_animal DROP FOREIGN KEY FK_FB4F950F8E962C16');
        $this->addSql('ALTER TABLE picture_area DROP FOREIGN KEY FK_6874B8FDBD0F409C');
        $this->addSql('ALTER TABLE recommandation_veterinary DROP FOREIGN KEY FK_B73ACD478E962C16');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE picture_animal');
        $this->addSql('DROP TABLE picture_area');
        $this->addSql('DROP TABLE recommandation_veterinary');
    }
}
