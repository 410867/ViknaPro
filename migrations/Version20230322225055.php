<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322225055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD images JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD video_links JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE category ALTER template DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category DROP images');
        $this->addSql('ALTER TABLE category DROP video_links');
        $this->addSql('ALTER TABLE category ALTER template SET DEFAULT \'SUB_CATEGORIES\'');
    }
}
