<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325081656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BA3B44AAA7');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BABE120E4E');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BA70978323');
        $this->addSql('DROP INDEX IDX_62615BA3B44AAA7 ON matches');
        $this->addSql('DROP INDEX IDX_62615BA70978323 ON matches');
        $this->addSql('DROP INDEX IDX_62615BABE120E4E ON matches');
        $this->addSql('ALTER TABLE matches ADD tournament_id INT NOT NULL, ADD white_id INT NOT NULL, ADD black_id INT NOT NULL, DROP tournament_id_id, DROP white_id_id, DROP black_id_id');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BACDBF46EC FOREIGN KEY (white_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAD3E7E37C FOREIGN KEY (black_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_62615BA33D1A3E7 ON matches (tournament_id)');
        $this->addSql('CREATE INDEX IDX_62615BACDBF46EC ON matches (white_id)');
        $this->addSql('CREATE INDEX IDX_62615BAD3E7E37C ON matches (black_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BA33D1A3E7');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BACDBF46EC');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BAD3E7E37C');
        $this->addSql('DROP INDEX IDX_62615BA33D1A3E7 ON matches');
        $this->addSql('DROP INDEX IDX_62615BACDBF46EC ON matches');
        $this->addSql('DROP INDEX IDX_62615BAD3E7E37C ON matches');
        $this->addSql('ALTER TABLE matches ADD tournament_id_id INT NOT NULL, ADD white_id_id INT NOT NULL, ADD black_id_id INT NOT NULL, DROP tournament_id, DROP white_id, DROP black_id');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA3B44AAA7 FOREIGN KEY (white_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BABE120E4E FOREIGN KEY (tournament_id_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA70978323 FOREIGN KEY (black_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_62615BA3B44AAA7 ON matches (white_id_id)');
        $this->addSql('CREATE INDEX IDX_62615BA70978323 ON matches (black_id_id)');
        $this->addSql('CREATE INDEX IDX_62615BABE120E4E ON matches (tournament_id_id)');
    }
}
