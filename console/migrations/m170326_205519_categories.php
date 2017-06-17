<?php

use yii\db\Migration;

class m170326_205519_categories extends Migration
{
    public function up()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(0),
            'name' => $this->string()->notNull(),
            'desc' => $this->string()->notNull(),
            'image' => $this->string(),
        ]);
    }

    public function down()
    {
        echo "m170326_205519_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
