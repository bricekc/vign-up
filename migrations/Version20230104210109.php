<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104210109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questionnaire_thematique (questionnaire_id INT NOT NULL, thematique_id INT NOT NULL, INDEX IDX_CD7F1531CE07E8FF (questionnaire_id), INDEX IDX_CD7F1531476556AF (thematique_id), PRIMARY KEY(questionnaire_id, thematique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaire_thematique ADD CONSTRAINT FK_CD7F1531CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE questionnaire_thematique ADD CONSTRAINT FK_CD7F1531476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFA15F660A');
        $this->addSql('DROP INDEX IDX_7A64DAFA15F660A ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire DROP thematiques_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questionnaire_thematique DROP FOREIGN KEY FK_CD7F1531CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_thematique DROP FOREIGN KEY FK_CD7F1531476556AF');
        $this->addSql('DROP TABLE questionnaire_thematique');
        $this->addSql('ALTER TABLE questionnaire ADD thematiques_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFA15F660A FOREIGN KEY (thematiques_id) REFERENCES thematique (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAFA15F660A ON questionnaire (thematiques_id)');
    }
}
