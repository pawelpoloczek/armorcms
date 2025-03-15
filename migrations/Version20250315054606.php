<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250315054606 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX slug ON page');
        $this->addSql('ALTER TABLE page ADD route_id INT DEFAULT NULL, DROP slug');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62034ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_140AB62034ECB4E6 ON page (route_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62034ECB4E6');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP INDEX UNIQ_140AB62034ECB4E6 ON page');
        $this->addSql('ALTER TABLE page ADD slug VARCHAR(255) NOT NULL, DROP route_id');
        $this->addSql('CREATE UNIQUE INDEX slug ON page (slug)');
    }
}
