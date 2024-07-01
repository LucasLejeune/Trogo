<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624123623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_equipment (user_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_D3D85867A76ED395 (user_id), INDEX IDX_D3D85867517FE9FE (equipment_id), PRIMARY KEY(user_id, equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_equipment ADD CONSTRAINT FK_D3D85867A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_equipment ADD CONSTRAINT FK_D3D85867517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, DROP description, DROP username');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_equipment DROP FOREIGN KEY FK_D3D85867A76ED395');
        $this->addSql('ALTER TABLE user_equipment DROP FOREIGN KEY FK_D3D85867517FE9FE');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE user_equipment');
        $this->addSql('ALTER TABLE user ADD description LONGTEXT NOT NULL, ADD username VARCHAR(25) NOT NULL, DROP first_name, DROP last_name');
    }
}
