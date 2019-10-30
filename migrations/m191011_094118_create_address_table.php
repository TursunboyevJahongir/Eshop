<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m191011_094118_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer(11),
            'address' => $this->text()
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
