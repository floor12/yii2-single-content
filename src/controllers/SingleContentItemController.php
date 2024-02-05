<?php

namespace floor12\single_content\controllers;

use app\models\enum\Role;
use floor12\editmodal\EditModalAction;
use floor12\single_content\models\SingleContentItem;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SingleContentItemController extends Controller
{
    public function behaviors(): array
    {
        $role = \Yii::$app->getModule('single_content')->administratorRoleName;
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [$role]
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
