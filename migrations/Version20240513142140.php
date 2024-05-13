<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513142140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `add` CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8092D97F');
        $this->addSql('DROP INDEX IDX_E00CEDDE8092D97F ON booking');
        $this->addSql('ALTER TABLE booking ADD review_id INT NOT NULL, ADD occupants INT NOT NULL, DROP reviews_id, CHANGE traveler_id traveler_id INT NOT NULL, CHANGE adds_id adds_id INT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE3E2E969B ON booking (review_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `add` CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE3E2E969B');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE3E2E969B ON booking');
        $this->addSql('ALTER TABLE booking ADD reviews_id INT DEFAULT NULL, DROP review_id, DROP occupants, CHANGE traveler_id traveler_id INT DEFAULT NULL, CHANGE adds_id adds_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8092D97F FOREIGN KEY (reviews_id) REFERENCES review (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE8092D97F ON booking (reviews_id)');
    }
}
