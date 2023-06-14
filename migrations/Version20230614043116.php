<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614043116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD workplace_id INT NOT NULL, ADD department VARCHAR(100) NOT NULL, ADD profile_picture VARCHAR(255) NOT NULL, DROP service, DROP office');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AC25FB46 FOREIGN KEY (workplace_id) REFERENCES office (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AC25FB46 ON user (workplace_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AC25FB46');
        $this->addSql('DROP INDEX IDX_8D93D649AC25FB46 ON user');
        $this->addSql('ALTER TABLE user ADD office VARCHAR(100) NOT NULL, DROP workplace_id, DROP profile_picture, CHANGE department service VARCHAR(100) NOT NULL');
    }
}
