<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104203645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE thematique (id INT AUTO_INCREMENT NOT NULL, lib_themathique VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD thematique_id INT DEFAULT NULL, DROP string');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC476556AF ON commentaire (thematique_id)');
        $this->addSql('ALTER TABLE question ADD thematique_id INT DEFAULT NULL, DROP string');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E476556AF ON question (thematique_id)');
        $this->addSql('ALTER TABLE questionnaire ADD thematiques_id INT DEFAULT NULL, DROP thematiques');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFA15F660A FOREIGN KEY (thematiques_id) REFERENCES thematique (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAFA15F660A ON questionnaire (thematiques_id)');
        $this->addSql('ALTER TABLE user CHANGE discriminator discriminator VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC476556AF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E476556AF');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFA15F660A');
        $this->addSql('DROP TABLE thematique');
        $this->addSql('DROP INDEX IDX_7A64DAFA15F660A ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire ADD thematiques LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP thematiques_id');
        $this->addSql('ALTER TABLE `user` CHANGE discriminator discriminator VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_B6F7494E476556AF ON question');
        $this->addSql('ALTER TABLE question ADD string VARCHAR(255) DEFAULT NULL, DROP thematique_id');
        $this->addSql('DROP INDEX IDX_67F068BC476556AF ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD string VARCHAR(255) DEFAULT NULL, DROP thematique_id');
    }
}
