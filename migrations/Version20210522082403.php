<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522082403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slack_action (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, identifier BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', action_id VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, trigger_id VARCHAR(255) NOT NULL, enterprise TINYINT(1) DEFAULT NULL, is_enterprise_install TINYINT(1) NOT NULL, response_url VARCHAR(1023) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_87164B39296CD8AE (team_id), INDEX IDX_87164B399AC0396 (conversation_id), INDEX IDX_87164B39A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slack_action ADD CONSTRAINT FK_87164B39296CD8AE FOREIGN KEY (team_id) REFERENCES slack_team (id)');
        $this->addSql('ALTER TABLE slack_action ADD CONSTRAINT FK_87164B399AC0396 FOREIGN KEY (conversation_id) REFERENCES slack_conversation (id)');
        $this->addSql('ALTER TABLE slack_action ADD CONSTRAINT FK_87164B39A76ED395 FOREIGN KEY (user_id) REFERENCES slack_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE slack_action');
    }
}
