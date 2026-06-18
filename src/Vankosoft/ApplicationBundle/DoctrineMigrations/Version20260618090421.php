<?php

declare(strict_types=1);

namespace Vankosoft\ApplicationBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260618090421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCMS_QuickLinks ADD priority INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE VSCMS_SlidersItemsPhotos ADD CONSTRAINT FK_A9581A697E3C61F9 FOREIGN KEY (owner_id) REFERENCES VSCMS_SlidersItems (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCMS_QuickLinks DROP priority');
        $this->addSql('ALTER TABLE VSCMS_SlidersItemsPhotos DROP FOREIGN KEY FK_A9581A697E3C61F9');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
