<?php

use yii\db\Migration;

/**
 * Class m180214_165651_create_table_topics
 */
class m180214_165651_create_table_topics extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('topics', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'describe' => $this->string(), 
            'time' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('topics');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180214_165651_create_table_topics cannot be reverted.\n";

        return false;
    }
    */
}
