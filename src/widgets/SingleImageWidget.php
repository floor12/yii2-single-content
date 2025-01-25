<?php

namespace floor12\single_content\widgets;

use floor12\editmodal\EditModalAsset;
use floor12\editmodal\EditModalHelper;
use floor12\files\components\PictureWidget;
use floor12\single_content\models\ContentType;
use floor12\single_content\models\SingleContentItem;
use yii\base\Widget;
use yii\helpers\Html;

class SingleImageWidget extends Widget
{
    public $id;
    public $width;
    public $alt;

    public function run(): string
    {
        $contentItem = SingleContentItem::get($this->id, ContentType::IMAGE);
        if (!$contentItem->image)
            $content = 'no image';
        else {
            $content = PictureWidget::widget([
                'model' => $contentItem->image,
                'alt' => $this->alt,
                'width' => $this->width,
            ]);
        }
        $role = \Yii::$app->getModule('single_content')->administratorRoleName;
        if (!\Yii::$app->user->isGuest && ($role == '@' || \Yii::$app->user->can($role))) {
            EditModalAsset::register($this->getView());
            $content = Html::tag('span', $content, [
                'class' => 'single-content-item-content',
                'data-id' => $this->id,
                'style' => 'cursor: pointer;',
                'onclick' => EditModalHelper::showForm('/single_content/single-content-item/form', ['id' => $contentItem->id])
            ]);
        }

        return $content;
    }
}