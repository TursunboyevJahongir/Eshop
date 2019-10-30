<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop}}`.
 */
class m191011_093739_create_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('shop', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'phone' => $this->integer(15)->notNull(),
            'password' => $this->string(40)->notNull(),
            'description' => $this->text()->notNull(),
            'longitude' => $this->string(255),
            'latitude' => $this->string(255),
            'create_date' => $this->dateTime(),
            'update_date' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop}}');
    }
}
