<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721171541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technic ADD creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE technic ADD CONSTRAINT FK_DFBF61F861220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DFBF61F861220EA6 ON technic (creator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technic DROP FOREIGN KEY FK_DFBF61F861220EA6');
        $this->addSql('DROP INDEX IDX_DFBF61F861220EA6 ON technic');
        $this->addSql('ALTER TABLE technic DROP creator_id');
    }
}
