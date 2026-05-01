<?php

declare(strict_types=1);

namespace Vankosoft\ApplicationBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260430105627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSCMS_QuickLinks_Categories (quick_link_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_1EC78068A74E21B5 (quick_link_id), INDEX IDX_1EC7806812469DE2 (category_id), PRIMARY KEY(quick_link_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VSCMS_QuickLinksCategories (id INT AUTO_INCREMENT NOT NULL, taxon_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_3AA6C0F5DE13F470 (taxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories ADD CONSTRAINT FK_1EC78068A74E21B5 FOREIGN KEY (quick_link_id) REFERENCES VSCMS_QuickLinks (id)');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories ADD CONSTRAINT FK_1EC7806812469DE2 FOREIGN KEY (category_id) REFERENCES VSCMS_QuickLinksCategories (id)');
        $this->addSql('ALTER TABLE VSCMS_QuickLinksCategories ADD CONSTRAINT FK_3AA6C0F5DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories DROP FOREIGN KEY FK_1EC78068A74E21B5');
        $this->addSql('ALTER TABLE VSCMS_QuickLinks_Categories DROP FOREIGN KEY FK_1EC7806812469DE2');
        $this->addSql('ALTER TABLE VSCMS_QuickLinksCategories DROP FOREIGN KEY FK_3AA6C0F5DE13F470');
        $this->addSql('DROP TABLE VSCMS_QuickLinks_Categories');
        $this->addSql('DROP TABLE VSCMS_QuickLinksCategories');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
