<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820155937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE monitoring_food (monitoring_id INT NOT NULL, food_id INT NOT NULL, INDEX IDX_CE50744DA4638B5 (monitoring_id), INDEX IDX_CE50744BA8E87C4 (food_id), PRIMARY KEY(monitoring_id, food_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE monitoring_food ADD CONSTRAINT FK_CE50744DA4638B5 FOREIGN KEY (monitoring_id) REFERENCES monitoring (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE monitoring_food ADD CONSTRAINT FK_CE50744BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monitoring_food DROP FOREIGN KEY FK_CE50744DA4638B5');
        $this->addSql('ALTER TABLE monitoring_food DROP FOREIGN KEY FK_CE50744BA8E87C4');
        $this->addSql('DROP TABLE monitoring_food');
    }
}
