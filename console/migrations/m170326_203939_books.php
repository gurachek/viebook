<?php

use yii\db\Migration;

class m170326_203939_books extends Migration
{
    public function up()
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'publish_date' => $this->string()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
            'category' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        echo "m170326_203939_books cannot be reverted.\n";

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
