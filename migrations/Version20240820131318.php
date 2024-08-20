<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820131318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monitoring ADD animal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monitoring ADD CONSTRAINT FK_BA4F975D8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_BA4F975D8E962C16 ON monitoring (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monitoring DROP FOREIGN KEY FK_BA4F975D8E962C16');
        $this->addSql('DROP INDEX IDX_BA4F975D8E962C16 ON monitoring');
        $this->addSql('ALTER TABLE monitoring DROP animal_id');
    }
}
