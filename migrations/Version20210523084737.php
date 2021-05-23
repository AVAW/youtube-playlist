<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523084737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX email_idx ON google_user');
        $this->addSql('CREATE INDEX idx_email ON google_user (email)');
        $this->addSql('DROP INDEX identifier_idx ON playlist');
        $this->addSql('CREATE INDEX idx_identifier ON playlist (identifier)');
        $this->addSql('DROP INDEX identifier_idx ON playlist_play');
        $this->addSql('CREATE INDEX idx_identifier ON playlist_play (identifier)');
        $this->addSql('CREATE INDEX idx_identifier ON playlist_video (identifier)');
        $this->addSql('CREATE INDEX idx_identifier ON slack_action (identifier)');
        $this->addSql('DROP INDEX identifier_idx ON slack_command');
        $this->addSql('CREATE INDEX idx_identifier ON slack_command (identifier)');
        $this->addSql('DROP INDEX identifier_idx ON slack_conversation');
        $this->addSql('CREATE INDEX idx_identifier ON slack_conversation (identifier)');
        $this->addSql('DROP INDEX identifier_idx ON slack_conversation_playlist');
        $this->addSql('CREATE INDEX idx_identifier ON slack_conversation_playlist (identifier)');
        $this->addSql('DROP INDEX identifier_idx ON slack_team');
        $this->addSql('CREATE INDEX idx_identifier ON slack_team (identifier)');
        $this->addSql('DROP INDEX email_idx ON slack_user');
        $this->addSql('CREATE INDEX idx_email ON slack_user (email)');
        $this->addSql('DROP INDEX email_idx ON user');
        $this->addSql('CREATE INDEX idx_email ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_email ON google_user');
        $this->addSql('CREATE INDEX email_idx ON google_user (email)');
        $this->addSql('DROP INDEX idx_identifier ON playlist');
        $this->addSql('CREATE INDEX identifier_idx ON playlist (identifier)');
        $this->addSql('DROP INDEX idx_identifier ON playlist_play');
        $this->addSql('CREATE INDEX identifier_idx ON playlist_play (identifier)');
        $this->addSql('DROP INDEX idx_identifier ON playlist_video');
        $this->addSql('DROP INDEX idx_identifier ON slack_action');
        $this->addSql('DROP INDEX idx_identifier ON slack_command');
        $this->addSql('CREATE INDEX identifier_idx ON slack_command (identifier)');
        $this->addSql('DROP INDEX idx_identifier ON slack_conversation');
        $this->addSql('CREATE INDEX identifier_idx ON slack_conversation (identifier)');
        $this->addSql('DROP INDEX idx_identifier ON slack_conversation_playlist');
        $this->addSql('CREATE INDEX identifier_idx ON slack_conversation_playlist (identifier)');
        $this->addSql('DROP INDEX idx_identifier ON slack_team');
        $this->addSql('CREATE INDEX identifier_idx ON slack_team (identifier)');
        $this->addSql('DROP INDEX idx_email ON slack_user');
        $this->addSql('CREATE INDEX email_idx ON slack_user (email)');
        $this->addSql('DROP INDEX idx_email ON user');
        $this->addSql('CREATE INDEX email_idx ON user (email)');
    }
}
