<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903074924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE aforo');
        $this->addSql('ALTER TABLE asistencia CHANGE fecha_fin fecha_fin DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE venta CHANGE total total DOUBLE PRECISION NOT NULL, CHANGE fecha fecha DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE venta RENAME INDEX idx_7c493b0181571439 TO IDX_8FE7EE55952BE730');
        $this->addSql('ALTER TABLE venta_detalle CHANGE cantidad cantidad DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE venta_detalle RENAME INDEX idx_97f34a817290d235 TO IDX_82DFB1DCF2A5805D');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aforo (id INT AUTO_INCREMENT NOT NULL, total INT NOT NULL, fecha DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE asistencia CHANGE fecha_fin fecha_fin DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE venta CHANGE total total NUMERIC(10, 2) NOT NULL, CHANGE fecha fecha DATETIME NOT NULL');
        $this->addSql('ALTER TABLE venta RENAME INDEX idx_8fe7ee55952be730 TO IDX_7C493B0181571439');
        $this->addSql('ALTER TABLE venta_detalle CHANGE cantidad cantidad NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE venta_detalle RENAME INDEX idx_82dfb1dcf2a5805d TO IDX_97F34A817290D235');
    }
}
