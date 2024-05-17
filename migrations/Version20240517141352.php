<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240517141352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `add` ADD beds INT NOT NULL, ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE booking ADD amount INT NOT NULL, ADD status VARCHAR(255) NOT NULL, CHANGE check_in check_in DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE check_out check_out DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `add` DROP beds, DROP city');
        $this->addSql('ALTER TABLE booking DROP amount, DROP status, CHANGE check_in check_in DATE NOT NULL, CHANGE check_out check_out DATE NOT NULL');
    }
}
