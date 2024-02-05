<?php

use yii\db\Migration;

/**
 * Class m220803_054259_single_content_item
 */
class m220803_054259_single_content_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%single_content_item}}', [
            'id' => $this->string()->notNull(),
            'content' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('single_content_item-pk', 'single_content_item', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%single_content_item}}');
    }
}