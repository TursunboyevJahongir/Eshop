<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m191011_093750_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(11),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
            'image' => $this->string(255),
            'thumb_128' => $this->string(255),
            'thumb_255' => $this->string(255),
            'thumb_1024' => $this->string(255),
            'view' => $this->integer(100)->defaultValue(0),
            'create_date' => $this->dateTime(),
            'update_date' => $this->dateTime(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
