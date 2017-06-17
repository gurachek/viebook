<?php

use yii\db\Migration;

class m170617_144730_add_user_rating extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'rating', $this->double());
    }

    public function down()
    {
        echo "m170617_144730_add_user_rating cannot be reverted.\n";

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
