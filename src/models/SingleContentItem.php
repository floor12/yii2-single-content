<?php

namespace floor12\single_content\models;

use floor12\files\components\FileBehaviour;
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
 * @property int $type_id
 * @property File $image
 * @property Files[] $images
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
            [['key'], 'required'],
            [['content', 'key'], 'string'],
            [['type_id'], 'integer'],
            ['images', 'file', 'maxFiles' => 10, 'extensions' => 'jpg, jpeg, webm, png, gif'],
            ['image', 'file', 'maxFiles' => 1, 'extensions' => 'jpg, jpeg, webm, png, gif'],
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
    public static function get(string $elementKey, $type_id = ContentType::TEXT): self
    {
        $content = \Yii::$app->cache->getOrSet(self::CACHE_TAG, function () {
            return self::find()->indexBy('key')->all();
        }, 0, new TagDependency(['tags' => [self::CACHE_TAG]]));

        if (isset($content[$elementKey])) {
            return $content[$elementKey];
        }
        $model = new self(['key' => $elementKey, 'content' => 'empty block', 'type_id' => $type_id]);
        $model->save();
        return $model;
    }

    public function behaviors(): array
    {
        return [
            'yii\behaviors\TimestampBehavior',
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'defaultValue' => 1
            ],
            'files' => [
                'class' => FileBehaviour::class,
                'attributes' => ['images', 'image'],
            ]
        ];
    }
}
