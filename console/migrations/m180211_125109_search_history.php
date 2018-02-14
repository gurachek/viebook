<?php

use yii\db\Migration;

/**
 * Class m180211_125109_search_history
 */
class m180211_125109_search_history extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('search_history', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'query' => $this->string()->notNull(),
            'time' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180211_125109_search_history cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180211_125109_search_history cannot be reverted.\n";

        return false;
    }
    */
}
