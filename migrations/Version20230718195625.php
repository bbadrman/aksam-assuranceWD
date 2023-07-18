<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230718195625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D14D45BBE FOREIGN KEY (autor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D10C5C333 FOREIGN KEY (comrcl_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D14D45BBE');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D10C5C333');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D296CD8AE');
    }
}
