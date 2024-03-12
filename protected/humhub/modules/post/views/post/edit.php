<?php

use humhub\modules\file\handler\BaseFileHandler;
use humhub\modules\file\widgets\FileHandlerButtonDropdown;
use humhub\modules\file\widgets\FilePreview;
use humhub\modules\file\widgets\UploadButton;
use humhub\modules\file\widgets\UploadProgress;
use humhub\modules\post\models\forms\PostEditForm;
use humhub\widgets\Button;
use humhub\modules\content\widgets\richtext\RichTextField;
use yii\bootstrap\ActiveForm;

/* @var $model PostEditForm */
/* @var $submitUrl string */
/* @var $fileHandlers BaseFileHandler[] */
?>
<div class="content content_edit" id="post_edit_<?= $model->post->id; ?>">

    <div class="star-rating" data-rating="0">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'post-edit-form_' . $model->post->id]); ?>

        <div class="post-richtext-input-group">

        <?= $form->field($model->post, 'starRating')->hiddenInput(['id' => 'starRatingInput'])->label(false) ?>

            <?= $form->field($model->post, 'message')->widget(RichTextField::class, [
                'id' => 'post_input_'. $model->post->id,
                'layout' => RichTextField::LAYOUT_INLINE,
                'focus' => true,
                'pluginOptions' => ['maxHeight' => '300px'],
                'placeholder' => Yii::t('PostModule.base', 'Edit your post...')
            ])->label(false) ?>

            <div class="comment-buttons"><?php
                $uploadButton = UploadButton::widget([
                    'id' => 'post_upload_' . $model->post->id,
                    'tooltip' => Yii::t('ContentModule.base', 'Attach Files'),
                    'model' => $model,
                    'dropZone' => '#post_edit_' . $model->post->id . ':parent',
                    'preview' => '#post_upload_preview_' . $model->post->id,
                    'progress' => '#post_upload_progress_' . $model->post->id,
                    'max' => Yii::$app->getModule('content')->maxAttachedFiles,
                    'cssButtonClass' => 'btn-sm btn-info',
                ]);
                echo FileHandlerButtonDropdown::widget([
                    'primaryButton' => $uploadButton,
                    'handlers' => $fileHandlers,
                    'cssButtonClass' => 'btn-info btn-sm',
                    'pullRight' => true,
                ]);
                echo Button::info()
                    ->icon('send')
                    ->action('editSubmit', $submitUrl)
                    ->cssClass(' btn-comment-submit')->sm()
                    ->submit();
            ?></div>
        </div>

        <?= UploadProgress::widget(['id' => 'post_upload_progress_'.$model->post->id]) ?>

        <?= FilePreview::widget([
            'id' => 'post_upload_preview_' . $model->post->id,
            'options' => ['style' => 'margin-top:10px'],
            'model' => $model->post,
            'edit' => true
        ]) ?>

    <?php ActiveForm::end(); ?>
</div>

<!-- JavaScript code to highlight stars upon button click -->
<script>
    (function() {
        function setupStars() {
            let stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                // Remove existing event listener to prevent duplicates
                star.removeEventListener('click', starClickHandler); 
                // Add the event listener
                star.addEventListener('click', starClickHandler);
            });
        }

        function starClickHandler() {
            const value = parseInt(this.getAttribute('data-value'));
            const storedRating = localStorage.getItem('starRating');

            document.getElementById('starRatingInput').value = value;

            // If the clicked star is already selected, reset the rating to 0 (silver)
            if (storedRating && parseInt(storedRating) === value) {
                localStorage.removeItem('starRating');
            } else {
                localStorage.setItem('starRating', value);
            }

            // Update the display for all stars
            applyStoredRating();
        }

        function applyStoredRating() {
            const storedRating = localStorage.getItem('starRating');
            let stars = document.querySelectorAll('.star');

            // Convert storedRating to a number, or default to 0 if null or invalid
            const rating = parseInt(storedRating) || 0;

            // Loop through all stars
            stars.forEach((star, i) => {
                // Check if the current star should be selected (up to the stored rating)
                const shouldBeSelected = i < rating;

                // Toggle the selected class based on the shouldBeSelected condition
                if (shouldBeSelected) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }

        function initializeStarRating() {
            // Remove the check for window.starRatingInitialized to ensure reinitialization as needed
            setupStars();
            applyStoredRating();
        }

        // Initial setup
        initializeStarRating();

        // This is to capture any custom event you might be using to indicate that AJAX/PJAX content has loaded.
        // Replace 'contentLoaded' with the actual event name your application uses, if applicable.
        document.addEventListener('contentLoaded', initializeStarRating);

        // Additionally, listening to 'pageshow' can help ensure ratings are applied when navigating back to the page from history
        window.addEventListener('pageshow', initializeStarRating);
    })();
</script>
