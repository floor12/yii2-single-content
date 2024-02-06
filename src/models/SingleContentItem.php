<?php

namespace floor12\single_content\models;

use Yii;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "settings".
 *
 * @property string $id
 * @property string $content
 * @property string $created_at [integer]
 * @property string $updated_at [integer]
 * @property string $created_by [integer]
 * @property string $updated_by [integer]
 */
class SingleContentItem extends ActiveRecord
{

    const CACHE_TAG = 'single_content_item_cache';

    public static function tableName(): string
    {
        return 'single_content_item';
    }


    public function rules(): array
    {
        return [
            [['id', 'content',], 'required'],
        ];
    }


    public function attributeLabels(): array
    {
        return [
            'id' => 'Block name',
            'content' => 'Content'
        ];
    }

    /**
     * @return ActiveQuery the active query used by this AR class.
     */
    public static function find(): ActiveQuery
    {
        return new ActiveQuery(\get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, [self::CACHE_TAG]);
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @throws \Exception
     */
    public static function get(string $settingName): float|array|string|null
    {

        $settings = \Yii::$app->cache->getOrSet(self::CACHE_TAG, function () {
            return self::find()->indexBy('id')->all();
        }, 0, new TagDependency(['tags' => [self::CACHE_TAG]]));

        if (isset($settings[$settingName])) {
            return $settings[$settingName]->content;
        }
        $model = new self(['id' => $settingName, 'content' => 'empty block']);
        $model->save();
        return '';
    }

    public function behaviors(): array
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
        ];
    }
}
