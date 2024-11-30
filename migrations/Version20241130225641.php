<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241130225641 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE page DROP deleted_at');
        $this->addSql('CREATE UNIQUE INDEX slug ON page (slug)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX slug ON page');
        $this->addSql('ALTER TABLE page ADD deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
