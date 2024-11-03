<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241103190425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT fk_68c58ed99b6b5fba');
        $this->addSql('DROP INDEX idx_68c58ed99b6b5fba');
        $this->addSql('ALTER TABLE favorite RENAME COLUMN account_id TO owner_id');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED97E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_68C58ED97E3C61F9 ON favorite (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED97E3C61F9');
        $this->addSql('DROP INDEX IDX_68C58ED97E3C61F9');
        $this->addSql('ALTER TABLE favorite RENAME COLUMN owner_id TO account_id');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT fk_68c58ed99b6b5fba FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_68c58ed99b6b5fba ON favorite (account_id)');
    }
}
