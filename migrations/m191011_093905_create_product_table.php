<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m191011_093905_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer(11),
            'category_id' => $this->integer(11),
            'shop_id' => $this->integer(11),
            'manufacture_id' => $this->integer(11),
            'name' => $this->string(255),
            'description' => $this->text(),
            'price' => $this->double(),
            'discount' => $this->integer(255),
            'create_date' => $this->dateTime(),
            'update_date' => $this->dateTime(),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
