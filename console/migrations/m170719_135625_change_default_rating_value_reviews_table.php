<?php

use yii\db\Migration;

class m170719_135625_change_default_rating_value_reviews_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('reviews', 'rating', $this->integer()->notNull()->defaultValue(100));
    }

    public function safeDown()
    {
        echo "m170719_135625_change_default_rating_value_reviews_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170719_135625_change_default_rating_value_reviews_table cannot be reverted.\n";

        return false;
    }
    */
}
