<?php

use yii\db\Migration;

class m170724_203338_user_confirmatio extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_confirmation', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'code' => $this->string()->notNull(),
            'time' => $this->string()->notNull(),
        ]);
    }   

    public function safeDown()
    {
        echo "m170724_203338_user_confirmatio cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170724_203338_user_confirmatio cannot be reverted.\n";

        return false;
    }
    */
}
