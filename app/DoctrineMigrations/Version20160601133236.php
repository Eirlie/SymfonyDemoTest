<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160601133236 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_8FB094A1F85E0677');
        $this->addSql('DROP INDEX UNIQ_8FB094A1E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_user AS SELECT id, username, email, password, roles FROM symfony_demo_user');
        $this->addSql('DROP TABLE symfony_demo_user');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL, defaultCurrency INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_8FB094A116ED5A51 FOREIGN KEY (defaultCurrency) REFERENCES symfony_demo_currency (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_user (id, username, email, password, roles) SELECT id, username, email, password, roles FROM __temp__symfony_demo_user');
        $this->addSql('DROP TABLE __temp__symfony_demo_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
        $this->addSql('CREATE INDEX IDX_8FB094A116ED5A51 ON symfony_demo_user (defaultCurrency)');
        $this->addSql('ALTER TABLE symfony_demo_currency ADD COLUMN isDefault BOOLEAN DEFAULT \'0\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_5924AE0B8ACB87F2');
        $this->addSql('DROP INDEX UNIQ_5924AE0B35C65559');
        $this->addSql('DROP INDEX UNIQ_5924AE0B5E237E06');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_currency AS SELECT id, numCode, charCode, name, rateToRuble FROM symfony_demo_currency');
        $this->addSql('DROP TABLE symfony_demo_currency');
        $this->addSql('CREATE TABLE symfony_demo_currency (id INTEGER NOT NULL, numCode VARCHAR(3) NOT NULL, charCode VARCHAR(3) NOT NULL, name VARCHAR(255) NOT NULL, rateToRuble NUMERIC(4, 11) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO symfony_demo_currency (id, numCode, charCode, name, rateToRuble) SELECT id, numCode, charCode, name, rateToRuble FROM __temp__symfony_demo_currency');
        $this->addSql('DROP TABLE __temp__symfony_demo_currency');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5924AE0B8ACB87F2 ON symfony_demo_currency (numCode)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5924AE0B35C65559 ON symfony_demo_currency (charCode)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5924AE0B5E237E06 ON symfony_demo_currency (name)');
        $this->addSql('DROP INDEX UNIQ_8FB094A1F85E0677');
        $this->addSql('DROP INDEX UNIQ_8FB094A1E7927C74');
        $this->addSql('DROP INDEX IDX_8FB094A116ED5A51');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_user AS SELECT id, username, email, password, roles FROM symfony_demo_user');
        $this->addSql('DROP TABLE symfony_demo_user');
        $this->addSql('CREATE TABLE symfony_demo_user (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO symfony_demo_user (id, username, email, password, roles) SELECT id, username, email, password, roles FROM __temp__symfony_demo_user');
        $this->addSql('DROP TABLE __temp__symfony_demo_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
    }
}
