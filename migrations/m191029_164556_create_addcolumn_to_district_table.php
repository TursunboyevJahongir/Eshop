<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addcolumn_to_district}}`.
 */
class m191029_164556_create_addcolumn_to_district_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('district','region_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%addcolumn_to_district}}');
    }
}
