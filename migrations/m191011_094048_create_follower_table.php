<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%follower}}`.
 */
class m191011_094048_create_follower_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('follower', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(11),
            'user_id' => $this->integer(11)
        ]);



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%follower}}');
    }
}
