<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624125956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE body_zone (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_equipment (exercise_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_7DEFD369E934951A (exercise_id), INDEX IDX_7DEFD369517FE9FE (equipment_id), PRIMARY KEY(exercise_id, equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_body_zone (exercise_id INT NOT NULL, body_zone_id INT NOT NULL, INDEX IDX_5BB87A8FE934951A (exercise_id), INDEX IDX_5BB87A8F76DA863D (body_zone_id), PRIMARY KEY(exercise_id, body_zone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_muscle (exercise_id INT NOT NULL, muscle_id INT NOT NULL, INDEX IDX_865E8C84E934951A (exercise_id), INDEX IDX_865E8C84354FDBB4 (muscle_id), PRIMARY KEY(exercise_id, muscle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE muscle (id INT AUTO_INCREMENT NOT NULL, body_zone_id INT NOT NULL, INDEX IDX_F31119EF76DA863D (body_zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout_user (workout_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F51DD535A6CCCFC9 (workout_id), INDEX IDX_F51DD535A76ED395 (user_id), PRIMARY KEY(workout_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout_exercise (workout_id INT NOT NULL, exercise_id INT NOT NULL, INDEX IDX_76AB38AAA6CCCFC9 (workout_id), INDEX IDX_76AB38AAE934951A (exercise_id), PRIMARY KEY(workout_id, exercise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_equipment ADD CONSTRAINT FK_7DEFD369E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_equipment ADD CONSTRAINT FK_7DEFD369517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_body_zone ADD CONSTRAINT FK_5BB87A8FE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_body_zone ADD CONSTRAINT FK_5BB87A8F76DA863D FOREIGN KEY (body_zone_id) REFERENCES body_zone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_muscle ADD CONSTRAINT FK_865E8C84E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_muscle ADD CONSTRAINT FK_865E8C84354FDBB4 FOREIGN KEY (muscle_id) REFERENCES muscle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE muscle ADD CONSTRAINT FK_F31119EF76DA863D FOREIGN KEY (body_zone_id) REFERENCES body_zone (id)');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_exercise ADD CONSTRAINT FK_76AB38AAA6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_exercise ADD CONSTRAINT FK_76AB38AAE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_equipment DROP FOREIGN KEY FK_7DEFD369E934951A');
        $this->addSql('ALTER TABLE exercise_equipment DROP FOREIGN KEY FK_7DEFD369517FE9FE');
        $this->addSql('ALTER TABLE exercise_body_zone DROP FOREIGN KEY FK_5BB87A8FE934951A');
        $this->addSql('ALTER TABLE exercise_body_zone DROP FOREIGN KEY FK_5BB87A8F76DA863D');
        $this->addSql('ALTER TABLE exercise_muscle DROP FOREIGN KEY FK_865E8C84E934951A');
        $this->addSql('ALTER TABLE exercise_muscle DROP FOREIGN KEY FK_865E8C84354FDBB4');
        $this->addSql('ALTER TABLE muscle DROP FOREIGN KEY FK_F31119EF76DA863D');
        $this->addSql('ALTER TABLE workout_user DROP FOREIGN KEY FK_F51DD535A6CCCFC9');
        $this->addSql('ALTER TABLE workout_user DROP FOREIGN KEY FK_F51DD535A76ED395');
        $this->addSql('ALTER TABLE workout_exercise DROP FOREIGN KEY FK_76AB38AAA6CCCFC9');
        $this->addSql('ALTER TABLE workout_exercise DROP FOREIGN KEY FK_76AB38AAE934951A');
        $this->addSql('DROP TABLE body_zone');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE exercise_equipment');
        $this->addSql('DROP TABLE exercise_body_zone');
        $this->addSql('DROP TABLE exercise_muscle');
        $this->addSql('DROP TABLE muscle');
        $this->addSql('DROP TABLE workout');
        $this->addSql('DROP TABLE workout_user');
        $this->addSql('DROP TABLE workout_exercise');
    }
}
