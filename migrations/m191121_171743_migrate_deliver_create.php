<?php

use yii\db\Migration;

/**
 * Class m191121_171743_migrate_deliver_create
 */
class m191121_171743_migrate_deliver_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_171743_migrate_deliver_create cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_171743_migrate_deliver_create cannot be reverted.\n";

        return false;
    }
    */
}
