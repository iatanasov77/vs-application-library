<?php

declare(strict_types=1);

namespace Vankosoft\ApplicationBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223055448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSCMS_Documents (id INT AUTO_INCREMENT NOT NULL, toc_root_page_id INT NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E15A147FB4CE9742 (toc_root_page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VSCMS_Documents ADD CONSTRAINT FK_E15A147FB4CE9742 FOREIGN KEY (toc_root_page_id) REFERENCES VSCMS_TocPage (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE VSCMS_MultiPageToc');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSCMS_FileManager DROP INDEX IDX_8B912DE4DE13F470, ADD UNIQUE INDEX UNIQ_8B912DE4DE13F470 (taxon_id)');
        $this->addSql('ALTER TABLE VSCMS_PageCategories DROP INDEX IDX_98A43648DE13F470, ADD UNIQUE INDEX UNIQ_98A43648DE13F470 (taxon_id)');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP INDEX IDX_6B1FF241C4663E4, ADD UNIQUE INDEX UNIQ_6B1FF241C4663E4 (page_id)');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_F8BA64CA727ACA70');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_F8BA64CAA977936C');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_F8BA64CAC4663E4');
        $this->addSql('DROP INDEX IDX_6B1FF241A977936C ON VSCMS_TocPage');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP title, DROP lft, DROP rgt, DROP lvl, CHANGE tree_root taxon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_6B1FF241727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCMS_PageCategories (id)');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_6B1FF241DE13F470 FOREIGN KEY (taxon_id) REFERENCES VSAPP_Taxons (id)');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_6B1FF241C4663E4 FOREIGN KEY (page_id) REFERENCES VSCMS_Pages (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6B1FF241DE13F470 ON VSCMS_TocPage (taxon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE VSCMS_MultiPageToc (id INT AUTO_INCREMENT NOT NULL, toc_root_page_id INT NOT NULL, main_page_id INT NOT NULL, toc_title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, INDEX IDX_B262621CB4CE9742 (toc_root_page_id), INDEX IDX_B262621CF80DCA0D (main_page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE VSCMS_MultiPageToc ADD CONSTRAINT FK_69A01BB5B4CE9742 FOREIGN KEY (toc_root_page_id) REFERENCES VSCMS_TocPage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_MultiPageToc ADD CONSTRAINT FK_B262621CF80DCA0D FOREIGN KEY (main_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE VSCMS_Documents');
        $this->addSql('ALTER TABLE VSAPP_Applications CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE hostname hostname VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_InstalationInfo CHANGE version version VARCHAR(12) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_Locale CHANGE code code VARCHAR(12) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_LogEntries CHANGE locale locale VARCHAR(8) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE action action VARCHAR(8) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE object_id object_id VARCHAR(64) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE object_class object_class VARCHAR(191) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE data data LONGTEXT DEFAULT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE username username VARCHAR(191) DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE theme theme VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSAPP_TaxonImage CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE path path VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_TaxonTranslations CHANGE locale locale VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_Taxonomy CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_Taxons CHANGE code code VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSAPP_Translations CHANGE locale locale VARCHAR(8) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE object_class object_class VARCHAR(191) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE field field VARCHAR(32) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE foreign_key foreign_key VARCHAR(64) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE content content LONGTEXT DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSCMS_FileManager DROP INDEX UNIQ_8B912DE4DE13F470, ADD INDEX IDX_8B912DE4DE13F470 (taxon_id)');
        $this->addSql('ALTER TABLE VSCMS_FileManagerFile CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE path path VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE original_name original_name VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'The Original Name of the File.\'');
        $this->addSql('ALTER TABLE VSCMS_PageCategories DROP INDEX UNIQ_98A43648DE13F470, ADD INDEX IDX_98A43648DE13F470 (taxon_id)');
        $this->addSql('ALTER TABLE VSCMS_Pages CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP INDEX UNIQ_6B1FF241C4663E4, ADD INDEX IDX_6B1FF241C4663E4 (page_id)');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_6B1FF241727ACA70');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_6B1FF241DE13F470');
        $this->addSql('ALTER TABLE VSCMS_TocPage DROP FOREIGN KEY FK_6B1FF241C4663E4');
        $this->addSql('DROP INDEX UNIQ_6B1FF241DE13F470 ON VSCMS_TocPage');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD title VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, ADD lft INT NOT NULL, ADD rgt INT NOT NULL, ADD lvl INT NOT NULL, CHANGE taxon_id tree_root INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_F8BA64CA727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCMS_TocPage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_F8BA64CAA977936C FOREIGN KEY (tree_root) REFERENCES VSCMS_TocPage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_TocPage ADD CONSTRAINT FK_F8BA64CAC4663E4 FOREIGN KEY (page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_6B1FF241A977936C ON VSCMS_TocPage (tree_root)');
        $this->addSql('ALTER TABLE VSUM_AvatarImage CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE path path VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSUM_ResetPasswordRequests CHANGE selector selector VARCHAR(24) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE hashedToken hashedToken VARCHAR(128) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSUM_UserRoles CHANGE role role VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSUM_Users CHANGE api_token api_token VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE salt salt VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE roles_array roles_array LONGTEXT NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE username username VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE prefered_locale prefered_locale VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE confirmation_token confirmation_token VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSUM_UsersActivities CHANGE activity activity VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE country country VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE mobile mobile VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE website website VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE occupation occupation VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE VSUM_UsersNotifications CHANGE notification notification VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
    }
}
