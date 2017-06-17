<?php

use yii\db\Migration;

class m170617_145624_reviews_user_viewed extends Migration
{
    public function up()
    {
        $this->createTable();
    }

    public function down()
    {
        echo "m170617_145624_reviews_user_viewed cannot be reverted.\n";

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
