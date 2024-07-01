<?php

use yii\helpers\Html;

humhub\modules\like\assets\LikeAsset::register($this);
?>

<span class="likeLinkContainer" id="likeLinkContainer_<?= $id ?>">

    <?php if (Yii::$app->user->isGuest): ?>
        <?= Html::a('<i class="fa fa-thumbs-up"></i>', Yii::$app->user->loginUrl, ['data-target' => '#globalModal']); ?>
    <?php else: ?>
        <a href="#" data-action-click="like.toggleLike" data-action-url="<?= $likeUrl ?>" class="like likeAnchor<?= !$canLike ? ' disabled' : '' ?><?php echo $currentUserLiked ? ' liked' : ''; ?>" style="<?= (!$currentUserLiked) ? '' : 'display:none'?>">
            <i class="fa fa-thumbs-up"></i>
        </a>
        <a href="#" data-action-click="like.toggleLike" data-action-url="<?= $unlikeUrl ?>" class="unlike likeAnchor<?= !$canLike ? ' disabled' : '' ?><?php echo $currentUserLiked ? '' : ' unliked'; ?>" style="<?= ($currentUserLiked) ? '' : 'display:none'?>">
            <i class="fa fa-thumbs-up"></i>
        </a>
    <?php endif; ?>

    <!-- Create link to show all users, who liked this -->
    <a href="<?= $userListUrl; ?>" data-target="#globalModal">
        <?php if (count($likes)) : ?>
            <span class="likeCount tt" data-placement="top" data-toggle="tooltip" title="<?= $title ?>">(<?= count($likes) ?>)</span>
        <?php else: ?>
            <span class="likeCount"></span>
        <?php endif; ?>
    </a>

</span>
