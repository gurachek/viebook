<?php

use yii\db\Migration;

class m171003_022702_add_about_field_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'about', $this->text());
    }

    public function safeDown()
    {
        echo "m171003_022702_add_about_field_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171003_022702_add_about_field_user_table cannot be reverted.\n";

        return false;
    }
    */
}
