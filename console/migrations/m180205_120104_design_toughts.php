<?php

use yii\db\Migration;

/**
 * Class m180205_120104_design_toughts
 */
class m180205_120104_design_toughts extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('design_toughts', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(0),
            'opinion' => $this->integer()->notNull(),
            'time' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180205_120104_design_toughts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180205_120104_design_toughts cannot be reverted.\n";

        return false;
    }
    */
}
