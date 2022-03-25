<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325081049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matches (id INT AUTO_INCREMENT NOT NULL, tournament_id_id INT NOT NULL, white_id_id INT NOT NULL, black_id_id INT NOT NULL, winner VARCHAR(255) NOT NULL, INDEX IDX_62615BABE120E4E (tournament_id_id), INDEX IDX_62615BA3B44AAA7 (white_id_id), INDEX IDX_62615BA70978323 (black_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BABE120E4E FOREIGN KEY (tournament_id_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA3B44AAA7 FOREIGN KEY (white_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA70978323 FOREIGN KEY (black_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE matches');
    }
}
