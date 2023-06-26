<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626065215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id BLOB NOT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO contact (id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone) SELECT id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638E7927C74 ON contact (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, subject, content, phone, is_enabled, created_at, updated_at, deleted_at, email FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id BLOB NOT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO contact (id, subject, content, phone, is_enabled, created_at, updated_at, deleted_at, email) SELECT id, subject, content, phone, is_enabled, created_at, updated_at, deleted_at, email FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638E7927C74 ON contact (email)');
    }
}
