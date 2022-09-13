<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\news\widgets\graphics\views
 * @category   CategoryName
 */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;
use amos\rss\Module;
use amos\rss\assets\ModuleRssAsset;

ModuleRssAsset::register($this);

/**
 * @var View $this
 * @var string $toRefreshSectionId
 */


?>
<div class="grid-item grid-item--width2 grid-item--height2 latest-rss">
<div class="box-widget">
    <div class="box-widget-toolbar">
        <h1 class="box-widget-title col-xs-10 nop"><?= Module::t('amosrss', '#ultime_news') ?></h1>
        
    </div>
    <section class="clearfixplus" >
        <h2 class="sr-only"><?= Module::t('amosrss', '#ultime_news') ?></h2>
        <?php Pjax::begin(['id' => $toRefreshSectionId]); ?>
           
        <div class="list-items" >
            <?php
            foreach ($feeds as $feed):
                foreach ($feed as $element):
                ?>
                <div class="col-xs-12 col-sm-4 col-md-4 widget-listbox-option" role="option">
                    <article class="col-xs-12 nop">
                        <div class="container-text clearfixplus">
                            <div class="col-xs-12 listbox-date">
                                
                                <p><?= Yii::$app->getFormatter()->asDate($element->getDateCreated()); ?></p>
                                <h2 class="box-widget-subtitle">
                                    <?php
                                    if (strlen($feed->getTitle()) > 55) {
                                        $stringCut = substr($feed->getTitle(), 0, 55);
                                        echo substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
                                    } else {
                                        echo $feed->getTitle();
                                    }
                                    ?>
                                </h2>
                                <h4 class="box-widget-title">
                                    <?php
                                    if (strlen($element->getTitle()) > 55) {
                                        $stringCut = substr($element->getTitle(), 0, 55);
                                        echo substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
                                    } else {
                                        echo $element->getTitle();
                                    }
                                    ?>
                                </h4>
                                <p class="box-widget-text">
                                        <?php
                                        if (strlen($element->getContent()) > 200) {
                                            $stringCut = substr(strip_tags($element->getContent()), 0, 200);
                                            echo substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
                                        } else {
                                            echo strip_tags($element->getContent());
                                        }
                                        ?>
                                </p>
                            </div>
                        </div>
                        <div class="footer-listbox col-xs-12 m-t-5 nop">
                            <?= Html::a(Module::t('amosrss', 'LEGGI TUTTO'), ['/rss/default/view','url' => $element->getLink()], ['class' => 'btn btn-navigation-primary']); ?>
                        </div>
                    </article>
                </div>
                <?php
                endforeach;
            endforeach;
            ?>
        </div>

        <?php Pjax::end(); ?>
    </section>
    
</div>
</div>