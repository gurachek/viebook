<?php

use yii\db\Migration;

class m170719_114409_rename_author_column extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('authors', 'first_name');
        $this->dropColumn('authors', 'second_name');
        $this->dropColumn('authors', 'surname');
        $this->dropColumn('authors', 'pseudo');

        $this->addColumn('authors', 'name', $this->string());
    }

    public function safeDown()
    {
        echo "m170719_114409_rename_author_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170719_114409_rename_author_column cannot be reverted.\n";

        return false;
    }
    */
}
