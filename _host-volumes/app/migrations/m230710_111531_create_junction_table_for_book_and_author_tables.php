<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_author}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 * - `{{%author}}`
 */
class m230710_111531_create_junction_table_for_book_and_author_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(book_id, author_id)',
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-book_author-book_id}}',
            '{{%book_author}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-book_author-book_id}}',
            '{{%book_author}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-book_author-author_id}}',
            '{{%book_author}}',
            'author_id'
        );

        // add foreign key for table `{{%author}}`
        $this->addForeignKey(
            '{{%fk-book_author-author_id}}',
            '{{%book_author}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-book_author-book_id}}',
            '{{%book_author}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-book_author-book_id}}',
            '{{%book_author}}'
        );

        // drops foreign key for table `{{%author}}`
        $this->dropForeignKey(
            '{{%fk-book_author-author_id}}',
            '{{%book_author}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-book_author-author_id}}',
            '{{%book_author}}'
        );

        $this->dropTable('{{%book_author}}');
    }
}
