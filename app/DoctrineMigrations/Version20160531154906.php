<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160531154906 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE symfony_demo_currency (id INTEGER NOT NULL, numCode VARCHAR(3) NOT NULL, charCode VARCHAR(3) NOT NULL, name VARCHAR(255) NOT NULL, rateToRuble NUMERIC(4, 11) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5924AE0B8ACB87F2 ON symfony_demo_currency (numCode)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5924AE0B35C65559 ON symfony_demo_currency (charCode)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5924AE0B5E237E06 ON symfony_demo_currency (name)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post AS SELECT id, title, slug, summary, content, authorEmail, publishedAt FROM symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER NOT NULL, currency_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, summary VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, authorEmail VARCHAR(255) NOT NULL COLLATE BINARY, publishedAt DATETIME NOT NULL, price NUMERIC(4, 11) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_58A92E6538248176 FOREIGN KEY (currency_id) REFERENCES symfony_demo_currency (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_58A92E6538248176 ON symfony_demo_post (currency_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_58A92E6538248176');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post AS SELECT id, title, slug, summary, content, authorEmail, publishedAt FROM symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content CLOB NOT NULL, authorEmail VARCHAR(255) NOT NULL, publishedAt DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO symfony_demo_post (id, title, slug, summary, content, authorEmail, publishedAt) SELECT id, title, slug, summary, content, authorEmail, publishedAt FROM __temp__symfony_demo_post');
        $this->addSql('DROP TABLE __temp__symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_currency');
    }
}
