<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822203529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A765A95FF89');
        $this->addSql('ALTER TABLE person_has_interest DROP FOREIGN KEY FK_9E56001E5A95FF89');
        $this->addSql('ALTER TABLE interest DROP FOREIGN KEY FK_6C3E1A679005F6EF');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76217BBB47');
        $this->addSql('ALTER TABLE person_has_interest DROP FOREIGN KEY FK_9E56001E217BBB47');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE interest');
        $this->addSql('DROP TABLE interest_category');
        $this->addSql('DROP TABLE person_has_interest');
        $this->addSql('DROP TABLE personal_detail');
        $this->addSql('ALTER TABLE ticket ADD token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, interest_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, file_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D8698A76217BBB47 (person_id), INDEX IDX_D8698A765A95FF89 (interest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE interest (id INT AUTO_INCREMENT NOT NULL, interest_category_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6C3E1A679005F6EF (interest_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE interest_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE person_has_interest (id INT AUTO_INCREMENT NOT NULL, interest_id INT NOT NULL, person_id INT NOT NULL, INDEX IDX_9E56001E217BBB47 (person_id), INDEX IDX_9E56001E5A95FF89 (interest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personal_detail (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76217BBB47 FOREIGN KEY (person_id) REFERENCES personal_detail (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A765A95FF89 FOREIGN KEY (interest_id) REFERENCES interest (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE interest ADD CONSTRAINT FK_6C3E1A679005F6EF FOREIGN KEY (interest_category_id) REFERENCES interest_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE person_has_interest ADD CONSTRAINT FK_9E56001E217BBB47 FOREIGN KEY (person_id) REFERENCES personal_detail (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE person_has_interest ADD CONSTRAINT FK_9E56001E5A95FF89 FOREIGN KEY (interest_id) REFERENCES interest (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ticket DROP token');
    }
}
