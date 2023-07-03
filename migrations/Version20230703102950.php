<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703102950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membership RENAME INDEX idx_2819db33f909284e TO IDX_86FFD285F909284E');
        $this->addSql('ALTER TABLE membership RENAME INDEX idx_2819db33be612e45 TO IDX_86FFD2857597D3FE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membership RENAME INDEX idx_86ffd285f909284e TO IDX_2819DB33F909284E');
        $this->addSql('ALTER TABLE membership RENAME INDEX idx_86ffd2857597d3fe TO IDX_2819DB33BE612E45');
    }
}
