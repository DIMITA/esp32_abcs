<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703205116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, fonctionnality_id VARCHAR(55) DEFAULT NULL, device_name VARCHAR(55) DEFAULT NULL, lastconnected DATETIME DEFAULT NULL, device_type INT DEFAULT NULL, device_connectivity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server_settings (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, last_connection DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_series (id INT AUTO_INCREMENT NOT NULL, device_id_id INT DEFAULT NULL, uplink_message_id_id INT DEFAULT NULL, name VARCHAR(50) DEFAULT NULL, date_time_offset DATETIME DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_63E64EDBB9C17E30 (device_id_id), INDEX IDX_63E64EDB1321371 (uplink_message_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uplink_messages (id INT AUTO_INCREMENT NOT NULL, device_id_id INT DEFAULT NULL, received_at DATETIME DEFAULT NULL, raw_payload LONGTEXT DEFAULT NULL, connection_config INT DEFAULT NULL, connection_freq INT DEFAULT NULL, INDEX IDX_11BBEC58B9C17E30 (device_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE time_series ADD CONSTRAINT FK_63E64EDBB9C17E30 FOREIGN KEY (device_id_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE time_series ADD CONSTRAINT FK_63E64EDB1321371 FOREIGN KEY (uplink_message_id_id) REFERENCES uplink_messages (id)');
        $this->addSql('ALTER TABLE uplink_messages ADD CONSTRAINT FK_11BBEC58B9C17E30 FOREIGN KEY (device_id_id) REFERENCES device (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE time_series DROP FOREIGN KEY FK_63E64EDBB9C17E30');
        $this->addSql('ALTER TABLE time_series DROP FOREIGN KEY FK_63E64EDB1321371');
        $this->addSql('ALTER TABLE uplink_messages DROP FOREIGN KEY FK_11BBEC58B9C17E30');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE server_settings');
        $this->addSql('DROP TABLE time_series');
        $this->addSql('DROP TABLE uplink_messages');
    }
}
