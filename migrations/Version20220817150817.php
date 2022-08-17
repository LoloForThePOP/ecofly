<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220817150817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE problem (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, text_description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', sources LONGTEXT DEFAULT NULL, licence VARCHAR(255) DEFAULT NULL, INDEX IDX_D7E7CCC861220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE problem_technic (problem_id INT NOT NULL, technic_id INT NOT NULL, INDEX IDX_399DA18BA0DCED86 (problem_id), INDEX IDX_399DA18BFAAE137C (technic_id), PRIMARY KEY(problem_id, technic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE problem ADD CONSTRAINT FK_D7E7CCC861220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE problem_technic ADD CONSTRAINT FK_399DA18BA0DCED86 FOREIGN KEY (problem_id) REFERENCES problem (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE problem_technic ADD CONSTRAINT FK_399DA18BFAAE137C FOREIGN KEY (technic_id) REFERENCES technic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category CHANGE unique_name unique_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE slide ADD problem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slide ADD CONSTRAINT FK_72EFEE62A0DCED86 FOREIGN KEY (problem_id) REFERENCES problem (id)');
        $this->addSql('CREATE INDEX IDX_72EFEE62A0DCED86 ON slide (problem_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE problem_technic DROP FOREIGN KEY FK_399DA18BA0DCED86');
        $this->addSql('ALTER TABLE slide DROP FOREIGN KEY FK_72EFEE62A0DCED86');
        $this->addSql('DROP TABLE problem');
        $this->addSql('DROP TABLE problem_technic');
        $this->addSql('ALTER TABLE category CHANGE unique_name unique_name VARCHAR(15) NOT NULL');
        $this->addSql('DROP INDEX IDX_72EFEE62A0DCED86 ON slide');
        $this->addSql('ALTER TABLE slide DROP problem_id');
    }
}
