<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706152114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add a status field column in payments entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone, name FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id BLOB NOT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO contact (id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone, name) SELECT id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone, name FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('ALTER TABLE payment ADD COLUMN status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD COLUMN data CLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, subject, content, email, phone, is_enabled, created_at, updated_at, deleted_at, name FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id BLOB NOT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO contact (id, subject, content, email, phone, is_enabled, created_at, updated_at, deleted_at, name) SELECT id, subject, content, email, phone, is_enabled, created_at, updated_at, deleted_at, name FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638E7927C74 ON contact (email)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__payment AS SELECT id, participation_id, reference, amount, comment, created_at, updated_at, deleted_at FROM payment');
        $this->addSql('DROP TABLE payment');
        $this->addSql('CREATE TABLE payment (id BLOB NOT NULL --(DC2Type:uuid)
        , participation_id BLOB NOT NULL --(DC2Type:uuid)
        , reference VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_6D28840D6ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO payment (id, participation_id, reference, amount, comment, created_at, updated_at, deleted_at) SELECT id, participation_id, reference, amount, comment, created_at, updated_at, deleted_at FROM __temp__payment');
        $this->addSql('DROP TABLE __temp__payment');
        $this->addSql('CREATE INDEX IDX_6D28840D6ACE3B73 ON payment (participation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840DAEA34913 ON payment (reference)');
    }
}
