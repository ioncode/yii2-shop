<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notification}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%subscription}}`
 */
class m230711_001509_create_notification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'subscription_id' => $this->integer()->notNull(),
            'create_time' => $this->timestamp()->notNull()->defaultExpression('NOW()'),
            'update_time' => $this->timestamp()->defaultExpression('NOW()')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'text' => $this->string(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'result' => $this->text(),
        ]);

        // creates index for column `subscription_id`
        $this->createIndex(
            '{{%idx-notification-subscription_id}}',
            '{{%notification}}',
            'subscription_id'
        );

        // add foreign key for table `{{%subscription}}`
        $this->addForeignKey(
            '{{%fk-notification-subscription_id}}',
            '{{%notification}}',
            'subscription_id',
            '{{%subscription}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%subscription}}`
        $this->dropForeignKey(
            '{{%fk-notification-subscription_id}}',
            '{{%notification}}'
        );

        // drops index for column `subscription_id`
        $this->dropIndex(
            '{{%idx-notification-subscription_id}}',
            '{{%notification}}'
        );

        $this->dropTable('{{%notification}}');
    }
}
