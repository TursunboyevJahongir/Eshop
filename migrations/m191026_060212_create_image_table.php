<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 */
class m191026_060212_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'path' => $this->string(),
            'thumb_1024' => $this->string(),
            'thumb_256' => $this->string(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image}}');
    }
}
