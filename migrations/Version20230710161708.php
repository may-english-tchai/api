<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710161708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add phone in user entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__payment AS SELECT id, participation_id, reference, amount, comment, created_at, updated_at, deleted_at, status, data FROM payment');
        $this->addSql('DROP TABLE payment');
        $this->addSql('CREATE TABLE payment (id BLOB NOT NULL --(DC2Type:uuid)
        , participation_id BLOB NOT NULL --(DC2Type:uuid)
        , reference VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, data CLOB NOT NULL --(DC2Type:json)
        , PRIMARY KEY(id), CONSTRAINT FK_6D28840D6ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO payment (id, participation_id, reference, amount, comment, created_at, updated_at, deleted_at, status, data) SELECT id, participation_id, reference, amount, comment, created_at, updated_at, deleted_at, status, data FROM __temp__payment');
        $this->addSql('DROP TABLE __temp__payment');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840DAEA34913 ON payment (reference)');
        $this->addSql('CREATE INDEX IDX_6D28840D6ACE3B73 ON payment (participation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__payment AS SELECT id, participation_id, status, reference, data, amount, comment, created_at, updated_at, deleted_at FROM payment');
        $this->addSql('DROP TABLE payment');
        $this->addSql('CREATE TABLE payment (id BLOB NOT NULL --(DC2Type:uuid)
        , participation_id BLOB NOT NULL --(DC2Type:uuid)
        , status VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, data CLOB NOT NULL, amount DOUBLE PRECISION NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_6D28840D6ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO payment (id, participation_id, status, reference, data, amount, comment, created_at, updated_at, deleted_at) SELECT id, participation_id, status, reference, data, amount, comment, created_at, updated_at, deleted_at FROM __temp__payment');
        $this->addSql('DROP TABLE __temp__payment');
        $this->addSql('CREATE INDEX IDX_6D28840D6ACE3B73 ON payment (participation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840DAEA34913 ON payment (reference)');
    }
}
