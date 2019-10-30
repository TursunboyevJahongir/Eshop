<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m191011_094657_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'region_id' => $this->integer(11),
            'address_id' => $this->integer(11),
            'type_pay' => $this->string(255),
            'comment' => $this->text(),
            'sum' => $this->double(),
            'paid' => $this->boolean()->defaultValue(0)
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
