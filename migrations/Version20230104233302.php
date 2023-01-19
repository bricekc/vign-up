<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104233302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_materiel ADD tag_id INT NOT NULL, DROP tags');
        $this->addSql('ALTER TABLE type_materiel ADD CONSTRAINT FK_D52D976DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_D52D976DBAD26311 ON type_materiel (tag_id)');
        $this->addSql('ALTER TABLE type_service ADD tag_id INT NOT NULL, DROP tags');
        $this->addSql('ALTER TABLE type_service ADD CONSTRAINT FK_C9BCF527BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_C9BCF527BAD26311 ON type_service (tag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_materiel DROP FOREIGN KEY FK_D52D976DBAD26311');
        $this->addSql('ALTER TABLE type_service DROP FOREIGN KEY FK_C9BCF527BAD26311');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP INDEX IDX_D52D976DBAD26311 ON type_materiel');
        $this->addSql('ALTER TABLE type_materiel ADD tags VARCHAR(30) DEFAULT NULL, DROP tag_id');
        $this->addSql('DROP INDEX IDX_C9BCF527BAD26311 ON type_service');
        $this->addSql('ALTER TABLE type_service ADD tags VARCHAR(30) DEFAULT NULL, DROP tag_id');
    }
}
