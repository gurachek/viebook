<?php

use yii\db\Migration;

class m170720_025448_change_default_image_value_user_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('user', 'image', $this->string()->notNull()->defaultValue('no-photo.jpg'));
    }

    public function safeDown()
    {
        echo "m170720_025448_change_default_image_value_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170720_025448_change_default_image_value_user_table cannot be reverted.\n";

        return false;
    }
    */
}
