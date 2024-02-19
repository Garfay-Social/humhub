<?php
/* @var $this \yii\web\View */
/* @var $content string */

\humhub\assets\AppAsset::register($this);
humhub\modules\stream\assets\StreamAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= strip_tags($this->pageTitle); ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php $this->head() ?>
        <?= $this->render('head'); ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <!-- start: first top navigation bar -->
        <div id="topbar-first" class="topbar">
            <div class="container">
                <div class="topbar-brand hidden-xs">
                    <?= \humhub\widgets\SiteLogo::widget(); ?>
                </div>

                <div class="topbar-actions">
                    <?= \humhub\modules\user\widgets\AccountTopMenu::widget(); ?>
                </div>

                <div class="notifications pull-right">
                    <?= \humhub\widgets\NotificationArea::widget(); ?>
                </div>
            </div>
        </div>
        <!-- end: first top navigation bar -->

        <!-- start: second top navigation bar -->
        <div id="topbar-second" class="topbar">
            <div class="container">
                <ul class="nav" id="top-menu-nav">
                    <!-- load navigation from widget -->
                    <?= \humhub\widgets\TopMenu::widget(); ?>

                    <!-- load space chooser widget -->
                    <?= \humhub\modules\space\widgets\Chooser::widget(); ?>
                </ul>

            <!-- Include the search bar here -->
            <?= $this->render('@humhub/modules/search/views/search/_searchBar', ['model' => new \humhub\modules\search\models\forms\SearchForm()]); ?>
                
            </div>
        </div>
        <!-- end: second top navigation bar -->

        <?= $content; ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
