<?php

use yii\db\Migration;

class m170724_223831_password_reset extends Migration
{
    public function safeUp()
    {
        $this->createTable('password_reset', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'time' => $this->string()->notNull(),
        ]);
    }   

    public function safeDown()
    {
        echo "m170724_223831_password_reset cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170724_223831_password_reset cannot be reverted.\n";

        return false;
    }
    */
}
