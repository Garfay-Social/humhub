<?php

use yii\helpers\Html;

echo Yii::t('DislikeModule.activities', '{userDisplayName} dislikes {contentTitle}', [
    '{userDisplayName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
    '{contentTitle}' => $preview,
]);
?>
