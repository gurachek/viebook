<?php

use yii\db\Migration;

class m170720_033740_add_nicename_column_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'nicename', $this->string());
    }

    public function safeDown()
    {
        echo "m170720_033740_add_nicename_column_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170720_033740_add_nicename_column_to_user cannot be reverted.\n";

        return false;
    }
    */
}
