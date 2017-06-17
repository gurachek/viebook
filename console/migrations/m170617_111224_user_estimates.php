<?php

use yii\db\Migration;

class m170617_111224_user_estimates extends Migration
{
    public function up()
    {
        $this->createTable('user_estimates', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'entry_id' => $this->integer(),
            'estimate' => $this->integer(),
        ]);
    }

    public function down()
    {
        echo "m170617_111224_user_estimates cannot be reverted.\n";

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
