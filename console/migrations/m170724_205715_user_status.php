<?php

use yii\db\Migration;

class m170724_205715_user_status extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'active', $this->integer()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        echo "m170724_205715_user_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170724_205715_user_status cannot be reverted.\n";

        return false;
    }
    */
}
