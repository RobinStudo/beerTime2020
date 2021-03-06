<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420095348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE capacity capacity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(255) NOT NULL, ADD zipcode INT NOT NULL, ADD city VARCHAR(100) NOT NULL, ADD country VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE capacity capacity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place CHANGE latitude latitude DOUBLE PRECISION DEFAULT \'NULL\', CHANGE longitude longitude DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user DROP address, DROP zipcode, DROP city, DROP country');
    }
}
