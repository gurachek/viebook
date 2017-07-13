<?php

use yii\db\Migration;

class m170710_123706_rename_author_id extends Migration
{
    public function up()
    {
        $this->renameColumn('reviews', 'author_id', 'user_id');
    }

    public function down()
    {
        echo "m170710_123706_rename_author_id cannot be reverted.\n";

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
