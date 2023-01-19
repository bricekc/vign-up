<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102131724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD questionnaire_id INT DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD string VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCCE07E8FF ON commentaire (questionnaire_id)');
        $this->addSql('ALTER TABLE question ADD string VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaire ADD thematiques LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCCE07E8FF');
        $this->addSql('DROP INDEX IDX_67F068BCCE07E8FF ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP questionnaire_id, DROP notes, DROP string');
        $this->addSql('ALTER TABLE questionnaire DROP thematiques');
        $this->addSql('ALTER TABLE question DROP string');
    }
}
