<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605173822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation ADD COLUMN note INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE participation ADD COLUMN comment CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__participation AS SELECT id, user_id, availability_id, amount, created_at, updated_at, deleted_at FROM participation');
        $this->addSql('DROP TABLE participation');
        $this->addSql('CREATE TABLE participation (id BLOB NOT NULL --(DC2Type:uuid)
        , user_id BLOB NOT NULL --(DC2Type:uuid)
        , availability_id BLOB NOT NULL --(DC2Type:uuid)
        , amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AB55E24F61778466 FOREIGN KEY (availability_id) REFERENCES availability (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO participation (id, user_id, availability_id, amount, created_at, updated_at, deleted_at) SELECT id, user_id, availability_id, amount, created_at, updated_at, deleted_at FROM __temp__participation');
        $this->addSql('DROP TABLE __temp__participation');
        $this->addSql('CREATE INDEX IDX_AB55E24FA76ED395 ON participation (user_id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F61778466 ON participation (availability_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB55E24F61778466A76ED395 ON participation (availability_id, user_id)');
    }
}
