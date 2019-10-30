<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertise}}`.
 */
class m191011_093811_create_advertise_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('advertise', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
            'image' => $this->string(255),
            'thumb_128' => $this->string(255),
            'thumb_255' => $this->string(255),
            'thumb_1024' => $this->string(255),
            'create_date' => $this->dateTime(),
            'update_date' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advertise}}');
    }
}
