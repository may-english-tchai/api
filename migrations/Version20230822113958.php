<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822113958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability (id BLOB NOT NULL --(DC2Type:uuid)
        , restaurant_id BLOB NOT NULL --(DC2Type:uuid)
        , teacher_id BLOB NOT NULL --(DC2Type:uuid)
        , language_id BLOB NOT NULL --(DC2Type:uuid)
        , status_id BLOB NOT NULL --(DC2Type:uuid)
        , start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , duration INTEGER DEFAULT 60 NOT NULL, capacity INTEGER DEFAULT NULL, comment CLOB DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, price DOUBLE PRECISION NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_3FB7A2BFB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3FB7A2BF6BF700BD FOREIGN KEY (status_id) REFERENCES availability_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFB1E7706E ON availability (restaurant_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF41807E1D ON availability (teacher_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF82F1BAF4 ON availability (language_id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BF6BF700BD ON availability (status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3FB7A2BF9F79558F41807E1D ON availability (start, teacher_id)');
        $this->addSql('CREATE TABLE availability_status (id BLOB NOT NULL --(DC2Type:uuid)
        , code VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A7531C077153098 ON availability_status (code)');
        $this->addSql('CREATE TABLE config (id BLOB NOT NULL --(DC2Type:uuid)
        , name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D48A2F7C5E237E06 ON config (name)');
        $this->addSql('CREATE TABLE contact (id BLOB NOT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE language (id BLOB NOT NULL --(DC2Type:uuid)
        , code VARCHAR(255) NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4DB71B577153098 ON language (code)');
        $this->addSql('CREATE TABLE language_teacher (language_id BLOB NOT NULL --(DC2Type:uuid)
        , teacher_id BLOB NOT NULL --(DC2Type:uuid)
        , PRIMARY KEY(language_id, teacher_id), CONSTRAINT FK_143B718182F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_143B718141807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_143B718182F1BAF4 ON language_teacher (language_id)');
        $this->addSql('CREATE INDEX IDX_143B718141807E1D ON language_teacher (teacher_id)');
        $this->addSql('CREATE TABLE message (id BLOB NOT NULL --(DC2Type:uuid)
        , from_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , to_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_B6BD307F2130303A FOREIGN KEY (from_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F29F6EE60 FOREIGN KEY (to_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2130303A ON message (from_user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F29F6EE60 ON message (to_user_id)');
        $this->addSql('CREATE TABLE notification (id BLOB NOT NULL --(DC2Type:uuid)
        , to_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, event VARCHAR(255) NOT NULL, read_at DATETIME DEFAULT NULL, archived_at DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_BF5476CA29F6EE60 FOREIGN KEY (to_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BF5476CA29F6EE60 ON notification (to_user_id)');
        $this->addSql('CREATE TABLE participation (id BLOB NOT NULL --(DC2Type:uuid)
        , user_id BLOB NOT NULL --(DC2Type:uuid)
        , availability_id BLOB NOT NULL --(DC2Type:uuid)
        , note INTEGER DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, comment CLOB DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AB55E24F61778466 FOREIGN KEY (availability_id) REFERENCES availability (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AB55E24FA76ED395 ON participation (user_id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F61778466 ON participation (availability_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB55E24F61778466A76ED395 ON participation (availability_id, user_id)');
        $this->addSql('CREATE TABLE payment (id BLOB NOT NULL --(DC2Type:uuid)
        , participation_id BLOB NOT NULL --(DC2Type:uuid)
        , status VARCHAR(255) NOT NULL, reference VARCHAR(255) DEFAULT NULL, data CLOB NOT NULL --(DC2Type:json)
        , amount DOUBLE PRECISION NOT NULL, comment CLOB DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_6D28840D6ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6D28840D6ACE3B73 ON payment (participation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840DAEA34913 ON payment (reference)');
        $this->addSql('CREATE TABLE refresh_token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74F2195C74F2195 ON refresh_token (refresh_token)');
        $this->addSql('CREATE TABLE restaurant (id BLOB NOT NULL --(DC2Type:uuid)
        , address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postcode VARCHAR(10) DEFAULT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, name VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123F5E237E06 ON restaurant (name)');
        $this->addSql('CREATE TABLE role (id BLOB NOT NULL --(DC2Type:uuid)
        , code VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57698A6A77153098 ON role (code)');
        $this->addSql('CREATE TABLE teacher (id BLOB NOT NULL --(DC2Type:uuid)
        , email VARCHAR(255) NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, name VARCHAR(255) NOT NULL, deleted_at DATETIME DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0F6A6D5E7927C74 ON teacher (email)');
        $this->addSql('CREATE TABLE testimony (id BLOB NOT NULL --(DC2Type:uuid)
        , from_user_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , subject VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_523C94872130303A FOREIGN KEY (from_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_523C94872130303A ON testimony (from_user_id)');
        $this->addSql('CREATE TABLE "user" (id BLOB NOT NULL --(DC2Type:uuid)
        , password VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, is_enabled BOOLEAN DEFAULT 1 NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE user_role (user_id BLOB NOT NULL --(DC2Type:uuid)
        , role_id BLOB NOT NULL --(DC2Type:uuid)
        , PRIMARY KEY(user_id, role_id), CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3A76ED395 ON user_role (user_id)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3D60322AC ON user_role (role_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE availability_status');
        $this->addSql('DROP TABLE config');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE language_teacher');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE testimony');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
