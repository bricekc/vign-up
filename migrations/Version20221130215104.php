<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130215104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, commentaire LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, sujet_id INT DEFAULT NULL, texte LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_5A8A6C8DFB88E14F (utilisateur_id), INDEX IDX_5A8A6C8D7C4D497E (sujet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, intitule_question VARCHAR(255) NOT NULL, INDEX IDX_B6F7494ECE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, intitule_questionnaire VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, commentaire_id INT DEFAULT NULL, reponse VARCHAR(255) NOT NULL, note INT DEFAULT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), UNIQUE INDEX UNIQ_5FB6DEC7BA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_questionnaire (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, utilisateur_id INT NOT NULL, note INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_2BB0D92ECE07E8FF (questionnaire_id), INDEX IDX_2BB0D92EFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique_user (rubrique_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F3F6952E3BD38833 (rubrique_id), INDEX IDX_F3F6952EA76ED395 (user_id), PRIMARY KEY(rubrique_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet (id INT AUTO_INCREMENT NOT NULL, intitule_sujet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_materiel (id INT AUTO_INCREMENT NOT NULL, description_materiel LONGTEXT DEFAULT NULL, intitule_materiel VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_service (id INT AUTO_INCREMENT NOT NULL, description_service LONGTEXT DEFAULT NULL, intitule_service VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(35) NOT NULL, firstname VARCHAR(35) NOT NULL, ville VARCHAR(35) DEFAULT NULL, cp VARCHAR(5) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, photo_profil LONGBLOB DEFAULT NULL, num_cire VARCHAR(14) DEFAULT NULL, valide TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_type_service (user_id INT NOT NULL, type_service_id INT NOT NULL, INDEX IDX_49708925A76ED395 (user_id), INDEX IDX_49708925F05F7FC3 (type_service_id), PRIMARY KEY(user_id, type_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_type_materiel (user_id INT NOT NULL, type_materiel_id INT NOT NULL, INDEX IDX_3BA33A3DA76ED395 (user_id), INDEX IDX_3BA33A3D5D91DD3E (type_materiel_id), PRIMARY KEY(user_id, type_materiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vigne (id INT AUTO_INCREMENT NOT NULL, viticulteur_id INT DEFAULT NULL, superficie INT DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitute VARCHAR(255) DEFAULT NULL, INDEX IDX_7DA054A0681FBEF2 (viticulteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D7C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD CONSTRAINT FK_2BB0D92ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD CONSTRAINT FK_2BB0D92EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rubrique_user ADD CONSTRAINT FK_F3F6952E3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubrique_user ADD CONSTRAINT FK_F3F6952EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_service ADD CONSTRAINT FK_49708925A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_service ADD CONSTRAINT FK_49708925F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_materiel ADD CONSTRAINT FK_3BA33A3DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_materiel ADD CONSTRAINT FK_3BA33A3D5D91DD3E FOREIGN KEY (type_materiel_id) REFERENCES type_materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vigne ADD CONSTRAINT FK_7DA054A0681FBEF2 FOREIGN KEY (viticulteur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DFB88E14F');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D7C4D497E');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECE07E8FF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7BA9CD190');
        $this->addSql('ALTER TABLE resultat_questionnaire DROP FOREIGN KEY FK_2BB0D92ECE07E8FF');
        $this->addSql('ALTER TABLE resultat_questionnaire DROP FOREIGN KEY FK_2BB0D92EFB88E14F');
        $this->addSql('ALTER TABLE rubrique_user DROP FOREIGN KEY FK_F3F6952E3BD38833');
        $this->addSql('ALTER TABLE rubrique_user DROP FOREIGN KEY FK_F3F6952EA76ED395');
        $this->addSql('ALTER TABLE user_type_service DROP FOREIGN KEY FK_49708925A76ED395');
        $this->addSql('ALTER TABLE user_type_service DROP FOREIGN KEY FK_49708925F05F7FC3');
        $this->addSql('ALTER TABLE user_type_materiel DROP FOREIGN KEY FK_3BA33A3DA76ED395');
        $this->addSql('ALTER TABLE user_type_materiel DROP FOREIGN KEY FK_3BA33A3D5D91DD3E');
        $this->addSql('ALTER TABLE vigne DROP FOREIGN KEY FK_7DA054A0681FBEF2');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE resultat_questionnaire');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE rubrique_user');
        $this->addSql('DROP TABLE sujet');
        $this->addSql('DROP TABLE type_materiel');
        $this->addSql('DROP TABLE type_service');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_type_service');
        $this->addSql('DROP TABLE user_type_materiel');
        $this->addSql('DROP TABLE vigne');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
