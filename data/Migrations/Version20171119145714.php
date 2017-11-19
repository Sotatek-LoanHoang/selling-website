<?php declare (strict_types = 1);

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171119145714 extends AbstractMigration
{
  public function up(Schema $schema)
  {
    // Create 'cart_item' table
    $table = $schema->createTable('cart_item');
    $table->addColumn('user_id', 'integer', ['notnull' => true]);
    $table->addColumn('book_id', 'integer', ['notnull' => true]);
    $table->addColumn('quantity', 'integer', ['notnull' => true]);
    $table->addForeignKeyConstraint(
      'book',
      ['book_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'cart_item_book_id_fk'
    );
    $table->addForeignKeyConstraint(
      'user',
      ['user_id'],
      ['id'],
      ['onDelete' => 'CASCADE', 'onUpdate' => 'CASCADE'],
      'cart_item_user_id_fk'
    );
    $table->setPrimaryKey(['user_id', 'book_id']);
    $table->addOption('engine', 'InnoDB');
  }

  public function down(Schema $schema)
  {
    $schema->dropTable('cart_item');
  }
}
