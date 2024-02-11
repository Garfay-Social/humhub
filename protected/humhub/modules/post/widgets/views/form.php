<?php

use humhub\modules\content\widgets\richtext\RichTextField;
use humhub\modules\content\widgets\WallCreateContentFormFooter;
use humhub\modules\post\models\Post;
use humhub\modules\ui\form\widgets\ActiveForm;

/* @var string $mentioningUrl */
/* @var ActiveForm $form */
/* @var Post $post */
/* @var string $submitUrl */
?>

<div class="star-rating" data-rating="0">
    <span class="star" data-value="1">&#9733;</span>
    <span class="star" data-value="2">&#9733;</span>
    <span class="star" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
</div>

<style>
    .star {
        cursor: pointer; 
        color: #ccc;
    }

    .star.selected { 
        color: gold;
    }

</style>

<?= $form->field($post, 'message')->widget(RichTextField::class, [
    'id' => 'contentForm_message',
    'form' => $form,
    'layout' => RichTextField::LAYOUT_INLINE,
    'pluginOptions' => ['maxHeight' => '300px'],
    'placeholder' => Yii::t("PostModule.base", "What's on your mind?"),
    'name' => 'message',
    'disabled' => (property_exists(Yii::$app->controller, 'contentContainer') && Yii::$app->controller->contentContainer->isArchived()),
    'disabledText' => Yii::t("PostModule.base", "This space is archived."),
    'mentioningUrl' => $mentioningUrl,
])->label(false) ?>

<?= WallCreateContentFormFooter::widget([
    'contentContainer' => $post->content->container,
    'submitUrl' => $submitUrl,
]) ?>

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
            localStorage.setItem('starRating', value);
            applyStoredRating(); // Update the display immediately after storing the new rating
        }

        function applyStoredRating() {
            const storedRating = localStorage.getItem('starRating');
            let stars = document.querySelectorAll('.star');
            if (storedRating) {
                stars.forEach((star, i) => {
                    if (i < storedRating) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            }
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