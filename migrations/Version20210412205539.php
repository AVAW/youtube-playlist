<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412205539 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversation_playlist_video (id INT AUTO_INCREMENT NOT NULL, conversation_playlist_id INT NOT NULL, current_video_id INT DEFAULT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_9CB3A19FE8A4AC38 (conversation_playlist_id), UNIQUE INDEX UNIQ_9CB3A19FB4B97A64 (current_video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation_playlist_video ADD CONSTRAINT FK_9CB3A19FE8A4AC38 FOREIGN KEY (conversation_playlist_id) REFERENCES conversation_playlist (id)');
        $this->addSql('ALTER TABLE conversation_playlist_video ADD CONSTRAINT FK_9CB3A19FB4B97A64 FOREIGN KEY (current_video_id) REFERENCES playlist_video (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE conversation_playlist_video');
    }
}
