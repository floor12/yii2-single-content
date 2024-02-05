<?php

namespace floor12\simple_content;

use app\models\entity\SingleContentItem;
use app\models\enum\Role;
use floor12\editmodal\EditModalHelper;
use floor12\files\components\PictureWidget;
use floor12\files\models\File;
use yii\base\Widget;
use yii\helpers\Html;

class SingleContentItemWidget extends Widget
{
    public $id;

    public function run(): string
    {
        $content = strval(SingleContentItem::get($this->id));
        if (!$content)
            $content = 'нет контента';
        if (\Yii::$app->user->can(Role::ADMIN)) {
            $content = Html::tag('span', $content, [
                'class' => 'single-content-item-content',
                'data-id' => $this->id,
                'onclick' => EditModalHelper::showForm('/single-content-item/form', ['id' => $this->id])
            ]);
        }

        if (preg_match_all('/{{image: ([\w\%]*), width: ([\d\%]*), alt: ([\d\w ]*)}}/', $content, $mapMatches)) {
            foreach ($mapMatches[1] as $resultKey => $hash) {
                $widget = PictureWidget::widget([
                    'model' => File::findOne(['hash' => $hash]),
                    'alt' => $mapMatches[3][$resultKey],
                    'width' => $mapMatches[2][$resultKey],
                ]);
                $content = str_replace($mapMatches[0][$resultKey], $widget, $content);
            }
        }
        return $content;
    }
}