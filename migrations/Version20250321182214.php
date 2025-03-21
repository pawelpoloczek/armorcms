<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250321182214 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE text_block CHANGE title `key` VARCHAR(63) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5AF2D7F8A90ABA9 ON text_block (`key`)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_D5AF2D7F8A90ABA9 ON text_block');
        $this->addSql('ALTER TABLE text_block CHANGE `key` title VARCHAR(255) NOT NULL');
    }
}
