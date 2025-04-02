<?php

declare(strict_types=1);

namespace Vankosoft\ApplicationBundle\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402052652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Locale ADD active TINYINT(1) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_UsersInfo CHANGE title title ENUM('mr', 'mrs', 'miss')
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Locale DROP active
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE VSUM_UsersInfo CHANGE title title VARCHAR(255) DEFAULT NULL
        SQL);
    }
}
