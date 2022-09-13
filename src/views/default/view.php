<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\news
 * @category   CategoryName
 */


use amos\rss\Module;
use open20\amos\core\forms\CloseButtonWidget;
use yii\helpers\Url;

$this->title = Module::t('amosrss', '#view_feed');

$this->params['breadcrumbs'][] = $this->title;

$element = $feed->current();
?>

<div class="post-details col-xs-12">
    <div class="post col-xs-12 nop nom">
        <div class="post-content col-xs-12 nop">

            <div class="post-title col-xs-10">
                <h2><?= $feed->getTitle() ?></h2>
            </div>
            <div class="clearfix"></div>
            
            <div class="post-text">
                <h3 class="nom"><?= $element->getTitle() ?></h3>
                <?= $element->getContent() ?>
            </div>
        </div>
    </div>
    <?= CloseButtonWidget::widget(['urlClose' => Url::previous()]) ?>
</div>
