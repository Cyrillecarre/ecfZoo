<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240818125754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recommandation_veterinary_food (recommandation_veterinary_id INT NOT NULL, food_id INT NOT NULL, INDEX IDX_6591B357ABCC2E73 (recommandation_veterinary_id), INDEX IDX_6591B357BA8E87C4 (food_id), PRIMARY KEY(recommandation_veterinary_id, food_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recommandation_veterinary_food ADD CONSTRAINT FK_6591B357ABCC2E73 FOREIGN KEY (recommandation_veterinary_id) REFERENCES recommandation_veterinary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recommandation_veterinary_food ADD CONSTRAINT FK_6591B357BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recommandation_veterinary ADD food VARCHAR(255) DEFAULT NULL, ADD quantity INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recommandation_veterinary_food DROP FOREIGN KEY FK_6591B357ABCC2E73');
        $this->addSql('ALTER TABLE recommandation_veterinary_food DROP FOREIGN KEY FK_6591B357BA8E87C4');
        $this->addSql('DROP TABLE recommandation_veterinary_food');
        $this->addSql('ALTER TABLE recommandation_veterinary DROP food, DROP quantity');
    }
}
