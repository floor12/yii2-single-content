<?php

namespace floor12\single_content\models;

use yii2mod\enum\helpers\BaseEnum;

class ContentType extends BaseEnum
{
    const TEXT = 1;
    const IMAGE = 2;

    public static $list = [
        self::TEXT => 'Text',
        self::IMAGE => 'Image',
    ];

}