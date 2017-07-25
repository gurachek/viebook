<?php

use yii\db\Migration;

class m170725_191459_delete_reset_password extends Migration
{
    public function safeUp()
    {
        $this->dropTable('password_reset');
    }

    public function safeDown()
    {
        echo "m170725_191459_delete_reset_password cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170725_191459_delete_reset_password cannot be reverted.\n";

        return false;
    }
    */
}
