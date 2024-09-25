<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240924231254 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article ADD seo_id INT DEFAULT NULL, ADD content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6697E3DD86 FOREIGN KEY (seo_id) REFERENCES seo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E6697E3DD86 ON article (seo_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6697E3DD86');
        $this->addSql('DROP INDEX UNIQ_23A0E6697E3DD86 ON article');
        $this->addSql('ALTER TABLE article DROP seo_id, DROP content');
    }
}
