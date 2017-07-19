<?php

use yii\db\Migration;

class m170719_134202_user_estimates_time extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user_estimates', 'time', $this->string());
    }

    public function safeDown()
    {
        echo "m170719_134202_user_estimates_time cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170719_134202_user_estimates_time cannot be reverted.\n";

        return false;
    }
    */
}
