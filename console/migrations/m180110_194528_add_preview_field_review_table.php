<?php

use yii\db\Migration;

/**
 * Class m180110_194528_add_preview_field_review_table
 */
class m180110_194528_add_preview_field_review_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('reviews', 'preview', $this->text()->notNull()->defaultValue(""));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180110_194528_add_preview_field_review_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180110_194528_add_preview_field_review_table cannot be reverted.\n";

        return false;
    }
    */
}
