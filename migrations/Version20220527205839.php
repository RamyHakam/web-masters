<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527205839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_groups DROP FOREIGN KEY FK_953F224DF373DCF');
        $this->addSql('CREATE TABLE symfony_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE `groups`');
        $this->addSql('DROP INDEX IDX_953F224DF373DCF ON user_groups');
        $this->addSql('ALTER TABLE user_groups DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_groups CHANGE groups_id symfony_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224D9BAF1310 FOREIGN KEY (symfony_group_id) REFERENCES symfony_group (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_953F224D9BAF1310 ON user_groups (symfony_group_id)');
        $this->addSql('ALTER TABLE user_groups ADD PRIMARY KEY (user_id, symfony_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_groups DROP FOREIGN KEY FK_953F224D9BAF1310');
        $this->addSql('CREATE TABLE `groups` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE symfony_group');
        $this->addSql('DROP INDEX IDX_953F224D9BAF1310 ON user_groups');
        $this->addSql('ALTER TABLE user_groups DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_groups CHANGE symfony_group_id groups_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224DF373DCF FOREIGN KEY (groups_id) REFERENCES `groups` (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_953F224DF373DCF ON user_groups (groups_id)');
        $this->addSql('ALTER TABLE user_groups ADD PRIMARY KEY (user_id, groups_id)');
    }
}
