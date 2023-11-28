<?php

use humhub\assets\TopNavigationAsset;
use humhub\libs\Html;

/* @var $this \humhub\modules\ui\view\components\View */
/* @var $menu \humhub\widgets\TopMenu */
/* @var $entries \humhub\modules\ui\menu\MenuEntry[] */

TopNavigationAsset::register($this);

?>

<li id="top-menu-sub" class="dropdown">
    <a href="#" id="top-dropdown-menu" class="dropdown-toggle" data-toggle="dropdown" style="display:block;">
        <i class="fa fa-bars"></i><br> <!-- Changed icon to 'bars' which is commonly used for hamburger menus -->
        <?= Yii::t('base', 'Menu'); ?>
        <b class="caret"></b>
    </a>
    <ul id="top-menu-sub-dropdown" class="dropdown-menu dropdown-menu-left">
        <?php foreach ($entries as $entry) : ?>
            <li class="dropdown-item <?= $entry->getIsActive() ? 'active' : ''; ?>">
                <?= Html::a($entry->getIcon() . ' ' . $entry->getLabel(), $entry->getUrl(), $entry->getHtmlOptions()); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</li>
