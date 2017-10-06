<?php

use yii\db\Migration;

class m171006_001933_add_image_field_category_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('categories', 'image', $this->string());
    }

    public function safeDown()
    {
        echo "m171006_001933_add_image_field_category_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_001933_add_image_field_category_table cannot be reverted.\n";

        return false;
    }
    */
}
