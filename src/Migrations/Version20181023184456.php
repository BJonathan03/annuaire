<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181023184456 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image ADD logo_id INT DEFAULT NULL, ADD pictures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF98F144A FOREIGN KEY (logo_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBC415685 FOREIGN KEY (pictures_id) REFERENCES vendor (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FF98F144A ON image (logo_id)');
        $this->addSql('CREATE INDEX IDX_C53D045FBC415685 ON image (pictures_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF98F144A');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBC415685');
        $this->addSql('DROP INDEX IDX_C53D045FF98F144A ON image');
        $this->addSql('DROP INDEX IDX_C53D045FBC415685 ON image');
        $this->addSql('ALTER TABLE image DROP logo_id, DROP pictures_id');
    }
}
