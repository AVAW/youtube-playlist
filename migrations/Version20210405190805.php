<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405190805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_channel (user_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_FAF4904DA76ED395 (user_id), INDEX IDX_FAF4904D72F5A1AA (channel_id), PRIMARY KEY(user_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_presence (id INT AUTO_INCREMENT NOT NULL, auto_away TINYINT(1) DEFAULT NULL, connection_count INT DEFAULT NULL, manual_away TINYINT(1) DEFAULT NULL, online TINYINT(1) DEFAULT NULL, presence VARCHAR(255) DEFAULT NULL, last_activity DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_channel ADD CONSTRAINT FK_FAF4904DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_channel ADD CONSTRAINT FK_FAF4904D72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE channel ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_A2F98E47296CD8AE ON channel (team_id)');
        $this->addSql('ALTER TABLE team ADD name VARCHAR(255) DEFAULT NULL, ADD email_domain VARCHAR(255) DEFAULT NULL, ADD icon_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD team_id INT DEFAULT NULL, ADD presence_id INT DEFAULT NULL, ADD real_name VARCHAR(255) DEFAULT NULL, ADD displayed_name VARCHAR(255) DEFAULT NULL, ADD title VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD image_original_url VARCHAR(1024) DEFAULT NULL, ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F328FFC4 FOREIGN KEY (presence_id) REFERENCES user_presence (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649296CD8AE ON user (team_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F328FFC4 ON user (presence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F328FFC4');
        $this->addSql('DROP TABLE user_channel');
        $this->addSql('DROP TABLE user_presence');
        $this->addSql('ALTER TABLE channel DROP FOREIGN KEY FK_A2F98E47296CD8AE');
        $this->addSql('DROP INDEX IDX_A2F98E47296CD8AE ON channel');
        $this->addSql('ALTER TABLE channel DROP team_id');
        $this->addSql('ALTER TABLE team DROP name, DROP email_domain, DROP icon_url');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649296CD8AE');
        $this->addSql('DROP INDEX IDX_8D93D649296CD8AE ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649F328FFC4 ON user');
        $this->addSql('ALTER TABLE user DROP team_id, DROP presence_id, DROP real_name, DROP displayed_name, DROP title, DROP phone, DROP image_original_url, DROP first_name, DROP last_name');
    }
}
