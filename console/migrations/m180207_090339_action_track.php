<?php

use yii\db\Migration;

/**
 * Class m180207_090339_action_track
 */
class m180207_090339_action_track extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('action_track', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'name' => $this->string()->notNull(),
            'action_type' => $this->string()->notNull(),
            'time' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180207_090339_action_track cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180207_090339_action_track cannot be reverted.\n";

        return false;
    }
    */
}
