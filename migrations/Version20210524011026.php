<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524011026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kanji_composant (kanji_id INT NOT NULL, composant_id INT NOT NULL, INDEX IDX_5B03B3DFB3081B8 (kanji_id), INDEX IDX_5B03B3D7F3310E7 (composant_id), PRIMARY KEY(kanji_id, composant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kanji_composant ADD CONSTRAINT FK_5B03B3DFB3081B8 FOREIGN KEY (kanji_id) REFERENCES kanji (id)');
        $this->addSql('ALTER TABLE kanji_composant ADD CONSTRAINT FK_5B03B3D7F3310E7 FOREIGN KEY (composant_id) REFERENCES kanji (id)');
        $this->addSql('DROP TABLE kanji_radical');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kanji_radical (kanji_id INT NOT NULL, radical_id INT NOT NULL, INDEX IDX_DA88A1FFB3081B8 (kanji_id), INDEX IDX_DA88A1FD26378D3 (radical_id), PRIMARY KEY(kanji_id, radical_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE kanji_radical ADD CONSTRAINT FK_DA88A1FD26378D3 FOREIGN KEY (radical_id) REFERENCES kanji (id)');
        $this->addSql('ALTER TABLE kanji_radical ADD CONSTRAINT FK_DA88A1FFB3081B8 FOREIGN KEY (kanji_id) REFERENCES kanji (id)');
        $this->addSql('DROP TABLE kanji_composant');
    }
}
