<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241027001115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad ADD views_count INT NOT NULL');
        $this->addSql('ALTER TABLE ad ADD whatsapp_contact_count INT NOT NULL');
        $this->addSql('ALTER TABLE ad ADD message_contact_count INT NOT NULL');
        $this->addSql('ALTER TABLE ad ADD address VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ad DROP views_count');
        $this->addSql('ALTER TABLE ad DROP whatsapp_contact_count');
        $this->addSql('ALTER TABLE ad DROP message_contact_count');
        $this->addSql('ALTER TABLE ad DROP address');
    }
}
