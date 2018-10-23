<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181015181638 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vendor DROP adresse, DROP number, DROP banni, DROP email, DROP inscription, DROP date, DROP password, DROP try, DROP type, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F6BF396750 FOREIGN KEY (id) REFERENCES visitor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F6BF396750');
        $this->addSql('ALTER TABLE vendor ADD adresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, ADD number INT NOT NULL, ADD banni TINYINT(1) NOT NULL, ADD email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD inscription TINYINT(1) NOT NULL, ADD date DATE NOT NULL, ADD password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD try INT NOT NULL, ADD type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
