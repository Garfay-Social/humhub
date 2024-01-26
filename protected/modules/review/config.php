<?php

use humhub\modules\dashboard\Module;
use humhub\widgets\TopMenu;

return [
    'id' => 'review',
    'class' => Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => TopMenu::class, 'event' => TopMenu::EVENT_INIT, 'callback' => ['\humhub\modules\review\Events', 'onTopMenuInit']],
    ],
    'urlManagerRules' => [
        'review' => 'review/review'
    ]
];