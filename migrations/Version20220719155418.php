<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719155418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, unique_name VARCHAR(15) NOT NULL, description_en VARCHAR(100) NOT NULL, description_fr VARCHAR(100) DEFAULT NULL, position SMALLINT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_ppbase (category_id INT NOT NULL, ppbase_id INT NOT NULL, INDEX IDX_AD2AA7AB12469DE2 (category_id), INDEX IDX_AD2AA7AB4EF146D4 (ppbase_id), PRIMARY KEY(category_id, ppbase_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contributor_structure (id INT AUTO_INCREMENT NOT NULL, presentation_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, title VARCHAR(255) DEFAULT NULL, position SMALLINT DEFAULT NULL, rich_text_content LONGTEXT DEFAULT NULL, INDEX IDX_A08D64F6AB627E8B (presentation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, presentation_id INT DEFAULT NULL, author_user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, cache JSON DEFAULT NULL, context VARCHAR(255) DEFAULT NULL, INDEX IDX_8A8E26E9AB627E8B (presentation_id), INDEX IDX_8A8E26E9E2544CD6 (author_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation_user (conversation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5AECB5559AC0396 (conversation_id), INDEX IDX_5AECB555A76ED395 (user_id), PRIMARY KEY(conversation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, presentation_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, position SMALLINT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_D8698A76AB627E8B (presentation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, author_user_id INT DEFAULT NULL, conversation_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, context VARCHAR(150) DEFAULT NULL, content LONGTEXT NOT NULL, author_email VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, is_consulted TINYINT(1) DEFAULT NULL, INDEX IDX_B6BD307FE2544CD6 (author_user_id), INDEX IDX_B6BD307F9AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE need (id INT AUTO_INCREMENT NOT NULL, presentation_id INT DEFAULT NULL, type VARCHAR(100) DEFAULT NULL, is_paid VARCHAR(20) DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, position SMALLINT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_E6F46C44AB627E8B (presentation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persorg (id INT AUTO_INCREMENT NOT NULL, contributor_structure_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, missions VARCHAR(255) DEFAULT NULL, position SMALLINT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, website1 VARCHAR(255) DEFAULT NULL, website2 VARCHAR(255) DEFAULT NULL, website3 VARCHAR(255) DEFAULT NULL, website4 VARCHAR(255) DEFAULT NULL, postal_mail LONGTEXT DEFAULT NULL, tel1 VARCHAR(255) DEFAULT NULL, tel2 VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5EF14EF345909BCC (contributor_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, presentation_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(40) NOT NULL, country VARCHAR(255) DEFAULT NULL, administrative_area_level1 VARCHAR(255) DEFAULT NULL, administrative_area_level2 VARCHAR(255) DEFAULT NULL, locality VARCHAR(255) DEFAULT NULL, sublocality_level1 VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, position SMALLINT DEFAULT NULL, _geoloc JSON NOT NULL, INDEX IDX_741D53CDAB627E8B (presentation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ppbase (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, goal VARCHAR(400) NOT NULL, title VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, text_description LONGTEXT DEFAULT NULL, is_admin_validated TINYINT(1) NOT NULL, overall_quality_assessment SMALLINT DEFAULT NULL, is_published TINYINT(1) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, views_count INT DEFAULT NULL, parameters JSON DEFAULT NULL, string_id VARCHAR(191) NOT NULL, updated_at DATETIME DEFAULT NULL, other_components JSON DEFAULT NULL, cache JSON DEFAULT NULL, data JSON DEFAULT NULL, UNIQUE INDEX UNIQ_A2C26DD04AC2F1F0 (string_id), INDEX IDX_A2C26DD061220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, registred_user_id INT DEFAULT NULL, buyer_email VARCHAR(255) NOT NULL, buyer_info JSON DEFAULT NULL, content JSON NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6117D13BC7B276E6 (registred_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, presentation_id INT DEFAULT NULL, type VARCHAR(30) NOT NULL, address VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, caption VARCHAR(400) DEFAULT NULL, position SMALLINT DEFAULT NULL, licence VARCHAR(255) DEFAULT NULL, INDEX IDX_72EFEE62AB627E8B (presentation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, persorg_id INT DEFAULT NULL, user_name VARCHAR(30) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, parameters JSON DEFAULT NULL, email_validation_token VARCHAR(255) DEFAULT NULL, reset_password_token VARCHAR(255) DEFAULT NULL, user_name_slug VARCHAR(255) NOT NULL, data JSON DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64924A232CF (user_name), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6497583A8E6 (persorg_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_ppbase ADD CONSTRAINT FK_AD2AA7AB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_ppbase ADD CONSTRAINT FK_AD2AA7AB4EF146D4 FOREIGN KEY (ppbase_id) REFERENCES ppbase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contributor_structure ADD CONSTRAINT FK_A08D64F6AB627E8B FOREIGN KEY (presentation_id) REFERENCES ppbase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9AB627E8B FOREIGN KEY (presentation_id) REFERENCES ppbase (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9E2544CD6 FOREIGN KEY (author_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conversation_user ADD CONSTRAINT FK_5AECB5559AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_user ADD CONSTRAINT FK_5AECB555A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76AB627E8B FOREIGN KEY (presentation_id) REFERENCES ppbase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE2544CD6 FOREIGN KEY (author_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE need ADD CONSTRAINT FK_E6F46C44AB627E8B FOREIGN KEY (presentation_id) REFERENCES ppbase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persorg ADD CONSTRAINT FK_5EF14EF345909BCC FOREIGN KEY (contributor_structure_id) REFERENCES contributor_structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDAB627E8B FOREIGN KEY (presentation_id) REFERENCES ppbase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ppbase ADD CONSTRAINT FK_A2C26DD061220EA6 FOREIGN KEY (creator_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BC7B276E6 FOREIGN KEY (registred_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE slide ADD CONSTRAINT FK_72EFEE62AB627E8B FOREIGN KEY (presentation_id) REFERENCES ppbase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497583A8E6 FOREIGN KEY (persorg_id) REFERENCES persorg (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_ppbase DROP FOREIGN KEY FK_AD2AA7AB12469DE2');
        $this->addSql('ALTER TABLE persorg DROP FOREIGN KEY FK_5EF14EF345909BCC');
        $this->addSql('ALTER TABLE conversation_user DROP FOREIGN KEY FK_5AECB5559AC0396');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497583A8E6');
        $this->addSql('ALTER TABLE category_ppbase DROP FOREIGN KEY FK_AD2AA7AB4EF146D4');
        $this->addSql('ALTER TABLE contributor_structure DROP FOREIGN KEY FK_A08D64F6AB627E8B');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9AB627E8B');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76AB627E8B');
        $this->addSql('ALTER TABLE need DROP FOREIGN KEY FK_E6F46C44AB627E8B');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDAB627E8B');
        $this->addSql('ALTER TABLE slide DROP FOREIGN KEY FK_72EFEE62AB627E8B');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9E2544CD6');
        $this->addSql('ALTER TABLE conversation_user DROP FOREIGN KEY FK_5AECB555A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE2544CD6');
        $this->addSql('ALTER TABLE ppbase DROP FOREIGN KEY FK_A2C26DD061220EA6');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BC7B276E6');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_ppbase');
        $this->addSql('DROP TABLE contributor_structure');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE conversation_user');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE need');
        $this->addSql('DROP TABLE persorg');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE ppbase');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE slide');
        $this->addSql('DROP TABLE user');
    }
}
