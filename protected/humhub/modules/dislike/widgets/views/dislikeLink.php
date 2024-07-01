<?php

use yii\helpers\Html;

humhub\modules\dislike\assets\DislikeAsset::register($this);
?>

<span class="dislikeLinkContainer" id="dislikeLinkContainer_<?= $id ?>">

    <?php if (Yii::$app->user->isGuest): ?>
        <?= Html::a('<i class="fa fa-thumbs-down"></i>', Yii::$app->user->loginUrl, ['data-target' => '#globalModal']); ?>
    <?php else: ?>
        <a href="#" data-action-click="dislike.toggleDislike" data-action-url="<?= $dislikeUrl ?>" class="dislike dislikeAnchor<?= !$canDislike ? ' disabled' : '' ?>" style="<?= (!$currentUserDisliked) ? '' : 'display:none'?>">
            <i class="fa fa-thumbs-down"></i>
        </a>
        <a href="#" data-action-click="dislike.toggleDislike" data-action-url="<?= $undislikeUrl ?>" class="undislike dislikeAnchor<?= !$canDislike ? ' disabled' : '' ?>" style="<?= ($currentUserDisliked) ? '' : 'display:none'?>">
            <i class="fa fa-thumbs-up"></i>
        </a>
    <?php endif; ?>

    <!-- Create link to show all users, who disliked this -->
    <a href="<?= $userListUrl; ?>" data-target="#globalModal">
        <?php if (count($dislikes)) : ?>
            <span class="dislikeCount tt" data-placement="top" data-toggle="tooltip" title="<?= $title ?>">(<?= count($dislikes) ?>)</span>
        <?php else: ?>
            <span class="dislikeCount"></span>
        <?php endif; ?>
    </a>

</span>
