<?php

use yii\db\Migration;

class m170720_102829_user_interested extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_interested', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'time' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        echo "m170720_102829_user_interested cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170720_102829_user_interested cannot be reverted.\n";

        return false;
    }
    */
}
