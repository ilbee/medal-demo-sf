<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416092451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medal (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, nation_id INT NOT NULL, color VARCHAR(6) NOT NULL, point INT NOT NULL, INDEX IDX_DC4457B9AC78BCF8 (sport_id), INDEX IDX_DC4457B9AE3899 (nation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, category VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medal ADD CONSTRAINT FK_DC4457B9AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE medal ADD CONSTRAINT FK_DC4457B9AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medal DROP FOREIGN KEY FK_DC4457B9AC78BCF8');
        $this->addSql('ALTER TABLE medal DROP FOREIGN KEY FK_DC4457B9AE3899');
        $this->addSql('DROP TABLE medal');
        $this->addSql('DROP TABLE nation');
        $this->addSql('DROP TABLE sport');
    }
}
