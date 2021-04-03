<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401205447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist ADD uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', CHANGE id id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D782112DD17F50A6 ON playlist (uuid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_D782112DD17F50A6 ON playlist');
        $this->addSql('ALTER TABLE playlist DROP uuid, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}