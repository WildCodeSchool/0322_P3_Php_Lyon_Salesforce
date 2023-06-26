<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626120347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherence (id INT AUTO_INCREMENT NOT NULL, concept_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_2819DB33F909284E (concept_id), INDEX IDX_2819DB33BE612E45 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adherence ADD CONSTRAINT FK_2819DB33F909284E FOREIGN KEY (concept_id) REFERENCES idea (id)');
        $this->addSql('ALTER TABLE adherence ADD CONSTRAINT FK_2819DB33BE612E45 FOREIGN KEY (adherent_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherence DROP FOREIGN KEY FK_2819DB33F909284E');
        $this->addSql('ALTER TABLE adherence DROP FOREIGN KEY FK_2819DB33BE612E45');
        $this->addSql('DROP TABLE adherence');
    }
}
