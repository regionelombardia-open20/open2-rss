<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    amos-rss
 * @category   CategoryName
 */

namespace amos\rss\assets;

use yii\web\AssetBundle;

/**
 * Class ModuleRssAsset
 * @package amos\rss\assets
 */
class ModuleRssAsset extends AssetBundle
{
    public $sourcePath = '@vendor/open20/amos-rss/src/assets/web';

    public $css = [
        'less/rss.less'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        $moduleL = \Yii::$app->getModule('layout');
        if (!empty($moduleL)) {
            $this->depends [] = 'open20\amos\layout\assets\BaseAsset';
        } else {
            $this->depends [] = 'open20\amos\core\views\assets\AmosCoreAsset';
        }
        parent::init();
    }

}