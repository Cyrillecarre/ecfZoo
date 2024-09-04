<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904111214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, name VARCHAR(255) NOT NULL, race VARCHAR(255) NOT NULL, INDEX IDX_6AAB231FBD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, image_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monitoring (id INT AUTO_INCREMENT NOT NULL, recommandation_veterinary_id INT DEFAULT NULL, animal_id INT DEFAULT NULL, medicine VARCHAR(255) NOT NULL, date DATETIME NOT NULL, state VARCHAR(255) NOT NULL, report VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_BA4F975DABCC2E73 (recommandation_veterinary_id), INDEX IDX_BA4F975D8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monitoring_food (monitoring_id INT NOT NULL, food_id INT NOT NULL, INDEX IDX_CE50744DA4638B5 (monitoring_id), INDEX IDX_CE50744BA8E87C4 (food_id), PRIMARY KEY(monitoring_id, food_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_animal (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_FB4F950F8E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_area (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_6874B8FDBD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recommandation_veterinary (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, medicine VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, state VARCHAR(255) NOT NULL, recommandation VARCHAR(255) DEFAULT NULL, report VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B73ACD478E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recommandation_veterinary_food (recommandation_veterinary_id INT NOT NULL, food_id INT NOT NULL, INDEX IDX_6591B357ABCC2E73 (recommandation_veterinary_id), INDEX IDX_6591B357BA8E87C4 (food_id), PRIMARY KEY(recommandation_veterinary_id, food_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, count INT NOT NULL, content VARCHAR(255) NOT NULL, date DATE NOT NULL, is_approuved TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, descritpion VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinary (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FBD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE monitoring ADD CONSTRAINT FK_BA4F975DABCC2E73 FOREIGN KEY (recommandation_veterinary_id) REFERENCES recommandation_veterinary (id)');
        $this->addSql('ALTER TABLE monitoring ADD CONSTRAINT FK_BA4F975D8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE monitoring_food ADD CONSTRAINT FK_CE50744DA4638B5 FOREIGN KEY (monitoring_id) REFERENCES monitoring (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE monitoring_food ADD CONSTRAINT FK_CE50744BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_animal ADD CONSTRAINT FK_FB4F950F8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE picture_area ADD CONSTRAINT FK_6874B8FDBD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE recommandation_veterinary ADD CONSTRAINT FK_B73ACD478E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE recommandation_veterinary_food ADD CONSTRAINT FK_6591B357ABCC2E73 FOREIGN KEY (recommandation_veterinary_id) REFERENCES recommandation_veterinary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recommandation_veterinary_food ADD CONSTRAINT FK_6591B357BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FBD0F409C');
        $this->addSql('ALTER TABLE monitoring DROP FOREIGN KEY FK_BA4F975DABCC2E73');
        $this->addSql('ALTER TABLE monitoring DROP FOREIGN KEY FK_BA4F975D8E962C16');
        $this->addSql('ALTER TABLE monitoring_food DROP FOREIGN KEY FK_CE50744DA4638B5');
        $this->addSql('ALTER TABLE monitoring_food DROP FOREIGN KEY FK_CE50744BA8E87C4');
        $this->addSql('ALTER TABLE picture_animal DROP FOREIGN KEY FK_FB4F950F8E962C16');
        $this->addSql('ALTER TABLE picture_area DROP FOREIGN KEY FK_6874B8FDBD0F409C');
        $this->addSql('ALTER TABLE recommandation_veterinary DROP FOREIGN KEY FK_B73ACD478E962C16');
        $this->addSql('ALTER TABLE recommandation_veterinary_food DROP FOREIGN KEY FK_6591B357ABCC2E73');
        $this->addSql('ALTER TABLE recommandation_veterinary_food DROP FOREIGN KEY FK_6591B357BA8E87C4');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE food');
        $this->addSql('DROP TABLE monitoring');
        $this->addSql('DROP TABLE monitoring_food');
        $this->addSql('DROP TABLE picture_animal');
        $this->addSql('DROP TABLE picture_area');
        $this->addSql('DROP TABLE recommandation_veterinary');
        $this->addSql('DROP TABLE recommandation_veterinary_food');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE veterinary');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
