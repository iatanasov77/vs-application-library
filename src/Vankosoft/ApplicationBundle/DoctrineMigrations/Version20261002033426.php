<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261002033426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY `FK_4A491FD507FAB6A`');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP maintenanceMode, DROP maintenance_page_id');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories ADD CONSTRAINT FK_1EC78068A74E21B5 FOREIGN KEY (quick_link_id) REFERENCES VSCMS_QuickLinks (id)');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories ADD CONSTRAINT FK_1EC7806812469DE2 FOREIGN KEY (category_id) REFERENCES VSCMS_QuickLinksCategories (id)');
        $this->addSql('ALTER TABLE VSCMS_QuickLinksCategories ADD CONSTRAINT FK_3AA6C0F5DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE VSUM_Users ADD access_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSAPP_Settings ADD maintenanceMode TINYINT DEFAULT 0 NOT NULL COMMENT \'This Application is In Maintenace Mode.\', ADD maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT `FK_4A491FD507FAB6A` FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSCMS_QuickLinksCategories DROP FOREIGN KEY FK_3AA6C0F5DE13F470');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories DROP FOREIGN KEY FK_1EC78068A74E21B5');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories DROP FOREIGN KEY FK_1EC7806812469DE2');
        $this->addSql('ALTER TABLE VSUM_Users DROP access_token');
    }
}
