<?php

use yii\db\Migration;

class m170714_125912_author_track extends Migration
{
    public function safeUp()
    {
        $this->createTable('author_track', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'author_id' => $this->integer(),
            'time' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        echo "m170714_125912_author_track cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170714_125912_author_track cannot be reverted.\n";

        return false;
    }
    */
}
