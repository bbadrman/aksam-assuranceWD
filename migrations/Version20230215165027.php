<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215165027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fonction_user DROP FOREIGN KEY FK_F8A9981557889920');
        $this->addSql('ALTER TABLE fonction_user DROP FOREIGN KEY FK_F8A99815A76ED395');
        $this->addSql('DROP TABLE fonction_user');
        $this->addSql('ALTER TABLE prospect ADD source VARCHAR(50) NOT NULL, ADD type_prospect VARCHAR(50) DEFAULT NULL, ADD raison_sociale VARCHAR(255) DEFAULT NULL, ADD code_post INT DEFAULT NULL, ADD gsm VARCHAR(255) DEFAULT NULL, ADD assure VARCHAR(20) DEFAULT NULL, ADD last_assure VARCHAR(20) DEFAULT NULL, ADD motif_resil VARCHAR(50) DEFAULT NULL, DROP model, DROP brand, DROP carburant, DROP rregime');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fonction_user (fonction_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F8A99815A76ED395 (user_id), INDEX IDX_F8A9981557889920 (fonction_id), PRIMARY KEY(fonction_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fonction_user ADD CONSTRAINT FK_F8A9981557889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fonction_user ADD CONSTRAINT FK_F8A99815A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prospect ADD model VARCHAR(255) NOT NULL, ADD brand VARCHAR(255) NOT NULL, ADD carburant VARCHAR(255) NOT NULL, ADD rregime VARCHAR(255) NOT NULL, DROP source, DROP type_prospect, DROP raison_sociale, DROP code_post, DROP gsm, DROP assure, DROP last_assure, DROP motif_resil');
    }
}
