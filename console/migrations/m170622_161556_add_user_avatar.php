<?php

use yii\db\Migration;

class m170622_161556_add_user_avatar extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'image', $this->string());
    }

    public function down()
    {
        echo "m170622_161556_add_user_avatar cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
