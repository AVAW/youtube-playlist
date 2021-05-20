<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520204848 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D25576DBD');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D25576DBD FOREIGN KEY (play_id) REFERENCES playlist_play (id)');
        $this->addSql('ALTER TABLE playlist_play ADD playlist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist_play ADD CONSTRAINT FK_FE90E9D86BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE90E9D86BBD148 ON playlist_play (playlist_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D25576DBD');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D25576DBD FOREIGN KEY (play_id) REFERENCES playlist_play (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_play DROP FOREIGN KEY FK_FE90E9D86BBD148');
        $this->addSql('DROP INDEX UNIQ_FE90E9D86BBD148 ON playlist_play');
        $this->addSql('ALTER TABLE playlist_play DROP playlist_id');
    }
}
