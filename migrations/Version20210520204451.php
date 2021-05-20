<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520204451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D25576DBD');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D25576DBD FOREIGN KEY (play_id) REFERENCES playlist_play (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_video ADD video_owner_channel_id VARCHAR(255) DEFAULT NULL, ADD video_owner_channel_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE slack_conversation_playlist DROP FOREIGN KEY FK_4B66D8656BBD148');
        $this->addSql('ALTER TABLE slack_conversation_playlist ADD CONSTRAINT FK_4B66D8656BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D25576DBD');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D25576DBD FOREIGN KEY (play_id) REFERENCES playlist_play (id)');
        $this->addSql('ALTER TABLE playlist_video DROP video_owner_channel_id, DROP video_owner_channel_title');
        $this->addSql('ALTER TABLE slack_conversation_playlist DROP FOREIGN KEY FK_4B66D8656BBD148');
        $this->addSql('ALTER TABLE slack_conversation_playlist ADD CONSTRAINT FK_4B66D8656BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
    }
}
