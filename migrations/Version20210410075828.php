<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410075828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist ADD command_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D33E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D782112D33E1689A ON playlist (command_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D33E1689A');
        $this->addSql('DROP INDEX UNIQ_D782112D33E1689A ON playlist');
        $this->addSql('ALTER TABLE playlist DROP command_id');
    }
}
