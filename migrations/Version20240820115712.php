<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820115712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monitoring ADD recommandation_veterinary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE monitoring ADD CONSTRAINT FK_BA4F975DABCC2E73 FOREIGN KEY (recommandation_veterinary_id) REFERENCES recommandation_veterinary (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA4F975DABCC2E73 ON monitoring (recommandation_veterinary_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monitoring DROP FOREIGN KEY FK_BA4F975DABCC2E73');
        $this->addSql('DROP INDEX UNIQ_BA4F975DABCC2E73 ON monitoring');
        $this->addSql('ALTER TABLE monitoring DROP recommandation_veterinary_id');
    }
}
