<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manufacture}}`.
 */
class m191026_024108_create_manufacture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->createTable('manufacture', [
            'id' => $this->primaryKey(),
                'name' => $this->string(),
                'ico' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%manufacture}}');
    }
}
