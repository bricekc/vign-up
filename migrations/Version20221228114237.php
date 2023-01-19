<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228114237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON reponse_resultat_questionnaire');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD reponse_id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD CONSTRAINT FK_AD833B0ACF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD CONSTRAINT FK_AD833B0ACF09632B FOREIGN KEY (resultat_questionnaire_id) REFERENCES resultat_questionnaire (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_AD833B0ACF18BB82 ON reponse_resultat_questionnaire (reponse_id)');
        $this->addSql('CREATE INDEX IDX_AD833B0ACF09632B ON reponse_resultat_questionnaire (resultat_questionnaire_id)');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD PRIMARY KEY (reponse_id, resultat_questionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire DROP FOREIGN KEY FK_AD833B0ACF18BB82');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire DROP FOREIGN KEY FK_AD833B0ACF09632B');
        $this->addSql('DROP INDEX IDX_AD833B0ACF18BB82 ON reponse_resultat_questionnaire');
        $this->addSql('DROP INDEX IDX_AD833B0ACF09632B ON reponse_resultat_questionnaire');
        $this->addSql('DROP INDEX `PRIMARY` ON reponse_resultat_questionnaire');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire DROP reponse_id');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD PRIMARY KEY (resultat_questionnaire_id)');
    }
}
