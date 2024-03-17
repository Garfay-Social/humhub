<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2020 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\dislike\permissions;

use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;

/**
 * CanDislike Permission
 */
class CanDislike extends \humhub\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        Space::USERGROUP_OWNER,
        Space::USERGROUP_ADMIN,
        Space::USERGROUP_MODERATOR,
        Space::USERGROUP_MEMBER,
        Space::USERGROUP_USER,
        User::USERGROUP_SELF,
        User::USERGROUP_FRIEND,
        User::USERGROUP_USER,
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        Space::USERGROUP_GUEST,
        User::USERGROUP_GUEST,
    ];

    /**
     * @inheritdoc
     */
    protected $title;

    /**
     * @inheritdoc
     */
    protected $description;

    /**
     * @inheritdoc
     */
    protected $moduleId = 'dislike';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('DislikeModule.permissions', 'Can dislike');
        $this->description = \Yii::t('DislikeModule.permissions', 'Allows user to dislike content');
    }

}
