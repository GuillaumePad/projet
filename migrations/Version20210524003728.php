<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524003728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kanji (id INT AUTO_INCREMENT NOT NULL, caractere VARCHAR(255) NOT NULL, cle VARCHAR(255) DEFAULT NULL, kunyomi VARCHAR(255) DEFAULT NULL, onyomi VARCHAR(255) DEFAULT NULL, stroke INT NOT NULL, sens VARCHAR(255) NOT NULL, niveau VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanji_kanji (kanji_source INT NOT NULL, kanji_target INT NOT NULL, INDEX IDX_9466F04E415D8476 (kanji_source), INDEX IDX_9466F04E58B8D4F9 (kanji_target), PRIMARY KEY(kanji_source, kanji_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kanji_kanji ADD CONSTRAINT FK_9466F04E415D8476 FOREIGN KEY (kanji_source) REFERENCES kanji (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_kanji ADD CONSTRAINT FK_9466F04E58B8D4F9 FOREIGN KEY (kanji_target) REFERENCES kanji (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kanji_kanji DROP FOREIGN KEY FK_9466F04E415D8476');
        $this->addSql('ALTER TABLE kanji_kanji DROP FOREIGN KEY FK_9466F04E58B8D4F9');
        $this->addSql('DROP TABLE kanji');
        $this->addSql('DROP TABLE kanji_kanji');
    }
}
