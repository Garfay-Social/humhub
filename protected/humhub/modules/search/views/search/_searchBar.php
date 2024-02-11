<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use humhub\modules\search\models\forms\SearchForm;

/* @var $model SearchForm */
?>
<head>
    <style>
        .search-container {
            max-width: 30%; /* or any other value you prefer */
            margin: 0 auto; /* This centers the container */
        }
    </style>
</head>
<div class="search-container">
    <?php $form = ActiveForm::begin(['action' => Url::to(['/search/search/index']), 'method' => 'GET']); ?>
    <div class="form-group form-group-search">
        <?= $form->field($model, 'keyword')->textInput([
            'placeholder' => Yii::t('SearchModule.base', 'Search for user, spaces, and content'),
            'title' => Yii::t('SearchModule.base', 'Search for user, spaces, and content'),
            'class' => 'form-control form-search', 'id' => 'search-input-field'
        ])->label(false) ?>
        <?= Html::submitButton(Yii::t('base', 'Search'), [
            'class' => 'btn btn-default btn-sm form-button-search',
            'data-ui-loader' => ''
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>