<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%papular}}`.
 */
class m191011_093921_create_papular_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('popular', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%papular}}');
    }
}
