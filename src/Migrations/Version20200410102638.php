<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200410102638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event ADD place_id INT NOT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE capacity capacity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7DA6A219 ON event (place_id)');
        $this->addSql('ALTER TABLE place CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7DA6A219');
        $this->addSql('DROP INDEX IDX_3BAE0AA7DA6A219 ON event');
        $this->addSql('ALTER TABLE event DROP place_id, CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE capacity capacity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place CHANGE latitude latitude DOUBLE PRECISION DEFAULT \'NULL\', CHANGE longitude longitude DOUBLE PRECISION DEFAULT \'NULL\'');
    }
}
