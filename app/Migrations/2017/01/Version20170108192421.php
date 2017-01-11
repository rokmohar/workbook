<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170108192421 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE posts (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, content LONGTEXT NOT NULL, type INT UNSIGNED NOT NULL, privacy INT UNSIGNED NOT NULL, state INT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_885DBAFAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_reactions (post_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, INDEX IDX_991D01444B89032C (post_id), INDEX IDX_991D0144A76ED395 (user_id), PRIMARY KEY(post_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comments (id INT UNSIGNED AUTO_INCREMENT NOT NULL, post_id INT UNSIGNED DEFAULT NULL, respondent_id INT UNSIGNED DEFAULT NULL, content VARCHAR(255) NOT NULL, state INT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E0731F8B4B89032C (post_id), INDEX IDX_E0731F8BCE80CD19 (respondent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE post_reactions ADD CONSTRAINT FK_991D01444B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE post_reactions ADD CONSTRAINT FK_991D0144A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE post_comments ADD CONSTRAINT FK_E0731F8B4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE post_comments ADD CONSTRAINT FK_E0731F8BCE80CD19 FOREIGN KEY (respondent_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post_reactions DROP FOREIGN KEY FK_991D01444B89032C');
        $this->addSql('ALTER TABLE post_comments DROP FOREIGN KEY FK_E0731F8B4B89032C');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE post_reactions DROP FOREIGN KEY FK_991D0144A76ED395');
        $this->addSql('ALTER TABLE post_comments DROP FOREIGN KEY FK_E0731F8BCE80CD19');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE post_reactions');
        $this->addSql('DROP TABLE post_comments');
    }
}
