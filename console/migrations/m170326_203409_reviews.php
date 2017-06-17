<?php

use yii\db\Migration;

class m170326_203409_reviews extends Migration
{
    public function up()
    {
        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->unique(),
            'author_id' => $this->integer()->notNull(),
            'rating' => $this->double()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'shedule_date' => $this->integer(),
            'active' => $this->integer()->defaultValue(0),
            'book_id' => $this->integer()->notNull(),
            'views' =>  $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        echo "m170326_203409_reviews cannot be reverted.\n";

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
