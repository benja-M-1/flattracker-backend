<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160204223734 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE ft_user (id VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, facebook_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F32DB839E7927C74 ON ft_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F32DB8399BE8FD98 ON ft_user (facebook_id)');
        $this->addSql('CREATE TABLE ft_visit (id VARCHAR(255) NOT NULL, searcher_id VARCHAR(255) DEFAULT NULL, tracker_id VARCHAR(255) DEFAULT NULL, url VARCHAR(511) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1305266BC9F91E67 ON ft_visit (searcher_id)');
        $this->addSql('CREATE INDEX IDX_1305266BFB5230B ON ft_visit (tracker_id)');
        $this->addSql('ALTER TABLE ft_visit ADD CONSTRAINT FK_1305266BC9F91E67 FOREIGN KEY (searcher_id) REFERENCES ft_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ft_visit ADD CONSTRAINT FK_1305266BFB5230B FOREIGN KEY (tracker_id) REFERENCES ft_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ft_visit DROP CONSTRAINT FK_1305266BC9F91E67');
        $this->addSql('ALTER TABLE ft_visit DROP CONSTRAINT FK_1305266BFB5230B');
        $this->addSql('DROP TABLE ft_user');
        $this->addSql('DROP TABLE ft_visit');
    }
}
