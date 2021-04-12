<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410130531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, text VARCHAR(1024) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8ECAEAD4296CD8AE (team_id), INDEX IDX_8ECAEAD49AC0396 (conversation_id), INDEX IDX_8ECAEAD4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, client_ip VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', conversation_id VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, creator_id VARCHAR(255) DEFAULT NULL, is_archived TINYINT(1) DEFAULT NULL, is_channel TINYINT(1) DEFAULT NULL, is_ext_shared TINYINT(1) DEFAULT NULL, is_frozen TINYINT(1) DEFAULT NULL, is_general TINYINT(1) DEFAULT NULL, is_global_shared TINYINT(1) DEFAULT NULL, is_group TINYINT(1) DEFAULT NULL, is_im TINYINT(1) DEFAULT NULL, is_moved TINYINT(1) DEFAULT NULL, is_mpim TINYINT(1) DEFAULT NULL, is_non_threadable TINYINT(1) DEFAULT NULL, is_open TINYINT(1) DEFAULT NULL, is_org_default TINYINT(1) DEFAULT NULL, is_private TINYINT(1) DEFAULT NULL, is_shared TINYINT(1) DEFAULT NULL, purpose LONGTEXT DEFAULT NULL, topic LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation_team (conversation_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_139FC5039AC0396 (conversation_id), INDEX IDX_139FC503296CD8AE (team_id), PRIMARY KEY(conversation_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation_playlist (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, playlist_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_37CCAE3D9AC0396 (conversation_id), INDEX IDX_37CCAE3D6BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, command_id INT DEFAULT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', url VARCHAR(1024) NOT NULL, youtube_id VARCHAR(64) NOT NULL, published_at DATETIME DEFAULT NULL, title VARCHAR(1024) DEFAULT NULL, description VARCHAR(2048) DEFAULT NULL, channel_title VARCHAR(255) DEFAULT NULL, videos_amount INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D782112D33E1689A (command_id), INDEX identifier_index (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_video (id INT AUTO_INCREMENT NOT NULL, playlist_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', video_id VARCHAR(255) NOT NULL, title VARCHAR(512) NOT NULL, published_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_DFDBC36F6BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_video_user (playlist_video_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_28500427D41CC623 (playlist_video_id), INDEX IDX_28500427A76ED395 (user_id), PRIMARY KEY(playlist_video_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', team_id VARCHAR(64) NOT NULL, domain VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, email_domain VARCHAR(255) DEFAULT NULL, icon_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, presence_id INT DEFAULT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_id VARCHAR(64) NOT NULL, name VARCHAR(255) DEFAULT NULL, real_name VARCHAR(255) DEFAULT NULL, displayed_name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, image_original_url VARCHAR(1024) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, is_admin TINYINT(1) DEFAULT NULL, is_app_user TINYINT(1) DEFAULT NULL, is_bot TINYINT(1) DEFAULT NULL, is_external TINYINT(1) DEFAULT NULL, is_forgotten TINYINT(1) DEFAULT NULL, is_invited_user TINYINT(1) DEFAULT NULL, is_owner TINYINT(1) DEFAULT NULL, is_primary_owner TINYINT(1) DEFAULT NULL, is_restricted TINYINT(1) DEFAULT NULL, is_stranger TINYINT(1) DEFAULT NULL, is_ultra_restricted TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8D93D649296CD8AE (team_id), UNIQUE INDEX UNIQ_8D93D649F328FFC4 (presence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_conversation (user_id INT NOT NULL, conversation_id INT NOT NULL, INDEX IDX_A425AEBA76ED395 (user_id), INDEX IDX_A425AEB9AC0396 (conversation_id), PRIMARY KEY(user_id, conversation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_presence (id INT AUTO_INCREMENT NOT NULL, auto_away TINYINT(1) DEFAULT NULL, connection_count INT DEFAULT NULL, manual_away TINYINT(1) DEFAULT NULL, online TINYINT(1) DEFAULT NULL, presence VARCHAR(255) DEFAULT NULL, last_activity DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD49AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation_team ADD CONSTRAINT FK_139FC5039AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_team ADD CONSTRAINT FK_139FC503296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_playlist ADD CONSTRAINT FK_37CCAE3D9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE conversation_playlist ADD CONSTRAINT FK_37CCAE3D6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D33E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE playlist_video ADD CONSTRAINT FK_DFDBC36F6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_video_user ADD CONSTRAINT FK_28500427D41CC623 FOREIGN KEY (playlist_video_id) REFERENCES playlist_video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_video_user ADD CONSTRAINT FK_28500427A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F328FFC4 FOREIGN KEY (presence_id) REFERENCES user_presence (id)');
        $this->addSql('ALTER TABLE user_conversation ADD CONSTRAINT FK_A425AEBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_conversation ADD CONSTRAINT FK_A425AEB9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D33E1689A');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD49AC0396');
        $this->addSql('ALTER TABLE conversation_team DROP FOREIGN KEY FK_139FC5039AC0396');
        $this->addSql('ALTER TABLE conversation_playlist DROP FOREIGN KEY FK_37CCAE3D9AC0396');
        $this->addSql('ALTER TABLE user_conversation DROP FOREIGN KEY FK_A425AEB9AC0396');
        $this->addSql('ALTER TABLE conversation_playlist DROP FOREIGN KEY FK_37CCAE3D6BBD148');
        $this->addSql('ALTER TABLE playlist_video DROP FOREIGN KEY FK_DFDBC36F6BBD148');
        $this->addSql('ALTER TABLE playlist_video_user DROP FOREIGN KEY FK_28500427D41CC623');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4296CD8AE');
        $this->addSql('ALTER TABLE conversation_team DROP FOREIGN KEY FK_139FC503296CD8AE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649296CD8AE');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4A76ED395');
        $this->addSql('ALTER TABLE playlist_video_user DROP FOREIGN KEY FK_28500427A76ED395');
        $this->addSql('ALTER TABLE user_conversation DROP FOREIGN KEY FK_A425AEBA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F328FFC4');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE conversation_team');
        $this->addSql('DROP TABLE conversation_playlist');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_video');
        $this->addSql('DROP TABLE playlist_video_user');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_conversation');
        $this->addSql('DROP TABLE user_presence');
    }
}