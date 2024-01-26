<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\review;

use humhub\modules\ui\menu\MenuLink;
use humhub\widgets\TopMenu;
use Yii;
use yii\base\Event;

/**
 * Description of Events
 *
 * @author luke
 */
class Events
{

    /**
     * TopMenu init event callback
     *
     * @see TopMenu
     * @param Event $event
     */
    public static function onTopMenuInit($event)
    {
        /** @var TopMenu $topMenu */
        $topMenu = $event->sender;

        $topMenu->addEntry(new MenuLink([
            'id' => 'review',
            'label' => Yii::t('ReviewModule.base', 'Review'),
            'url' => ['/review/index'],
            'icon' => 'review',
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('review')
        ]));
    }

}