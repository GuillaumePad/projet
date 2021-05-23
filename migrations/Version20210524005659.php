<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524005659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kanji_radical (kanji_id INT NOT NULL, radical_id INT NOT NULL, INDEX IDX_DA88A1FFB3081B8 (kanji_id), INDEX IDX_DA88A1FD26378D3 (radical_id), PRIMARY KEY(kanji_id, radical_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kanji_radical ADD CONSTRAINT FK_DA88A1FFB3081B8 FOREIGN KEY (kanji_id) REFERENCES kanji (id)');
        $this->addSql('ALTER TABLE kanji_radical ADD CONSTRAINT FK_DA88A1FD26378D3 FOREIGN KEY (radical_id) REFERENCES kanji (id)');
        $this->addSql('DROP TABLE kanji_kanji');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kanji_kanji (kanji_source INT NOT NULL, kanji_target INT NOT NULL, INDEX IDX_9466F04E58B8D4F9 (kanji_target), INDEX IDX_9466F04E415D8476 (kanji_source), PRIMARY KEY(kanji_source, kanji_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE kanji_kanji ADD CONSTRAINT FK_9466F04E415D8476 FOREIGN KEY (kanji_source) REFERENCES kanji (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kanji_kanji ADD CONSTRAINT FK_9466F04E58B8D4F9 FOREIGN KEY (kanji_target) REFERENCES kanji (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE kanji_radical');
    }
}
