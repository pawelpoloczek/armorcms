<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250321183147 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_D5AF2D7F8A90ABA9 ON text_block');
        $this->addSql('ALTER TABLE text_block CHANGE `key` block_key VARCHAR(63) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5AF2D7FE81B6293 ON text_block (block_key)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_D5AF2D7FE81B6293 ON text_block');
        $this->addSql('ALTER TABLE text_block CHANGE block_key `key` VARCHAR(63) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5AF2D7F8A90ABA9 ON text_block (`key`)');
    }
}
