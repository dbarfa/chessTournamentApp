<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325082019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matches (id INT AUTO_INCREMENT NOT NULL, tournament_id INT NOT NULL, white_id INT NOT NULL, black_id INT NOT NULL, winner VARCHAR(255) NOT NULL, INDEX IDX_62615BA33D1A3E7 (tournament_id), INDEX IDX_62615BACDBF46EC (white_id), INDEX IDX_62615BAD3E7E37C (black_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BACDBF46EC FOREIGN KEY (white_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAD3E7E37C FOREIGN KEY (black_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE matches');
    }
}
