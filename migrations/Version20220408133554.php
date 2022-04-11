<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408133554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employes ADD client_id INT NOT NULL, ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employes ADD CONSTRAINT FK_A94BC0F019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE employes ADD CONSTRAINT FK_A94BC0F0ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_A94BC0F019EB6921 ON employes (client_id)');
        $this->addSql('CREATE INDEX IDX_A94BC0F0ED5CA9E6 ON employes (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employes DROP FOREIGN KEY FK_A94BC0F019EB6921');
        $this->addSql('ALTER TABLE employes DROP FOREIGN KEY FK_A94BC0F0ED5CA9E6');
        $this->addSql('DROP INDEX IDX_A94BC0F019EB6921 ON employes');
        $this->addSql('DROP INDEX IDX_A94BC0F0ED5CA9E6 ON employes');
        $this->addSql('ALTER TABLE employes DROP client_id, DROP service_id');
    }
}
