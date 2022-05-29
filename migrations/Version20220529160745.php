<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529160745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, number INT NOT NULL, UNIQUE INDEX UNIQ_C2F3561DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Page (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, status VARCHAR(20) DEFAULT \'draft\' NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_B438191EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Post (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, likes INT NOT NULL, User_id INT NOT NULL, INDEX IDX_FAB8C3B368D3EA09 (User_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, invited_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, past VARCHAR(255) DEFAULT NULL, dateOfBirth DATE NOT NULL, createdAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_2DA17977A7B4A7E3 (invited_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_groups (user_id INT NOT NULL, symfonygroup_id INT NOT NULL, INDEX IDX_953F224DA76ED395 (user_id), INDEX IDX_953F224DC10FA962 (symfonygroup_id), PRIMARY KEY(user_id, symfonygroup_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE symfony_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Address ADD CONSTRAINT FK_C2F3561DA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Page ADD CONSTRAINT FK_B438191EA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Post ADD CONSTRAINT FK_FAB8C3B368D3EA09 FOREIGN KEY (User_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977A7B4A7E3 FOREIGN KEY (invited_by_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224DA76ED395 FOREIGN KEY (user_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224DC10FA962 FOREIGN KEY (symfonygroup_id) REFERENCES symfony_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Address DROP FOREIGN KEY FK_C2F3561DA76ED395');
        $this->addSql('ALTER TABLE Page DROP FOREIGN KEY FK_B438191EA76ED395');
        $this->addSql('ALTER TABLE Post DROP FOREIGN KEY FK_FAB8C3B368D3EA09');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977A7B4A7E3');
        $this->addSql('ALTER TABLE user_groups DROP FOREIGN KEY FK_953F224DA76ED395');
        $this->addSql('ALTER TABLE user_groups DROP FOREIGN KEY FK_953F224DC10FA962');
        $this->addSql('DROP TABLE Address');
        $this->addSql('DROP TABLE Page');
        $this->addSql('DROP TABLE Post');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE user_groups');
        $this->addSql('DROP TABLE symfony_group');
    }
}
