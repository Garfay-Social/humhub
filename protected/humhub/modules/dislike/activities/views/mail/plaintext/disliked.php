<?php

use humhub\modules\user\models\User;

/* @var $originator User */
/* @var $preview string */

echo Yii::t('DislikeModule.activities', '{userDisplayName} dislikes {contentTitle}', [
    '{userDisplayName}' => $originator->displayName,
    '{contentTitle}' => $preview,
]);
