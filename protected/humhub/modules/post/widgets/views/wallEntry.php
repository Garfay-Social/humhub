<?php

use humhub\modules\content\widgets\richtext\RichText;
use humhub\modules\content\widgets\stream\WallStreamEntryOptions;
use humhub\modules\post\models\Post;

/* @var $post Post */
/* @var $renderOptions WallStreamEntryOptions */
/* @var $enableDynamicFontSize bool */

$isDetailView = $renderOptions->isViewContext(WallStreamEntryOptions::VIEW_CONTEXT_DETAIL);

?>
<div data-ui-widget="post.Post" <?php if (!$isDetailView) : ?>data-state="collapsed"<?php endif; ?>
     data-dynamic-font-size="<?= intval($enableDynamicFontSize) ?>" data-ui-init id="post-content-<?= $post->id ?>">
    <div data-ui-markdown <?php if (!$isDetailView) : ?>data-ui-show-more<?php endif; ?>>
        <?= RichText::output($post->message, ['record' => $post]) ?>

        <?php 
        // Retrieve star rating from DB and display on user post
        $starRating = Post::find()
        ->select('starRating')
        ->where(['id' => $post->id])
        ->scalar();

        for ($i = 1; $i <= 5; $i++) {
            // Determine highlighted stars
            $starClass = $i <= $starRating ? 'selected' : '';
            
            // Display on post
            echo '<span class="star ' . $starClass . ' posted" data-value="' . $i . '">&#9733;</span>';
        }
        ?>
    </div>
</div>
