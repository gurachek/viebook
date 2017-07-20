<?php

use yii\db\Migration;

class m170719_223259_change_default_rating_value_user_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('user', 'rating', $this->integer()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        echo "m170719_223259_change_default_rating_value_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170719_223259_change_default_rating_value_user_table cannot be reverted.\n";

        return false;
    }
    */
}
