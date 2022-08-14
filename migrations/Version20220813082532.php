<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220813082532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technic_category (technic_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_2CB60CB5FAAE137C (technic_id), INDEX IDX_2CB60CB512469DE2 (category_id), PRIMARY KEY(technic_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE technic_category ADD CONSTRAINT FK_2CB60CB5FAAE137C FOREIGN KEY (technic_id) REFERENCES technic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technic_category ADD CONSTRAINT FK_2CB60CB512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE technic_category');
    }
}
