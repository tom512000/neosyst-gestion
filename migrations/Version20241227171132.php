<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241227171132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(10) DEFAULT NULL, mobile_number VARCHAR(10) DEFAULT NULL, fax_number VARCHAR(10) DEFAULT NULL, spreadsheet_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sav (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, code VARCHAR(10) DEFAULT NULL, created_date DATE DEFAULT NULL, representative VARCHAR(100) DEFAULT NULL, breakdown VARCHAR(255) DEFAULT NULL, end_date DATE DEFAULT NULL, repaired_by VARCHAR(100) DEFAULT NULL, repairs VARCHAR(255) DEFAULT NULL, comments VARCHAR(255) DEFAULT NULL, charge VARCHAR(255) DEFAULT NULL, spreadsheet_name VARCHAR(50) NOT NULL, INDEX IDX_6C7681F419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sav ADD CONSTRAINT FK_6C7681F419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sav DROP FOREIGN KEY FK_6C7681F419EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE sav');
    }
}
