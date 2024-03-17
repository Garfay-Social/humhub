<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\dislike\notifications;

use humhub\modules\content\interfaces\ContentOwner;
use Yii;
use yii\bootstrap\Html;
use humhub\modules\notification\components\BaseNotification;

/**
 * Notifies a user about likes of his objects (posts, comments, tasks & co)
 *
 * @since 0.5
 */
class NewDislike extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'dislike';

    /**
     * @inheritdoc
     */
    public $viewName = 'newDislike';

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new DislikeNotificationCategory();
    }

    /**
     * @inheritdoc
     */
    public function getGroupKey()
    {
        $model = $this->getDislikedRecord();
        return get_class($model) . '-' . $model->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getMailSubject()
    {
        $model = $this->getDislikedRecord();

        if(!$model instanceof ContentOwner) {
            return '';
        }

        $contentInfo = $this->getContentPlainTextInfo($model);

        if ($this->groupCount > 1) {
            return Yii::t('DislikeModule.notifications', "{displayNames} dislikes your {contentTitle}.", [
                        'displayNames' => $this->getGroupUserDisplayNames(false),
                        'contentTitle' => $contentInfo
            ]);
        }

        return Yii::t('DislikeModule.notifications', "{displayName} dislikes your {contentTitle}.", [
                    'displayName' => $this->originator->displayName,
                    'contentTitle' => $contentInfo
        ]);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        $model = $this->getDislikedRecord();

        if(!$model instanceof ContentOwner) {
            return '';
        }

        $contentInfo = $this->getContentInfo($model);

        if ($this->groupCount > 1) {
            return Yii::t('DislikeModule.notifications', "{displayNames} dislikes {contentTitle}.", [
                        'displayNames' => $this->getGroupUserDisplayNames(),
                        'contentTitle' => $contentInfo
            ]);
        }

        return Yii::t('DislikeModule.notifications', "{displayName} dislikes {contentTitle}.", [
                    'displayName' => Html::tag('strong', Html::encode($this->originator->displayName)),
                    'contentTitle' => $contentInfo
        ]);
    }

    /**
     * The liked record
     *
     * @return \humhub\components\ActiveRecord
     */
    public function getDislikedRecord()
    {
        return $this->source->getSource();
    }
}
