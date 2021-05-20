<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520205225 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist_play DROP FOREIGN KEY FK_FE90E9D829C1004E');
        $this->addSql('ALTER TABLE playlist_play ADD CONSTRAINT FK_FE90E9D829C1004E FOREIGN KEY (video_id) REFERENCES playlist_video (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist_play DROP FOREIGN KEY FK_FE90E9D829C1004E');
        $this->addSql('ALTER TABLE playlist_play ADD CONSTRAINT FK_FE90E9D829C1004E FOREIGN KEY (video_id) REFERENCES playlist_video (id)');
    }
}
