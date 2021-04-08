<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407212139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD is_admin TINYINT(1) DEFAULT NULL, ADD is_app_user TINYINT(1) DEFAULT NULL, ADD is_bot TINYINT(1) DEFAULT NULL, ADD is_external TINYINT(1) DEFAULT NULL, ADD is_forgotten TINYINT(1) DEFAULT NULL, ADD is_invited_user TINYINT(1) DEFAULT NULL, ADD is_owner TINYINT(1) DEFAULT NULL, ADD is_primary_owner TINYINT(1) DEFAULT NULL, ADD is_restricted TINYINT(1) DEFAULT NULL, ADD is_stranger TINYINT(1) DEFAULT NULL, ADD is_ultra_restricted TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP is_admin, DROP is_app_user, DROP is_bot, DROP is_external, DROP is_forgotten, DROP is_invited_user, DROP is_owner, DROP is_primary_owner, DROP is_restricted, DROP is_stranger, DROP is_ultra_restricted');
    }
}
