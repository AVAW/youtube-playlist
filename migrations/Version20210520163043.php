<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520163043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE playlist_video_user (playlist_video_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_28500427D41CC623 (playlist_video_id), INDEX IDX_28500427A76ED395 (user_id), PRIMARY KEY(playlist_video_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE playlist_video_user ADD CONSTRAINT FK_28500427D41CC623 FOREIGN KEY (playlist_video_id) REFERENCES playlist_video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_video_user ADD CONSTRAINT FK_28500427A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE playlist_video_slack_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE playlist_video_slack_user (playlist_video_id INT NOT NULL, slack_user_id INT NOT NULL, INDEX IDX_EC9BE0A6E6AA7332 (slack_user_id), INDEX IDX_EC9BE0A6D41CC623 (playlist_video_id), PRIMARY KEY(playlist_video_id, slack_user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE playlist_video_slack_user ADD CONSTRAINT FK_EC9BE0A6D41CC623 FOREIGN KEY (playlist_video_id) REFERENCES playlist_video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_video_slack_user ADD CONSTRAINT FK_EC9BE0A6E6AA7332 FOREIGN KEY (slack_user_id) REFERENCES slack_user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE playlist_video_user');
    }
}
