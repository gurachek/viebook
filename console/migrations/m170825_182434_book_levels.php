<?php

use yii\db\Migration;

class m170825_182434_book_levels extends Migration
{
    public function safeUp()
    {
        $this->createTable('book_levels', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
            'time' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        echo "m170825_182434_book_levels cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170825_182434_book_levels cannot be reverted.\n";

        return false;
    }
    */
}
