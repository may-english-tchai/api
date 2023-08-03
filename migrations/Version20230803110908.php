<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230803110908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id BLOB NOT NULL --(DC2Type:uuid)
        , to_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, event VARCHAR(255) NOT NULL, read_at DATETIME DEFAULT NULL, archived_at DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_BF5476CA29F6EE60 FOREIGN KEY (to_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BF5476CA29F6EE60 ON notification (to_user_id)');
        $this->addSql('CREATE TABLE role (id BLOB NOT NULL --(DC2Type:uuid)
        , code VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57698A6A77153098 ON role (code)');
        $this->addSql('CREATE TABLE user_role (user_id BLOB NOT NULL --(DC2Type:uuid)
        , role_id BLOB NOT NULL --(DC2Type:uuid)
        , PRIMARY KEY(user_id, role_id), CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3A76ED395 ON user_role (user_id)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3D60322AC ON user_role (role_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone, name FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id BLOB NOT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO contact (id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone, name) SELECT id, subject, content, is_enabled, created_at, updated_at, deleted_at, email, phone, name FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, from_user_id, to_user_id, subject, content, is_enabled, created_at, updated_at, deleted_at FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id BLOB NOT NULL --(DC2Type:uuid)
        , from_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , to_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_B6BD307F2130303A FOREIGN KEY (from_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F29F6EE60 FOREIGN KEY (to_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, from_user_id, to_user_id, subject, content, is_enabled, created_at, updated_at, deleted_at) SELECT id, from_user_id, to_user_id, subject, content, is_enabled, created_at, updated_at, deleted_at FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F29F6EE60 ON message (to_user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2130303A ON message (from_user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimony AS SELECT id, from_user_id, subject, content, is_enabled, created_at, updated_at, deleted_at, name FROM testimony');
        $this->addSql('DROP TABLE testimony');
        $this->addSql('CREATE TABLE testimony (id BLOB NOT NULL --(DC2Type:uuid)
        , from_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_523C94872130303A FOREIGN KEY (from_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO testimony (id, from_user_id, subject, content, is_enabled, created_at, updated_at, deleted_at, name) SELECT id, from_user_id, subject, content, is_enabled, created_at, updated_at, deleted_at, name FROM __temp__testimony');
        $this->addSql('DROP TABLE __temp__testimony');
        $this->addSql('CREATE INDEX IDX_523C94872130303A ON testimony (from_user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, password, email, name, surname, is_enabled, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id BLOB NOT NULL --(DC2Type:uuid)
        , password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO user (id, password, email, name, surname, is_enabled, created_at, updated_at) SELECT id, password, email, name, surname, is_enabled, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, subject, content, email, phone, is_enabled, deleted_at, created_at, updated_at, name FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id BLOB NOT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO contact (id, subject, content, email, phone, is_enabled, deleted_at, created_at, updated_at, name) SELECT id, subject, content, email, phone, is_enabled, deleted_at, created_at, updated_at, name FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, from_user_id, to_user_id, subject, content, is_enabled, deleted_at, created_at, updated_at FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id BLOB NOT NULL --(DC2Type:uuid)
        , from_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , to_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_B6BD307F2130303A FOREIGN KEY (from_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F29F6EE60 FOREIGN KEY (to_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, from_user_id, to_user_id, subject, content, is_enabled, deleted_at, created_at, updated_at) SELECT id, from_user_id, to_user_id, subject, content, is_enabled, deleted_at, created_at, updated_at FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F2130303A ON message (from_user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F29F6EE60 ON message (to_user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__testimony AS SELECT id, from_user_id, subject, content, is_enabled, deleted_at, created_at, updated_at, name FROM testimony');
        $this->addSql('DROP TABLE testimony');
        $this->addSql('CREATE TABLE testimony (id BLOB NOT NULL --(DC2Type:uuid)
        , from_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_523C94872130303A FOREIGN KEY (from_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO testimony (id, from_user_id, subject, content, is_enabled, deleted_at, created_at, updated_at, name) SELECT id, from_user_id, subject, content, is_enabled, deleted_at, created_at, updated_at, name FROM __temp__testimony');
        $this->addSql('DROP TABLE __temp__testimony');
        $this->addSql('CREATE INDEX IDX_523C94872130303A ON testimony (from_user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, password, email, is_enabled, name, surname, created_at, updated_at FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id BLOB NOT NULL --(DC2Type:uuid)
        , password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , PRIMARY KEY(id))');
        $this->addSql('INSERT INTO "user" (id, password, email, is_enabled, name, surname, created_at, updated_at) SELECT id, password, email, is_enabled, name, surname, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }
}
