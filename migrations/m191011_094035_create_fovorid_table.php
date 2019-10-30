<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fovorid}}`.
 */
class m191011_094035_create_fovorid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favourite', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11),
            'user_id' => $this->integer(11)
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%favourite}}');
    }
}
