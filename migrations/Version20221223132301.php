<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221223132301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7CF09632B');
        $this->addSql('DROP INDEX IDX_5FB6DEC7CF09632B ON reponse');
        $this->addSql('ALTER TABLE reponse DROP resultat_questionnaire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse ADD resultat_questionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7CF09632B FOREIGN KEY (resultat_questionnaire_id) REFERENCES resultat_questionnaire (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7CF09632B ON reponse (resultat_questionnaire_id)');
    }
}
