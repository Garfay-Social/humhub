<?php

namespace humhub\modules\review\controllers;

use humhub\components\behaviors\AccessControl;
use humhub\components\Controller;
use humhub\modules\dashboard\components\actions\DashboardStreamAction;
use humhub\modules\ui\view\components\View;
use Yii;

class ReviewController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'showProfilePostForm' => Yii::$app->getModule('review')->settings->get('showProfilePostForm'),
            'contentContainer' => Yii::$app->user->getIdentity()
        ]);
        }
    }
?>