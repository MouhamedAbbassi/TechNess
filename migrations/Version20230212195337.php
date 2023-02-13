<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230212195337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordonnance ADD doctor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C87F4FB17 FOREIGN KEY (doctor_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_924B326C87F4FB17 ON ordonnance (doctor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C87F4FB17');
        $this->addSql('DROP INDEX IDX_924B326C87F4FB17 ON ordonnance');
        $this->addSql('ALTER TABLE ordonnance DROP doctor_id');
    }
}
