<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407204629 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, text VARCHAR(1024) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8ECAEAD4296CD8AE (team_id), INDEX IDX_8ECAEAD49AC0396 (conversation_id), INDEX IDX_8ECAEAD4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, client_ip VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, conversation_id VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, creator_id VARCHAR(255) DEFAULT NULL, is_archived TINYINT(1) DEFAULT NULL, is_channel TINYINT(1) DEFAULT NULL, is_ext_shared TINYINT(1) DEFAULT NULL, is_frozen TINYINT(1) DEFAULT NULL, is_general TINYINT(1) DEFAULT NULL, is_global_shared TINYINT(1) DEFAULT NULL, is_group TINYINT(1) DEFAULT NULL, is_im TINYINT(1) DEFAULT NULL, is_moved TINYINT(1) DEFAULT NULL, is_mpim TINYINT(1) DEFAULT NULL, is_non_threadable TINYINT(1) DEFAULT NULL, is_open TINYINT(1) DEFAULT NULL, is_org_default TINYINT(1) DEFAULT NULL, is_private TINYINT(1) DEFAULT NULL, is_shared TINYINT(1) DEFAULT NULL, purpose LONGTEXT DEFAULT NULL, topic LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation_team (conversation_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_139FC5039AC0396 (conversation_id), INDEX IDX_139FC503296CD8AE (team_id), PRIMARY KEY(conversation_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', url VARCHAR(1024) NOT NULL, youtube_id VARCHAR(64) NOT NULL, published_at DATETIME DEFAULT NULL, title VARCHAR(1024) DEFAULT NULL, description VARCHAR(2048) DEFAULT NULL, channel_title VARCHAR(255) DEFAULT NULL, videos_amount INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, team_id VARCHAR(64) NOT NULL, domain VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, email_domain VARCHAR(255) DEFAULT NULL, icon_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, presence_id INT DEFAULT NULL, user_id VARCHAR(64) NOT NULL, name VARCHAR(255) DEFAULT NULL, real_name VARCHAR(255) DEFAULT NULL, displayed_name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, image_original_url VARCHAR(1024) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8D93D649296CD8AE (team_id), UNIQUE INDEX UNIQ_8D93D649F328FFC4 (presence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_conversation (user_id INT NOT NULL, conversation_id INT NOT NULL, INDEX IDX_A425AEBA76ED395 (user_id), INDEX IDX_A425AEB9AC0396 (conversation_id), PRIMARY KEY(user_id, conversation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_presence (id INT AUTO_INCREMENT NOT NULL, auto_away TINYINT(1) DEFAULT NULL, connection_count INT DEFAULT NULL, manual_away TINYINT(1) DEFAULT NULL, online TINYINT(1) DEFAULT NULL, presence VARCHAR(255) DEFAULT NULL, last_activity DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD49AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation_team ADD CONSTRAINT FK_139FC5039AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_team ADD CONSTRAINT FK_139FC503296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F328FFC4 FOREIGN KEY (presence_id) REFERENCES user_presence (id)');
        $this->addSql('ALTER TABLE user_conversation ADD CONSTRAINT FK_A425AEBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_conversation ADD CONSTRAINT FK_A425AEB9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD49AC0396');
        $this->addSql('ALTER TABLE conversation_team DROP FOREIGN KEY FK_139FC5039AC0396');
        $this->addSql('ALTER TABLE user_conversation DROP FOREIGN KEY FK_A425AEB9AC0396');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4296CD8AE');
        $this->addSql('ALTER TABLE conversation_team DROP FOREIGN KEY FK_139FC503296CD8AE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649296CD8AE');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4A76ED395');
        $this->addSql('ALTER TABLE user_conversation DROP FOREIGN KEY FK_A425AEBA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F328FFC4');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE conversation_team');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_conversation');
        $this->addSql('DROP TABLE user_presence');
    }
}
