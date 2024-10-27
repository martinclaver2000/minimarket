<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241027014259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE favorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE favorite (id INT NOT NULL, ad_id INT NOT NULL, account_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68C58ED94F34D596 ON favorite (ad_id)');
        $this->addSql('CREATE INDEX IDX_68C58ED99B6B5FBA ON favorite (account_id)');
        $this->addSql('COMMENT ON COLUMN favorite.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED94F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED99B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE favorite_id_seq CASCADE');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED94F34D596');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED99B6B5FBA');
        $this->addSql('DROP TABLE favorite');
    }
}
