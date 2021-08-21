<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210815105905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_81398E09B03A8386 (created_by_id), INDEX IDX_81398E09896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reply (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, user_id INT NOT NULL, customer_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FDA8C6E0700047D2 (ticket_id), INDEX IDX_FDA8C6E0A76ED395 (user_id), INDEX IDX_FDA8C6E09395C3F3 (customer_id), INDEX IDX_FDA8C6E0B03A8386 (created_by_id), INDEX IDX_FDA8C6E0896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E09395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD customer_id INT NOT NULL, ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA39395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA39395C3F3 ON ticket (customer_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3B03A8386 ON ticket (created_by_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3896DBBDE ON ticket (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E09395C3F3');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA39395C3F3');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE reply');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3B03A8386');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3896DBBDE');
        $this->addSql('DROP INDEX IDX_97A0ADA39395C3F3 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3B03A8386 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3896DBBDE ON ticket');
        $this->addSql('ALTER TABLE ticket DROP customer_id, DROP created_by_id, DROP updated_by_id');
    }
}
