<?php

namespace floor12\simple_content\controllers;

use app\models\entity\SingleContentItem;
use app\models\enum\Role;
use floor12\editmodal\EditModalAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SingleContentItemController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [\Yii::$app->getModule('simple_content')->administratorRoleName
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'form' => ['GET', 'POST'],
                    ],
                ],
            ];
    }

    public function actions(): array
    {
        return [
            'form' => [
                'class' => EditModalAction::class,
                'strictIntegerKey' => false,
                'model' => SingleContentItem::class,
                'message' => 'Object saved',
            ],
        ];
    }
}
