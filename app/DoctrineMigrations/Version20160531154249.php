<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160531154249 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE IF EXISTS symfony_demo_user');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('DROP TABLE IF EXISTS symfony_demo_comment');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER NOT NULL, post_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, authorEmail VARCHAR(255) NOT NULL COLLATE BINARY, publishedAt DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('DROP TABLE IF EXISTS symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, summary VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, authorEmail VARCHAR(255) NOT NULL COLLATE BINARY, publishedAt DATETIME NOT NULL, PRIMARY KEY(id))');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_53AD8F834B89032C');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('DROP INDEX UNIQ_8FB094A1F85E0677');
        $this->addSql('DROP INDEX UNIQ_8FB094A1E7927C74');
        $this->addSql('DROP TABLE symfony_demo_user');
    }
}
