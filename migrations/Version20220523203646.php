<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523203646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE municipality ADD region_id INT NOT NULL, ADD district_id INT NOT NULL');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F5662898260155 FOREIGN KEY (region_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F56628B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('CREATE INDEX IDX_C6F5662898260155 ON municipality (region_id)');
        $this->addSql('CREATE INDEX IDX_C6F56628B08FA272 ON municipality (district_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE municipality DROP FOREIGN KEY FK_C6F5662898260155');
        $this->addSql('ALTER TABLE municipality DROP FOREIGN KEY FK_C6F56628B08FA272');
        $this->addSql('DROP INDEX IDX_C6F5662898260155 ON municipality');
        $this->addSql('DROP INDEX IDX_C6F56628B08FA272 ON municipality');
        $this->addSql('ALTER TABLE municipality DROP region_id, DROP district_id');
    }
}
