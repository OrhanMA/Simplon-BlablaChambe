<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525120559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ride_rule DROP FOREIGN KEY FK_DE799B8302A8A70');
        $this->addSql('ALTER TABLE ride_rule DROP FOREIGN KEY FK_DE799B8744E0351');
        $this->addSql('DROP TABLE ride_rule');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ride_rule (ride_id INT NOT NULL, rule_id INT NOT NULL, INDEX IDX_DE799B8302A8A70 (ride_id), INDEX IDX_DE799B8744E0351 (rule_id), PRIMARY KEY(ride_id, rule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ride_rule ADD CONSTRAINT FK_DE799B8302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_rule ADD CONSTRAINT FK_DE799B8744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
