<?php

use yii\db\Migration;

/**
 * Class m180226_182800_add_verified_column_user_table
 */
class m180226_182800_add_verified_column_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'verified', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180226_182800_add_verified_column_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180226_182800_add_verified_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
