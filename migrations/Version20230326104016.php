<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326104016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE factory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE factory (id INT NOT NULL, category_id INT DEFAULT NULL, img VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB361EF912469DE2 ON factory (category_id)');
        $this->addSql('ALTER TABLE factory ADD CONSTRAINT FK_FB361EF912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_collection DROP CONSTRAINT fk_da53354c12469de2');
        $this->addSql('DROP INDEX idx_da53354c12469de2');
        $this->addSql('ALTER TABLE category_collection RENAME COLUMN category_id TO factory_id');
        $this->addSql('ALTER TABLE category_collection ADD CONSTRAINT FK_DA53354CC7AF27D2 FOREIGN KEY (factory_id) REFERENCES factory (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DA53354CC7AF27D2 ON category_collection (factory_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category_collection DROP CONSTRAINT FK_DA53354CC7AF27D2');
        $this->addSql('DROP SEQUENCE factory_id_seq CASCADE');
        $this->addSql('ALTER TABLE factory DROP CONSTRAINT FK_FB361EF912469DE2');
        $this->addSql('DROP TABLE factory');
        $this->addSql('DROP INDEX IDX_DA53354CC7AF27D2');
        $this->addSql('ALTER TABLE category_collection RENAME COLUMN factory_id TO category_id');
        $this->addSql('ALTER TABLE category_collection ADD CONSTRAINT fk_da53354c12469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_da53354c12469de2 ON category_collection (category_id)');
    }
}
