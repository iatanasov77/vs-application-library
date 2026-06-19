<?php

declare(strict_types=1);

namespace Vankosoft\ApplicationBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260618134903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCMS_Banners ADD position INT DEFAULT NULL, DROP priority');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks ADD position INT DEFAULT NULL, DROP priority');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCMS_Banners ADD priority INT DEFAULT 0 NOT NULL, DROP position');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks ADD priority INT DEFAULT 0 NOT NULL, DROP position');
    }
}
