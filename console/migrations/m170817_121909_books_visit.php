<?php

use yii\db\Migration;

class m170817_121909_books_visit extends Migration
{
    public function safeUp()
    {
        $this->createTable('books_visit', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'time' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        echo "m170817_121909_books_visit cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170817_121909_books_visit cannot be reverted.\n";

        return false;
    }
    */
}
