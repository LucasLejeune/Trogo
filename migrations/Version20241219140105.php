<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219140105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON user_workout');
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_F51DD535A6CCCFC9');
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_F51DD535A76ED395');
        $this->addSql('ALTER TABLE user_workout ADD PRIMARY KEY (user_id, workout_id)');
        $this->addSql('DROP INDEX idx_f51dd535a76ed395 ON user_workout');
        $this->addSql('CREATE INDEX IDX_3C92E578A76ED395 ON user_workout (user_id)');
        $this->addSql('DROP INDEX idx_f51dd535a6cccfc9 ON user_workout');
        $this->addSql('CREATE INDEX IDX_3C92E578A6CCCFC9 ON user_workout (workout_id)');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_F51DD535A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_F51DD535A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON user_workout');
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_3C92E578A76ED395');
        $this->addSql('ALTER TABLE user_workout DROP FOREIGN KEY FK_3C92E578A6CCCFC9');
        $this->addSql('ALTER TABLE user_workout ADD PRIMARY KEY (workout_id, user_id)');
        $this->addSql('DROP INDEX idx_3c92e578a76ed395 ON user_workout');
        $this->addSql('CREATE INDEX IDX_F51DD535A76ED395 ON user_workout (user_id)');
        $this->addSql('DROP INDEX idx_3c92e578a6cccfc9 ON user_workout');
        $this->addSql('CREATE INDEX IDX_F51DD535A6CCCFC9 ON user_workout (workout_id)');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_3C92E578A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_workout ADD CONSTRAINT FK_3C92E578A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
    }
}
