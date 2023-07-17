<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230712142250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reporting (id INT AUTO_INCREMENT NOT NULL, reported_idea_id INT NOT NULL, reporting_user_id INT NOT NULL, report_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', motive VARCHAR(255) NOT NULL, INDEX IDX_BD7CFA9FFCE66A86 (reported_idea_id), INDEX IDX_BD7CFA9F713FF03D (reporting_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9FFCE66A86 FOREIGN KEY (reported_idea_id) REFERENCES idea (id)');
        $this->addSql('ALTER TABLE reporting ADD CONSTRAINT FK_BD7CFA9F713FF03D FOREIGN KEY (reporting_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reporting DROP FOREIGN KEY FK_BD7CFA9FFCE66A86');
        $this->addSql('ALTER TABLE reporting DROP FOREIGN KEY FK_BD7CFA9F713FF03D');
        $this->addSql('DROP TABLE reporting');
    }
}
