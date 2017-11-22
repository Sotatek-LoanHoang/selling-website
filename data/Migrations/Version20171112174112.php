<?php declare (strict_types = 1);

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171112174112 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    // Create 'book' table
    $table = $schema->createTable('book');
    $table->addColumn('id', 'integer', ['autoincrement' => true]);
    $table->addColumn('title', 'string', ['notnull' => true, 'length' => 64]);
    $table->addColumn('base_price', 'integer', ['notnull' => true]);
    $table->addColumn('description', 'string', ['notnull' => false, 'length' => 128]);
    $table->addColumn('publisher', 'string', ['notnull' => false, 'length' => 128]);
    $table->addColumn('print_length', 'integer', ['notnull' => false]);
    $table->addColumn('release_date', 'date', ['notnull' => false]);
    $table->setPrimaryKey(['id']);
    $table->addUniqueIndex(['title'], 'title_idx');
    $table->addOption('engine', 'InnoDB');
    // Create 'author' table
    $table = $schema->createTable('author');
    $table->addColumn('id', 'integer', ['autoincrement' => true]);
    $table->addColumn('name', 'string', ['notnull' => true, 'length' => 64]);
    $table->setPrimaryKey(['id']);
    $table->addUniqueIndex(['name'], 'name_idx');
    $table->addOption('engine', 'InnoDB');
    // Create 'genre' table
    $table = $schema->createTable('genre');
    $table->addColumn('id', 'integer', ['autoincrement' => true]);
    $table->addColumn('name', 'string', ['notnull' => true, 'length' => 64]);
    $table->setPrimaryKey(['id']);
    $table->addUniqueIndex(['name'], 'name_idx');
    $table->addOption('engine', 'InnoDB');
    // Create 'series' table
    $table = $schema->createTable('series');
    $table->addColumn('id', 'integer', ['autoincrement' => true]);
    $table->addColumn('name', 'string', ['notnull' => true, 'length' => 64]);
    $table->setPrimaryKey(['id']);
    $table->addUniqueIndex(['name'], 'name_idx');
    $table->addOption('engine', 'InnoDB');
    // Create 'book_author' table
    $table = $schema->createTable('book_author');
    $table->addColumn('id', 'integer', ['autoincrement' => true]);
    $table->addColumn('book_id', 'integer', ['notnull' => true]);
    $table->addColumn('author_id', 'integer', ['notnull' => true]);
    $table->setPrimaryKey(['id']);
    $table->addForeignKeyConstraint(
      'book',
      ['book_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'book_author_book_id_fk'
    );
    $table->addForeignKeyConstraint(
      'author',
      ['author_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'book_author_author_id_fk'
    );
    $table->addOption('engine', 'InnoDB');
    // Create 'book_genre' table
    $table = $schema->createTable('book_genre');
    $table->addColumn('id', 'integer', ['autoincrement' => true]);
    $table->addColumn('book_id', 'integer', ['notnull' => true]);
    $table->addColumn('genre_id', 'integer', ['notnull' => true]);
    $table->setPrimaryKey(['id']);
    $table->addForeignKeyConstraint(
      'book',
      ['book_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'book_genre_book_id_fk'
    );
    $table->addForeignKeyConstraint(
      'genre',
      ['genre_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'book_genre_genre_id_fk'
    );
    $table->addOption('engine', 'InnoDB');
    // Create 'book_series' table
    $table = $schema->createTable('book_series');
    $table->addColumn('id', 'integer', ['autoincrement' => true]);
    $table->addColumn('book_id', 'integer', ['notnull' => true]);
    $table->addColumn('series_id', 'integer', ['notnull' => true]);
    $table->setPrimaryKey(['id']);
    $table->addForeignKeyConstraint(
      'book',
      ['book_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'book_series_book_id_fk'
    );
    $table->addForeignKeyConstraint(
      'series',
      ['series_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'book_series_series_id_fk'
    );
    $table->addOption('engine', 'InnoDB');
  }

  public function down(Schema $schema)
  {
    $schema->dropTable('book');
    $schema->dropTable('author');
    $schema->dropTable('series');
    $schema->dropTable('genre');
    $schema->dropTable('book_author');
    $schema->dropTable('book_series');
    $schema->dropTable('book_genre');
  }
}
