<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%recome}}`.
 */
class m191011_093943_create_recome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('recome', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%recome}}');
    }
}
