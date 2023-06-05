<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605171327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__availability AS SELECT id, restaurant_id, teacher_id, language_id, status_id, start, price, comment, created_at, updated_at, deleted_at, is_enabled FROM availability');
        $this->addSql('DROP TABLE availability');
        $this->addSql('CREATE TABLE availability (id BLOB NOT NULL --(DC2Type:uuid)
        , restaurant_id BLOB NOT NULL --(DC2Type:uuid)
        , teacher_id BLOB NOT NULL --(DC2Type:uuid)
        , language_id BLOB NOT NULL --(DC2Type:uuid)
        , status_id BLOB NOT NULL --(DC2Type:uuid)
        , start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , price DOUBLE PRECISION NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, duration INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_3FB7A2BFB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF6BF700BD FOREIGN KEY (status_id) REFERENCES availability_status (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO availability (id, restaurant_id, teacher_id, language_id, status_id, start, price, comment, created_at, updated_at, deleted_at, is_enabled) SELECT id, restaurant_id, teacher_id, language_id, status_id, start, price, comment, created_at, updated_at, deleted_at, is_enabled FROM __temp__availability');
        $this->addSql('DROP TABLE __temp__availability');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFB1E7706E ON availability (restaurant_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF41807E1D ON availability (teacher_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF82F1BAF4 ON availability (language_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF6BF700BD ON availability (status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3FB7A2BF9F79558F41807E1D ON availability (start, teacher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__availability AS SELECT id, restaurant_id, teacher_id, language_id, status_id, start, price, comment, created_at, updated_at, deleted_at, is_enabled FROM availability');
        $this->addSql('DROP TABLE availability');
        $this->addSql('CREATE TABLE availability (id BLOB NOT NULL --(DC2Type:uuid)
        , restaurant_id BLOB NOT NULL --(DC2Type:uuid)
        , teacher_id BLOB NOT NULL --(DC2Type:uuid)
        , language_id BLOB NOT NULL --(DC2Type:uuid)
        , status_id BLOB NOT NULL --(DC2Type:uuid)
        , start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , price DOUBLE PRECISION NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, "end" DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id), CONSTRAINT FK_3FB7A2BFB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF6BF700BD FOREIGN KEY (status_id) REFERENCES availability_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO availability (id, restaurant_id, teacher_id, language_id, status_id, start, price, comment, created_at, updated_at, deleted_at, is_enabled) SELECT id, restaurant_id, teacher_id, language_id, status_id, start, price, comment, created_at, updated_at, deleted_at, is_enabled FROM __temp__availability');
        $this->addSql('DROP TABLE __temp__availability');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFB1E7706E ON availability (restaurant_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF41807E1D ON availability (teacher_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF82F1BAF4 ON availability (language_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF6BF700BD ON availability (status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3FB7A2BF9F79558F41807E1D ON availability (start, teacher_id)');
    }
}
