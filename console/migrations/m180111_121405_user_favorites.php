<?php

use yii\db\Migration;

/**
 * Class m180111_121405_user_favorites
 */
class m180111_121405_user_favorites extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user_favorites', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'review_id' => $this->integer(),
            'time' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180111_121405_user_favorites cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180111_121405_user_favorites cannot be reverted.\n";

        return false;
    }
    */
}
