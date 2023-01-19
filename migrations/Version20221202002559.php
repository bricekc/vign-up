<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202002559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_rubrique (admin_id INT NOT NULL, rubrique_id INT NOT NULL, INDEX IDX_1B040E7A642B8210 (admin_id), INDEX IDX_1B040E7A3BD38833 (rubrique_id), PRIMARY KEY(admin_id, rubrique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT NOT NULL, verif TINYINT(1) NOT NULL, num_cire VARCHAR(14) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur_type_materiel (fournisseur_id INT NOT NULL, type_materiel_id INT NOT NULL, INDEX IDX_524C559D670C757F (fournisseur_id), INDEX IDX_524C559D5D91DD3E (type_materiel_id), PRIMARY KEY(fournisseur_id, type_materiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur_type_service (fournisseur_id INT NOT NULL, type_service_id INT NOT NULL, INDEX IDX_A0DDD7B6670C757F (fournisseur_id), INDEX IDX_A0DDD7B6F05F7FC3 (type_service_id), PRIMARY KEY(fournisseur_id, type_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE viticulteur (id INT NOT NULL, verif TINYINT(1) NOT NULL, num_cire VARCHAR(14) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_rubrique ADD CONSTRAINT FK_1B040E7A642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_rubrique ADD CONSTRAINT FK_1B040E7A3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_materiel ADD CONSTRAINT FK_524C559D670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_materiel ADD CONSTRAINT FK_524C559D5D91DD3E FOREIGN KEY (type_materiel_id) REFERENCES type_materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_service ADD CONSTRAINT FK_A0DDD7B6670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_service ADD CONSTRAINT FK_A0DDD7B6F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE viticulteur ADD CONSTRAINT FK_C978DC4ABF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_materiel DROP FOREIGN KEY FK_3BA33A3D5D91DD3E');
        $this->addSql('ALTER TABLE user_type_materiel DROP FOREIGN KEY FK_3BA33A3DA76ED395');
        $this->addSql('ALTER TABLE rubrique_user DROP FOREIGN KEY FK_F3F6952E3BD38833');
        $this->addSql('ALTER TABLE rubrique_user DROP FOREIGN KEY FK_F3F6952EA76ED395');
        $this->addSql('ALTER TABLE user_type_service DROP FOREIGN KEY FK_49708925F05F7FC3');
        $this->addSql('ALTER TABLE user_type_service DROP FOREIGN KEY FK_49708925A76ED395');
        $this->addSql('DROP TABLE user_type_materiel');
        $this->addSql('DROP TABLE rubrique_user');
        $this->addSql('DROP TABLE user_type_service');
        $this->addSql('ALTER TABLE resultat_questionnaire DROP FOREIGN KEY FK_2BB0D92EFB88E14F');
        $this->addSql('DROP INDEX IDX_2BB0D92EFB88E14F ON resultat_questionnaire');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD viticulteur_id INT DEFAULT NULL, DROP utilisateur_id');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD CONSTRAINT FK_2BB0D92E681FBEF2 FOREIGN KEY (viticulteur_id) REFERENCES viticulteur (id)');
        $this->addSql('CREATE INDEX IDX_2BB0D92E681FBEF2 ON resultat_questionnaire (viticulteur_id)');
        $this->addSql('ALTER TABLE user ADD discriminator VARCHAR(255) NULL, DROP num_cire, DROP valide');
        $this->addSql('ALTER TABLE vigne DROP FOREIGN KEY FK_7DA054A0681FBEF2');
        $this->addSql('ALTER TABLE vigne ADD CONSTRAINT FK_7DA054A0681FBEF2 FOREIGN KEY (viticulteur_id) REFERENCES viticulteur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resultat_questionnaire DROP FOREIGN KEY FK_2BB0D92E681FBEF2');
        $this->addSql('ALTER TABLE vigne DROP FOREIGN KEY FK_7DA054A0681FBEF2');
        $this->addSql('CREATE TABLE user_type_materiel (user_id INT NOT NULL, type_materiel_id INT NOT NULL, INDEX IDX_3BA33A3D5D91DD3E (type_materiel_id), INDEX IDX_3BA33A3DA76ED395 (user_id), PRIMARY KEY(user_id, type_materiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rubrique_user (rubrique_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F3F6952E3BD38833 (rubrique_id), INDEX IDX_F3F6952EA76ED395 (user_id), PRIMARY KEY(rubrique_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_type_service (user_id INT NOT NULL, type_service_id INT NOT NULL, INDEX IDX_49708925A76ED395 (user_id), INDEX IDX_49708925F05F7FC3 (type_service_id), PRIMARY KEY(user_id, type_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_type_materiel ADD CONSTRAINT FK_3BA33A3D5D91DD3E FOREIGN KEY (type_materiel_id) REFERENCES type_materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_materiel ADD CONSTRAINT FK_3BA33A3DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubrique_user ADD CONSTRAINT FK_F3F6952E3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubrique_user ADD CONSTRAINT FK_F3F6952EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_service ADD CONSTRAINT FK_49708925F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_type_service ADD CONSTRAINT FK_49708925A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE admin_rubrique DROP FOREIGN KEY FK_1B040E7A642B8210');
        $this->addSql('ALTER TABLE admin_rubrique DROP FOREIGN KEY FK_1B040E7A3BD38833');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32BF396750');
        $this->addSql('ALTER TABLE fournisseur_type_materiel DROP FOREIGN KEY FK_524C559D670C757F');
        $this->addSql('ALTER TABLE fournisseur_type_materiel DROP FOREIGN KEY FK_524C559D5D91DD3E');
        $this->addSql('ALTER TABLE fournisseur_type_service DROP FOREIGN KEY FK_A0DDD7B6670C757F');
        $this->addSql('ALTER TABLE fournisseur_type_service DROP FOREIGN KEY FK_A0DDD7B6F05F7FC3');
        $this->addSql('ALTER TABLE viticulteur DROP FOREIGN KEY FK_C978DC4ABF396750');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE admin_rubrique');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE fournisseur_type_materiel');
        $this->addSql('DROP TABLE fournisseur_type_service');
        $this->addSql('DROP TABLE viticulteur');
        $this->addSql('ALTER TABLE `user` ADD num_cire VARCHAR(14) DEFAULT NULL, ADD valide TINYINT(1) DEFAULT NULL, DROP discriminator');
        $this->addSql('DROP INDEX IDX_2BB0D92E681FBEF2 ON resultat_questionnaire');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD utilisateur_id INT NOT NULL, DROP viticulteur_id');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD CONSTRAINT FK_2BB0D92EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2BB0D92EFB88E14F ON resultat_questionnaire (utilisateur_id)');
        $this->addSql('ALTER TABLE vigne DROP FOREIGN KEY FK_7DA054A0681FBEF2');
        $this->addSql('ALTER TABLE vigne ADD CONSTRAINT FK_7DA054A0681FBEF2 FOREIGN KEY (viticulteur_id) REFERENCES user (id)');
    }
}
