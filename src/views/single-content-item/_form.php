<?php
/**
 * @var $this yii\web\View
 * @var $model SingleContentItem
 * @var $form yii\widgets\ActiveForm
 */

use conquer\codemirror\CodemirrorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'modal-form',
    'options' => ['class' => 'modaledit-form'],
    'enableClientValidation' => true,
]); ?>


    <div class='modal-body not-animated-label'>
        <?= $form->field($model, 'content')
            ->label(false)
            ->textarea(['rows' => 10,]); ?>
    </div>

    <div class='modal-footer'>
        <?php echo Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default modaledit-disable']); ?>
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']); ?>
    </div>
<?php ActiveForm::end(); ?>