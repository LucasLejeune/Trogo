<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219132319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_workout (id INT AUTO_INCREMENT NOT NULL, workout_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3C92E578A6CCCFC9 (workout_id), INDEX IDX_3C92E578A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_3C92E578A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id)');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_3C92E578A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72A76ED395');
        $this->addSql('DROP INDEX IDX_649FFB72A76ED395 ON workout');
        $this->addSql('ALTER TABLE workout CHANGE user_id created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_649FFB72B03A8386 ON workout (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_3C92E578A6CCCFC9');
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_3C92E578A76ED395');
        $this->addSql('DROP TABLE user_workout');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72B03A8386');
        $this->addSql('DROP INDEX IDX_649FFB72B03A8386 ON workout');
        $this->addSql('ALTER TABLE workout CHANGE created_by_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_649FFB72A76ED395 ON workout (user_id)');
    }
}
