<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219135419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_3C92E578A76ED395');
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_3C92E578A6CCCFC9');
        $this->addSql('DROP TABLE user_workout');
        $this->addSql('CREATE TABLE user_workout (workout_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F51DD535A6CCCFC9 (workout_id), INDEX IDX_F51DD535A76ED395 (user_id), PRIMARY KEY(workout_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_F51DD535A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_F51DD535A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_F51DD535A6CCCFC9');
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_F51DD535A76ED395');
        $this->addSql('DROP TABLE user_workout');
        $this->addSql('CREATE TABLE user_workout (id INT AUTO_INCREMENT NOT NULL, workout_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3C92E578A6CCCFC9 (workout_id), INDEX IDX_3C92E578A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_3C92E578A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_3C92E578A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id)');
    }
}
