<?php

namespace floor12\single_content\widgets;

use floor12\editmodal\EditModalAsset;
use floor12\editmodal\EditModalHelper;
use floor12\files\components\PictureWidget;
use floor12\files\models\File;
use floor12\single_content\models\ContentType;
use floor12\single_content\models\SingleContentItem;
use yii\base\Widget;
use yii\helpers\Html;

class SingleContentItemWidget extends Widget
{
    public $id;

    public function run(): string
    {
        $model = SingleContentItem::get($this->id, ContentType::TEXT);
        $role = \Yii::$app->getModule('single_content')->administratorRoleName;
        if (!\Yii::$app->user->isGuest && ($role == '@' || \Yii::$app->user->can($role))) {
            EditModalAsset::register($this->getView());
            $model->content = Html::tag('span', $model->content, [
                'class' => 'single-content-item-content',
                'data-id' => $this->id,
                'style' => 'cursor: pointer;',
                'onclick' => EditModalHelper::showForm('/single_content/single-content-item/form', ['id' => $model->id])
            ]);
        }

        if (preg_match_all('/{{image: ([\w\%]*), width: ([\d\%]*), alt: ([\d\w ]*)}}/', $model->content, $mapMatches)) {
            foreach ($mapMatches[1] as $resultKey => $hash) {
                $widget = PictureWidget::widget(['model' => File::findOne(['hash' => $hash]),
                    'alt' => $mapMatches[3][$resultKey],
                    'width' => $mapMatches[2][$resultKey],]);
                $model->content = str_replace($mapMatches[0][$resultKey], $widget, $model->content);
            }
        }
        return $model->content;
    }
}