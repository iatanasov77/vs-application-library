<?php

declare(strict_types=1);

namespace Vankosoft\ApplicationBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250317095320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE   VSUM_Users_AllowedRoles (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_4EB82A2AA76ED395 (user_id), INDEX IDX_4EB82A2AD60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE   VSUM_Users_AllowedRoles ADD CONSTRAINT FK_4EB82A2AA76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE   VSUM_Users_AllowedRoles ADD CONSTRAINT FK_4EB82A2AD60322AC FOREIGN KEY (role_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD3E030ACD');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD3E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
        $this->addSql('ALTER TABLE VSAPP_TagsWhitelistTags DROP FOREIGN KEY FK_CC268F106B00C1CF');
        $this->addSql('ALTER TABLE VSAPP_TagsWhitelistTags ADD CONSTRAINT FK_CC268F106B00C1CF FOREIGN KEY (context_id) REFERENCES VSAPP_TagsWhitelistContexts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSAPP_Widgets DROP FOREIGN KEY FK_72F1C48AFE54D947');
        $this->addSql('ALTER TABLE VSAPP_Widgets ADD CONSTRAINT FK_72F1C48AFE54D947 FOREIGN KEY (group_id) REFERENCES VSAPP_WidgetGroups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSCMS_PageCategories DROP FOREIGN KEY FK_98A43648727ACA70');
        $this->addSql('ALTER TABLE VSCMS_PageCategories ADD CONSTRAINT FK_98A43648727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCMS_PageCategories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSUM_ResetPasswordRequests DROP FOREIGN KEY FK_D6C66D0A76ED395');
        $this->addSql('ALTER TABLE VSUM_ResetPasswordRequests CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE VSUM_ResetPasswordRequests ADD CONSTRAINT FK_D6C66D0A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSUM_UserRoles DROP FOREIGN KEY FK_7F8AAD7E727ACA70');
        $this->addSql('ALTER TABLE VSUM_UserRoles ADD CONSTRAINT FK_7F8AAD7E727ACA70 FOREIGN KEY (parent_id) REFERENCES VSUM_UserRoles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSUM_Users CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersActivities DROP FOREIGN KEY FK_54103277A76ED395');
        $this->addSql('ALTER TABLE VSUM_UsersActivities CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersActivities ADD CONSTRAINT FK_54103277A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM(\'mr\', \'mrs\', \'miss\')');
        $this->addSql('ALTER TABLE VSUM_UsersNotifications DROP FOREIGN KEY FK_8D75FA15A76ED395');
        $this->addSql('ALTER TABLE VSUM_UsersNotifications CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersNotifications ADD CONSTRAINT FK_8D75FA15A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE   VSUM_Users_AllowedRoles DROP FOREIGN KEY FK_4EB82A2AA76ED395');
        $this->addSql('ALTER TABLE   VSUM_Users_AllowedRoles DROP FOREIGN KEY FK_4EB82A2AD60322AC');
        $this->addSql('DROP TABLE   VSUM_Users_AllowedRoles');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD3E030ACD');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD3E030ACD FOREIGN KEY (application_id) REFERENCES VSAPP_Applications (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
        $this->addSql('ALTER TABLE VSAPP_TagsWhitelistTags DROP FOREIGN KEY FK_CC268F106B00C1CF');
        $this->addSql('ALTER TABLE VSAPP_TagsWhitelistTags ADD CONSTRAINT FK_CC268F106B00C1CF FOREIGN KEY (context_id) REFERENCES VSAPP_TagsWhitelistContexts (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSAPP_Widgets DROP FOREIGN KEY FK_72F1C48AFE54D947');
        $this->addSql('ALTER TABLE VSAPP_Widgets ADD CONSTRAINT FK_72F1C48AFE54D947 FOREIGN KEY (group_id) REFERENCES VSAPP_WidgetGroups (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSCMS_PageCategories DROP FOREIGN KEY FK_98A43648727ACA70');
        $this->addSql('ALTER TABLE VSCMS_PageCategories ADD CONSTRAINT FK_98A43648727ACA70 FOREIGN KEY (parent_id) REFERENCES VSCMS_PageCategories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSUM_ResetPasswordRequests DROP FOREIGN KEY FK_D6C66D0A76ED395');
        $this->addSql('ALTER TABLE VSUM_ResetPasswordRequests CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_ResetPasswordRequests ADD CONSTRAINT FK_D6C66D0A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSUM_UserRoles DROP FOREIGN KEY FK_7F8AAD7E727ACA70');
        $this->addSql('ALTER TABLE VSUM_UserRoles ADD CONSTRAINT FK_7F8AAD7E727ACA70 FOREIGN KEY (parent_id) REFERENCES VSUM_UserRoles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSUM_Users CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersActivities DROP FOREIGN KEY FK_54103277A76ED395');
        $this->addSql('ALTER TABLE VSUM_UsersActivities CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersActivities ADD CONSTRAINT FK_54103277A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersNotifications DROP FOREIGN KEY FK_8D75FA15A76ED395');
        $this->addSql('ALTER TABLE VSUM_UsersNotifications CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSUM_UsersNotifications ADD CONSTRAINT FK_8D75FA15A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
