<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221221154236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction_user (fonction_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F8A9981557889920 (fonction_id), INDEX IDX_F8A99815A76ED395 (user_id), PRIMARY KEY(fonction_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fonction_user ADD CONSTRAINT FK_F8A9981557889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fonction_user ADD CONSTRAINT FK_F8A99815A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fonction_user DROP FOREIGN KEY FK_F8A9981557889920');
        $this->addSql('ALTER TABLE fonction_user DROP FOREIGN KEY FK_F8A99815A76ED395');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE fonction_user');
    }
}
