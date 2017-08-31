<?php

use yii\db\Migration;

class m170825_182256_add_columns_to_books extends Migration
{
    public function safeUp()
    {
        $this->addColumn('books', 'level', $this->integer());
        $this->addColumn('books', 'pages', $this->integer());
    }

    public function safeDown()
    {
        echo "m170825_182256_add_columns_to_books cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170825_182256_add_columns_to_books cannot be reverted.\n";

        return false;
    }
    */
}
