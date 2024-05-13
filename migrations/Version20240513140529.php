<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513140529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `add` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, introduction VARCHAR(255) NOT NULL, price INT NOT NULL, capacity INT NOT NULL, rooms INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, traveler_id INT DEFAULT NULL, reviews_id INT DEFAULT NULL, adds_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, check_in DATE NOT NULL, check_out DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E00CEDDE59BBE8A3 (traveler_id), INDEX IDX_E00CEDDE8092D97F (reviews_id), INDEX IDX_E00CEDDEAFF017BE (adds_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_add (equipment_id INT NOT NULL, add_id INT NOT NULL, INDEX IDX_CC9ABB86517FE9FE (equipment_id), INDEX IDX_CC9ABB86339CD0A7 (add_id), PRIMARY KEY(equipment_id, add_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, adds_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C53D045FAFF017BE (adds_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, adds_id INT DEFAULT NULL, traveler_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, rating INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_794381C6AFF017BE (adds_id), INDEX IDX_794381C659BBE8A3 (traveler_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, images VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, phone VARCHAR(13) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE59BBE8A3 FOREIGN KEY (traveler_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8092D97F FOREIGN KEY (reviews_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEAFF017BE FOREIGN KEY (adds_id) REFERENCES `add` (id)');
        $this->addSql('ALTER TABLE equipment_add ADD CONSTRAINT FK_CC9ABB86517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_add ADD CONSTRAINT FK_CC9ABB86339CD0A7 FOREIGN KEY (add_id) REFERENCES `add` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAFF017BE FOREIGN KEY (adds_id) REFERENCES `add` (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6AFF017BE FOREIGN KEY (adds_id) REFERENCES `add` (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C659BBE8A3 FOREIGN KEY (traveler_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE59BBE8A3');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8092D97F');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEAFF017BE');
        $this->addSql('ALTER TABLE equipment_add DROP FOREIGN KEY FK_CC9ABB86517FE9FE');
        $this->addSql('ALTER TABLE equipment_add DROP FOREIGN KEY FK_CC9ABB86339CD0A7');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAFF017BE');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6AFF017BE');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C659BBE8A3');
        $this->addSql('DROP TABLE `add`');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE equipment_add');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
