<?php

use yii\db\Migration;

class m170326_204150_authors extends Migration
{
    public function up()
    {
        $this->createTable('authors', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'second_name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'pseudo' => $this->string(),
            'birthday' => $this->string()->notNull()->defaultValue('yyyy-mm-dd'),
            'biography' => $this->text()->notNull(),
            'image' => $this->string()
        ]);
    }

    public function down()
    {
        echo "m170326_204150_authors cannot be reverted.\n";

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
