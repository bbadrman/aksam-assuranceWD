<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308175657 extends AbstractMigration
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
        $this->addSql('ALTER TABLE prospect ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_C9CE8C7D296CD8AE ON prospect (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fonction_user (fonction_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F8A99815A76ED395 (user_id), INDEX IDX_F8A9981557889920 (fonction_id), PRIMARY KEY(fonction_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fonction_user ADD CONSTRAINT FK_F8A9981557889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fonction_user ADD CONSTRAINT FK_F8A99815A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D296CD8AE');
        $this->addSql('DROP INDEX IDX_C9CE8C7D296CD8AE ON prospect');
        $this->addSql('ALTER TABLE prospect DROP team_id');
    }
}
