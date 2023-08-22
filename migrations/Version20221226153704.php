<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221226153704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_team (product_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_490884BE4584665A (product_id), INDEX IDX_490884BE296CD8AE (team_id), PRIMARY KEY(product_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_team ADD CONSTRAINT FK_490884BE4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_team ADD CONSTRAINT FK_490884BE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_team DROP FOREIGN KEY FK_490884BE4584665A');
        $this->addSql('ALTER TABLE product_team DROP FOREIGN KEY FK_490884BE296CD8AE');
        $this->addSql('DROP TABLE product_team');
    }
}
