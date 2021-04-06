<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406191803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD472F5A1AA');
        $this->addSql('ALTER TABLE user_channel DROP FOREIGN KEY FK_FAF4904D72F5A1AA');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, conversation_id VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, creator_id VARCHAR(255) DEFAULT NULL, is_archived TINYINT(1) DEFAULT NULL, is_channel TINYINT(1) DEFAULT NULL, is_ext_shared TINYINT(1) DEFAULT NULL, is_frozen TINYINT(1) DEFAULT NULL, is_general TINYINT(1) DEFAULT NULL, is_global_shared TINYINT(1) DEFAULT NULL, is_group TINYINT(1) DEFAULT NULL, is_im TINYINT(1) DEFAULT NULL, is_moved TINYINT(1) DEFAULT NULL, is_mpim TINYINT(1) DEFAULT NULL, is_non_threadable TINYINT(1) DEFAULT NULL, is_open TINYINT(1) DEFAULT NULL, is_org_default TINYINT(1) DEFAULT NULL, is_private TINYINT(1) DEFAULT NULL, is_shared TINYINT(1) DEFAULT NULL, purpose LONGTEXT DEFAULT NULL, topic LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation_team (conversation_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_139FC5039AC0396 (conversation_id), INDEX IDX_139FC503296CD8AE (team_id), PRIMARY KEY(conversation_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_conversation (user_id INT NOT NULL, conversation_id INT NOT NULL, INDEX IDX_A425AEBA76ED395 (user_id), INDEX IDX_A425AEB9AC0396 (conversation_id), PRIMARY KEY(user_id, conversation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation_team ADD CONSTRAINT FK_139FC5039AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_team ADD CONSTRAINT FK_139FC503296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_conversation ADD CONSTRAINT FK_A425AEBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_conversation ADD CONSTRAINT FK_A425AEB9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE user_channel');
        $this->addSql('DROP INDEX IDX_8ECAEAD472F5A1AA ON command');
        $this->addSql('ALTER TABLE command CHANGE channel_id conversation_id INT NOT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD49AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD49AC0396 ON command (conversation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD49AC0396');
        $this->addSql('ALTER TABLE conversation_team DROP FOREIGN KEY FK_139FC5039AC0396');
        $this->addSql('ALTER TABLE user_conversation DROP FOREIGN KEY FK_A425AEB9AC0396');
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, channel_id VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A2F98E47296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_channel (user_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_FAF4904D72F5A1AA (channel_id), INDEX IDX_FAF4904DA76ED395 (user_id), PRIMARY KEY(user_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE user_channel ADD CONSTRAINT FK_FAF4904D72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_channel ADD CONSTRAINT FK_FAF4904DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE conversation_team');
        $this->addSql('DROP TABLE user_conversation');
        $this->addSql('DROP INDEX IDX_8ECAEAD49AC0396 ON command');
        $this->addSql('ALTER TABLE command CHANGE conversation_id channel_id INT NOT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD472F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD472F5A1AA ON command (channel_id)');
    }
}
