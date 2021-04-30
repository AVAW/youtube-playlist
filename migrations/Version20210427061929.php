<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427061929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, client_ip VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE google_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', profile_id VARCHAR(255) NOT NULL, displayed_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, picture VARCHAR(1024) DEFAULT NULL, email_verified TINYINT(1) DEFAULT NULL, locale VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_69CB634AA76ED395 (user_id), INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', url VARCHAR(1024) NOT NULL, youtube_id VARCHAR(64) NOT NULL, published_at DATETIME DEFAULT NULL, title VARCHAR(1024) DEFAULT NULL, description VARCHAR(2048) DEFAULT NULL, channel_title VARCHAR(255) DEFAULT NULL, videos_amount INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX identifier_idx (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_play (id INT AUTO_INCREMENT NOT NULL, playlist_id INT NOT NULL, video_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_FE90E9D86BBD148 (playlist_id), INDEX IDX_FE90E9D829C1004E (video_id), INDEX identifier_idx (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_video (id INT AUTO_INCREMENT NOT NULL, playlist_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', video_id VARCHAR(255) NOT NULL, title VARCHAR(512) NOT NULL, published_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_DFDBC36F6BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_video_slack_user (playlist_video_id INT NOT NULL, slack_user_id INT NOT NULL, INDEX IDX_EC9BE0A6D41CC623 (playlist_video_id), INDEX IDX_EC9BE0A6E6AA7332 (slack_user_id), PRIMARY KEY(playlist_video_id, slack_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_command (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, text VARCHAR(1024) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_CF0E4A73296CD8AE (team_id), INDEX IDX_CF0E4A739AC0396 (conversation_id), INDEX IDX_CF0E4A73A76ED395 (user_id), INDEX identifier_idx (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_conversation (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', conversation_id VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, creator_id VARCHAR(255) DEFAULT NULL, is_archived TINYINT(1) DEFAULT NULL, is_channel TINYINT(1) DEFAULT NULL, is_ext_shared TINYINT(1) DEFAULT NULL, is_frozen TINYINT(1) DEFAULT NULL, is_general TINYINT(1) DEFAULT NULL, is_global_shared TINYINT(1) DEFAULT NULL, is_group TINYINT(1) DEFAULT NULL, is_im TINYINT(1) DEFAULT NULL, is_moved TINYINT(1) DEFAULT NULL, is_mpim TINYINT(1) DEFAULT NULL, is_non_threadable TINYINT(1) DEFAULT NULL, is_open TINYINT(1) DEFAULT NULL, is_org_default TINYINT(1) DEFAULT NULL, is_private TINYINT(1) DEFAULT NULL, is_shared TINYINT(1) DEFAULT NULL, purpose LONGTEXT DEFAULT NULL, topic LONGTEXT DEFAULT NULL, locale VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX identifier_idx (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_conversation_slack_team (slack_conversation_id INT NOT NULL, slack_team_id INT NOT NULL, INDEX IDX_5702F7D1651336 (slack_conversation_id), INDEX IDX_5702F7D68A87809 (slack_team_id), PRIMARY KEY(slack_conversation_id, slack_team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_conversation_playlist (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, playlist_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4B66D8659AC0396 (conversation_id), INDEX IDX_4B66D8656BBD148 (playlist_id), INDEX identifier_idx (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_team (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', team_id VARCHAR(64) NOT NULL, domain VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, email_domain VARCHAR(255) DEFAULT NULL, icon_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX identifier_idx (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_user (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, presence_id INT DEFAULT NULL, user_id INT DEFAULT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) DEFAULT NULL, profile_id VARCHAR(64) NOT NULL, name VARCHAR(255) DEFAULT NULL, real_name VARCHAR(255) DEFAULT NULL, displayed_name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, image_original_url VARCHAR(1024) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, is_admin TINYINT(1) DEFAULT NULL, is_app_user TINYINT(1) DEFAULT NULL, is_bot TINYINT(1) DEFAULT NULL, is_external TINYINT(1) DEFAULT NULL, is_forgotten TINYINT(1) DEFAULT NULL, is_invited_user TINYINT(1) DEFAULT NULL, is_owner TINYINT(1) DEFAULT NULL, is_primary_owner TINYINT(1) DEFAULT NULL, is_restricted TINYINT(1) DEFAULT NULL, is_stranger TINYINT(1) DEFAULT NULL, is_ultra_restricted TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_961B7CD6296CD8AE (team_id), UNIQUE INDEX UNIQ_961B7CD6F328FFC4 (presence_id), INDEX IDX_961B7CD6A76ED395 (user_id), INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_user_slack_conversation (slack_user_id INT NOT NULL, slack_conversation_id INT NOT NULL, INDEX IDX_1D66A5B6E6AA7332 (slack_user_id), INDEX IDX_1D66A5B61651336 (slack_conversation_id), PRIMARY KEY(slack_user_id, slack_conversation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slack_user_presence (id INT AUTO_INCREMENT NOT NULL, auto_away TINYINT(1) DEFAULT NULL, connection_count INT DEFAULT NULL, manual_away TINYINT(1) DEFAULT NULL, online TINYINT(1) DEFAULT NULL, presence VARCHAR(255) DEFAULT NULL, last_activity DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, login VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE google_user ADD CONSTRAINT FK_69CB634AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_play ADD CONSTRAINT FK_FE90E9D86BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_play ADD CONSTRAINT FK_FE90E9D829C1004E FOREIGN KEY (video_id) REFERENCES playlist_video (id)');
        $this->addSql('ALTER TABLE playlist_video ADD CONSTRAINT FK_DFDBC36F6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_video_slack_user ADD CONSTRAINT FK_EC9BE0A6D41CC623 FOREIGN KEY (playlist_video_id) REFERENCES playlist_video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_video_slack_user ADD CONSTRAINT FK_EC9BE0A6E6AA7332 FOREIGN KEY (slack_user_id) REFERENCES slack_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE slack_command ADD CONSTRAINT FK_CF0E4A73296CD8AE FOREIGN KEY (team_id) REFERENCES slack_team (id)');
        $this->addSql('ALTER TABLE slack_command ADD CONSTRAINT FK_CF0E4A739AC0396 FOREIGN KEY (conversation_id) REFERENCES slack_conversation (id)');
        $this->addSql('ALTER TABLE slack_command ADD CONSTRAINT FK_CF0E4A73A76ED395 FOREIGN KEY (user_id) REFERENCES slack_user (id)');
        $this->addSql('ALTER TABLE slack_conversation_slack_team ADD CONSTRAINT FK_5702F7D1651336 FOREIGN KEY (slack_conversation_id) REFERENCES slack_conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slack_conversation_slack_team ADD CONSTRAINT FK_5702F7D68A87809 FOREIGN KEY (slack_team_id) REFERENCES slack_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slack_conversation_playlist ADD CONSTRAINT FK_4B66D8659AC0396 FOREIGN KEY (conversation_id) REFERENCES slack_conversation (id)');
        $this->addSql('ALTER TABLE slack_conversation_playlist ADD CONSTRAINT FK_4B66D8656BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE slack_user ADD CONSTRAINT FK_961B7CD6296CD8AE FOREIGN KEY (team_id) REFERENCES slack_team (id)');
        $this->addSql('ALTER TABLE slack_user ADD CONSTRAINT FK_961B7CD6F328FFC4 FOREIGN KEY (presence_id) REFERENCES slack_user_presence (id)');
        $this->addSql('ALTER TABLE slack_user ADD CONSTRAINT FK_961B7CD6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE slack_user_slack_conversation ADD CONSTRAINT FK_1D66A5B6E6AA7332 FOREIGN KEY (slack_user_id) REFERENCES slack_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slack_user_slack_conversation ADD CONSTRAINT FK_1D66A5B61651336 FOREIGN KEY (slack_conversation_id) REFERENCES slack_conversation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist_play DROP FOREIGN KEY FK_FE90E9D86BBD148');
        $this->addSql('ALTER TABLE playlist_video DROP FOREIGN KEY FK_DFDBC36F6BBD148');
        $this->addSql('ALTER TABLE slack_conversation_playlist DROP FOREIGN KEY FK_4B66D8656BBD148');
        $this->addSql('ALTER TABLE playlist_play DROP FOREIGN KEY FK_FE90E9D829C1004E');
        $this->addSql('ALTER TABLE playlist_video_slack_user DROP FOREIGN KEY FK_EC9BE0A6D41CC623');
        $this->addSql('ALTER TABLE slack_command DROP FOREIGN KEY FK_CF0E4A739AC0396');
        $this->addSql('ALTER TABLE slack_conversation_slack_team DROP FOREIGN KEY FK_5702F7D1651336');
        $this->addSql('ALTER TABLE slack_conversation_playlist DROP FOREIGN KEY FK_4B66D8659AC0396');
        $this->addSql('ALTER TABLE slack_user_slack_conversation DROP FOREIGN KEY FK_1D66A5B61651336');
        $this->addSql('ALTER TABLE slack_command DROP FOREIGN KEY FK_CF0E4A73296CD8AE');
        $this->addSql('ALTER TABLE slack_conversation_slack_team DROP FOREIGN KEY FK_5702F7D68A87809');
        $this->addSql('ALTER TABLE slack_user DROP FOREIGN KEY FK_961B7CD6296CD8AE');
        $this->addSql('ALTER TABLE playlist_video_slack_user DROP FOREIGN KEY FK_EC9BE0A6E6AA7332');
        $this->addSql('ALTER TABLE slack_command DROP FOREIGN KEY FK_CF0E4A73A76ED395');
        $this->addSql('ALTER TABLE slack_user_slack_conversation DROP FOREIGN KEY FK_1D66A5B6E6AA7332');
        $this->addSql('ALTER TABLE slack_user DROP FOREIGN KEY FK_961B7CD6F328FFC4');
        $this->addSql('ALTER TABLE google_user DROP FOREIGN KEY FK_69CB634AA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE slack_user DROP FOREIGN KEY FK_961B7CD6A76ED395');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE google_user');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_play');
        $this->addSql('DROP TABLE playlist_video');
        $this->addSql('DROP TABLE playlist_video_slack_user');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE slack_command');
        $this->addSql('DROP TABLE slack_conversation');
        $this->addSql('DROP TABLE slack_conversation_slack_team');
        $this->addSql('DROP TABLE slack_conversation_playlist');
        $this->addSql('DROP TABLE slack_team');
        $this->addSql('DROP TABLE slack_user');
        $this->addSql('DROP TABLE slack_user_slack_conversation');
        $this->addSql('DROP TABLE slack_user_presence');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
