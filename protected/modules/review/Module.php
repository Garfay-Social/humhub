<?php

namespace humhub\modules\review;

use Yii;

class Module extends \humhub\components\Module
{
    public $controllerNamespace = 'humhub\modules\review\controllers';

    /**
     * @return static
     */
    public static function getModuleInstance()
    {
        /* @var $module static */
        $module = Yii::$app->getModule('review');
        return $module;
    }
}
