<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\dislike\controllers;

use humhub\modules\dislike\Module;
use Yii;
use humhub\modules\dislike\models\Like;
use humhub\modules\user\widgets\UserListBox;
use humhub\modules\content\components\ContentAddonController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Like Controller
 *
 * Handles requests by the like widgets. (e.g. like, unlike, show likes)
 *
 * @property Module $module
 * @since 0.5
 */
class DislikeController extends ContentAddonController
{

    /**
     * @param $action
     * @return bool
     * @throws HttpException
     */
    public function beforeAction($action)
    {
        if (!$this->module->isEnabled) {
            throw new HttpException(404, 'The dislike module not enabled!');
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::class,
                'guestAllowedActions' => ['show-dislikes']
            ]
        ];
    }

    /**
     * Creates a new like
     */
    public function actionDislike()
    {
        if (!$this->module->canDislike($this->parentContent)) {
            throw new ForbiddenHttpException();
        }

        $this->forcePostRequest();

        $dislike = Dislike::findOne(['object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::$app->user->id]);
        if ($dislike === null) {

            // Create Like Object
            $disllike = new Dislike([
                'object_model' => $this->contentModel,
                'object_id' => $this->contentId
            ]);
            $dislike->save();
        }

        return $this->actionShowDislikes();
    }

    /**
     * Unlikes an item
     */
    public function actionUndislike()
    {
        $this->forcePostRequest();

        if (!Yii::$app->user->isGuest) {
            $dislike = Dislike::findOne(['object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::$app->user->id]);
            if ($dislike !== null) {
                $dislike->delete();
            }
        }

        return $this->actionShowDislikes();
    }

    /**
     * Returns an JSON with current like informations about a target
     */
    public function actionShowDislikes()
    {
        Yii::$app->response->format = 'json';

        // Some Meta Infos
        $currentUserDisliked = false;

        $dislikes = Dislike::GetDislikes($this->contentModel, $this->contentId);

        foreach ($dislikes as $dislike) {
            if ($dislike->user->id == Yii::$app->user->id) {
                $currentUserDisliked = true;
            }
        }

        return [
            'currentUserDisliked' => $currentUserDisliked,
            'dislikeCounter' => count($dislikes)
        ];
    }

    /**
     * Returns a user list which contains all users who likes it
     */
    public function actionUserList()
    {

        $query = \humhub\modules\user\models\User::find();
        $query->leftJoin('dislike', 'dislike.created_by=user.id');
        $query->where([
            'dislike.object_id' => $this->contentId,
            'dislike.object_model' => $this->contentModel,
        ]);
        $query->orderBy('dislike.created_at DESC');

        $title = Yii::t('DislikeModule.base', "<strong>Users</strong> who dislike this");

        return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
    }

}
