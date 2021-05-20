<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520204944 extends AbstractMigration
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
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D25576DBD');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D25576DBD FOREIGN KEY (play_id) REFERENCES playlist_play (id)');
    }
}
