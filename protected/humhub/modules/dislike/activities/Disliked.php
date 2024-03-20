<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\dislike\activities;

use Yii;
use humhub\modules\activity\components\BaseActivity;
use humhub\modules\activity\interfaces\ConfigurableActivityInterface;

/**
 * Like Activity
 *
 * @author luke
 */
class Disliked extends BaseActivity implements ConfigurableActivityInterface
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'dislike';

    /**
     * @inheritdoc
     */
    public $viewName = 'disliked';

    /**
     * @inheritdoc
     */
    public function getViewParams($params = [])
    {
        $dislike = $this->source;
        $dislikeSource = $dislike->getSource();
        $params['preview'] = $this->getContentInfo($dislikeSource);
        return parent::getViewParams($params);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('DislikeModule.activities', 'Dislikes');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('DislikeModule.activities', 'Whenever someone dislikes something (e.g. a post or comment).');
    }

}
