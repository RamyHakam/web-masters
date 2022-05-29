<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529111802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE my_data');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE my_data (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8_unicode_ci`, email VARCHAR(230) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8_unicode_ci`, last_name TINYTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8_unicode_ci`, phone INT NOT NULL, UNIQUE INDEX UNIQ_6DD4DA37E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
