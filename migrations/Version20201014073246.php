<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014073246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription ADD participant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D69D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D69D1C3019 ON inscription (participant_id)');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B115DAC5993');
        $this->addSql('DROP INDEX IDX_D79F6B115DAC5993 ON participant');
        $this->addSql('ALTER TABLE participant DROP inscription_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D69D1C3019');
        $this->addSql('DROP INDEX IDX_5E90F6D69D1C3019 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP participant_id');
        $this->addSql('ALTER TABLE participant ADD inscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B115DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D79F6B115DAC5993 ON participant (inscription_id)');
    }
}
