<?php

use yii\db\Migration;

/**
 * Class m250125_132124_add_type_to_single_content
 */
class m250125_132124_add_type_to_single_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn('single_content_item', 'type_id', $this->integer()->defaultValue(1)->after('id'));
        $this->addColumn('single_content_item', 'key', $this->string());
        $sql = "UPDATE single_content_item SET key=id";
        $this->execute($sql);
        $models = \floor12\single_content\models\SingleContentItem::find()->all();
        $this->dropColumn('single_content_item', 'id');
        $this->addColumn('single_content_item', 'id', $this->primaryKey());
        foreach ($models as $key => $model) {
            $this->execute("UPDATE single_content_item SET id=" . ($key + 1) . "  WHERE key='{$model->key}'");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn('single_content_item', 'type_id');
        $this->dropColumn('single_content_item', 'key');
    }
}