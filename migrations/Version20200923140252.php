<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200923140252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD quack_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD3950CA9 FOREIGN KEY (quack_id) REFERENCES quack_entity (id)');
        $this->addSql('CREATE INDEX IDX_9474526CD3950CA9 ON comment (quack_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD3950CA9');
        $this->addSql('DROP INDEX IDX_9474526CD3950CA9 ON comment');
        $this->addSql('ALTER TABLE comment DROP quack_id');
    }
}
