<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822084515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recommandation_veterinary DROP INDEX UNIQ_B73ACD478E962C16, ADD INDEX IDX_B73ACD478E962C16 (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recommandation_veterinary DROP INDEX IDX_B73ACD478E962C16, ADD UNIQUE INDEX UNIQ_B73ACD478E962C16 (animal_id)');
    }
}
