<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241022122838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taches (id INT AUTO_INCREMENT NOT NULL, taches_id INT NOT NULL, title VARCHAR(255) NOT NULL, is_finished TINYINT(1) NOT NULL, INDEX IDX_3BF2CD98B8A61670 (taches_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE todos_list (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98B8A61670 FOREIGN KEY (taches_id) REFERENCES todos_list (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98B8A61670');
        $this->addSql('DROP TABLE taches');
        $this->addSql('DROP TABLE todos_list');
    }
}
