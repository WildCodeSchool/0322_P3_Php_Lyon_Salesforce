<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706075634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_idea (user_id INT NOT NULL, idea_id INT NOT NULL, INDEX IDX_700A868CA76ED395 (user_id), INDEX IDX_700A868C5B6FEF7D (idea_id), PRIMARY KEY(user_id, idea_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_idea ADD CONSTRAINT FK_700A868CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_idea ADD CONSTRAINT FK_700A868C5B6FEF7D FOREIGN KEY (idea_id) REFERENCES idea (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_2819DB33BE612E45');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_2819DB33F909284E');
        $this->addSql('DROP TABLE membership');
        $this->addSql('ALTER TABLE user ADD slack_id VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, concept_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_86FFD285F909284E (concept_id), INDEX IDX_86FFD2857597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_2819DB33BE612E45 FOREIGN KEY (member_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_2819DB33F909284E FOREIGN KEY (concept_id) REFERENCES idea (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_idea DROP FOREIGN KEY FK_700A868CA76ED395');
        $this->addSql('ALTER TABLE user_idea DROP FOREIGN KEY FK_700A868C5B6FEF7D');
        $this->addSql('DROP TABLE user_idea');
        $this->addSql('ALTER TABLE user DROP slack_id');
    }
}
