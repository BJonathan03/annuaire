<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181015172417 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE locality (id INT AUTO_INCREMENT NOT NULL, locality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visitor ADD locality_id INT NOT NULL');
        $this->addSql('ALTER TABLE visitor ADD CONSTRAINT FK_CAE5E19F88823A92 FOREIGN KEY (locality_id) REFERENCES locality (id)');
        $this->addSql('CREATE INDEX IDX_CAE5E19F88823A92 ON visitor (locality_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visitor DROP FOREIGN KEY FK_CAE5E19F88823A92');
        $this->addSql('DROP TABLE locality');
        $this->addSql('DROP INDEX IDX_CAE5E19F88823A92 ON visitor');
        $this->addSql('ALTER TABLE visitor DROP locality_id');
    }
}
