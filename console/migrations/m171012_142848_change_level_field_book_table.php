<?php

use yii\db\Migration;

class m171012_142848_change_level_field_book_table extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('books', 'level', 'level_id');
    }

    public function safeDown()
    {
        echo "m171012_142848_change_level_field_book_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171012_142848_change_level_field_book_table cannot be reverted.\n";

        return false;
    }
    */
}
