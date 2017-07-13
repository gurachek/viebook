<?php

use yii\db\Migration;

class m170710_122503_book_tags extends Migration
{
    public function up()
    {
        $this->createTable('book_tags', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        echo "m170710_122503_book_tags cannot be reverted.\n";

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
