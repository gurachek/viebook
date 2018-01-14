<?php

use yii\db\Migration;

/**
 * Class m180110_210359_add_subscribe_column_user_table
 */
class m180110_210359_add_subscribe_column_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'subscribe', $this->integer()->notNull()->defaultValue(1));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180110_210359_add_subscribe_column_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180110_210359_add_subscribe_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
