<?php

namespace humhub\modules\dislike\widgets;

use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\dislike\models\Dislike as DislikeModel;
use humhub\modules\dislike\Module;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This widget is used to show a like link inside the wall entry controls.
 *
 * @package humhub.modules_core.like
 * @since 0.5
 */
class DislikeLink extends \yii\base\Widget
{

    /**
     * The Object to be liked
     *
     * @var LikeModel|ContentActiveRecord
     */
    public $object;

    /**
     * @inheritdoc
     */
    public function beforeRun()
    {
        /* @var Module $module */
        $module = Yii::$app->getModule('dislike');

        if (!$module->canDislike($this->object)) {
            return false;
        }

        return parent::beforeRun();
    }

    /**
     * Executes the widget.
     */
    public function run()
    {
        $currentUserDisliked = false;
        /** @var Module $module */
        $module = Yii::$app->getModule('dislike');
        $canDislike = $module->canDislike($this->object);

        $dislikes = DislikeModel::GetDislikes(get_class($this->object), $this->object->id);
        foreach ($dislikes as $dislike) {
            if ($dislike->user->id == Yii::$app->user->id) {
                $currentUserDisliked = true;
            }
        }

        return $this->render('dislikeLink', [
                    'canDislike' => $canDislike,
                    'object' => $this->object,
                    'dislikes' => $dislikes,
                    'currentUserDisliked' => $currentUserDisliked,
                    'id' => $this->object->getUniqueId(),
                    'dislikeUrl' => Url::to(['/dislike/dislike/dislike', 'contentModel' => get_class($this->object), 'contentId' => $this->object->id]),
                    'undislikeUrl' => Url::to(['/dislike/dislike/undislike', 'contentModel' => get_class($this->object), 'contentId' => $this->object->id]),
                    'userListUrl' => Url::to(['/dislike/dislike/user-list', 'contentModel' => get_class($this->object), 'contentId' => $this->object->getPrimaryKey()]),
                    'title' => $this->generateDislikeTitleText($currentUserDisliked, $dislikes)
        ]);
    }

    private function generateDislikeTitleText($currentUserDisliked, $dislikes)
    {
        $userlist = ""; // variable for users output
        $maxUser = 5; // limit for rendered users inside the tooltip
        $previewUserCount = 0;

        // if the current user also likes
        if ($currentUserDisliked == true) {
            // if only one user likes
            if (count($dislikes) == 1) {
                // output, if the current user is the only one
                return Yii::t('DislikeModule.base', 'You dislike this.');
            } else {
                // output, if more users like this
                $userlist .= Yii::t('DislikeModule.base', 'You'). "\n";
                $previewUserCount++;
            }
        }

        for ($i = 0, $dislikesCount = count($dislikes); $i < $dislikesCount; $i++) {

            // if only one user likes
            if ($dislikesCount == 1) {
                // check, if you liked
                if ($dislikes[$i]->user->guid != Yii::$app->user->guid) {
                    // output, if an other user liked
                    return Html::encode($dislikes[$i]->user->displayName) . Yii::t('DislikeModule.base', ' dislikes this.');
                }
            } else {
                // check, if you liked
                if ($dislikes[$i]->user->guid != Yii::$app->user->guid) {
                    // output, if an other user liked
                    $userlist .= Html::encode($dislikes[$i]->user->displayName). "\n";
                    $previewUserCount++;
                }

                // check if exists more user as limited
                if ($i == $maxUser) {
                    if ((int)(count($dislikes) - $previewUserCount) !== 0) {
                        // output with the number of not rendered users
                        $userlist .= Yii::t('DislikeModule.base', 'and {count} more dislike this.', ['{count}' => (int)(count($dislikes) - $previewUserCount)]);
                    }

                    // stop the loop
                    break;
                }
            }
        }

        return $userlist;
    }

}

?>
