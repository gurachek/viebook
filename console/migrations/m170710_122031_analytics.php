<?php

use yii\db\Migration;

class m170710_122031_analytics extends Migration
{
    public function up()
    {
        $this->createTable('analytics', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'review_id' => $this->integer(),
            'book_id' => $this->integer(),
            'key' => $this->string(),
            'value' => $this->string(),
            'time' => $this->string(),
        ]);
    }

    public function down()
    {
        echo "m170710_122031_analytics cannot be reverted.\n";

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
