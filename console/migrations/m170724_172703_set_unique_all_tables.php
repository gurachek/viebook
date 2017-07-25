<?php

use yii\db\Migration;

class m170724_172703_set_unique_all_tables extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('authors', 'name', $this->string()->notNull()->unique());
        $this->alterColumn('books', 'name', $this->string()->notNull()->unique());
        $this->alterColumn('reviews', 'title', $this->string()->notNull()->unique());
    }

    public function safeDown()
    {
        echo "m170724_172703_set_unique_all_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170724_172703_set_unique_all_tables cannot be reverted.\n";

        return false;
    }
    */
}
