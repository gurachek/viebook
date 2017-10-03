<?php

use yii\db\Migration;

class m171002_220025_add_active_field_books_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('books', 'active', $this->integer()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        echo "m171002_220025_add_active_field_books_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171002_220025_add_active_field_books_table cannot be reverted.\n";

        return false;
    }
    */
}
