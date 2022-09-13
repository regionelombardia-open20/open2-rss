<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\news\migrations
 * @category   CategoryName
 */

use open20\amos\core\migration\AmosMigrationWidgets;


class m180312_092427_add_widget_dashboard_visible extends AmosMigrationWidgets
{
    const MODULE_NAME = 'rss';

    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \amos\rss\widgets\graphics\WidgetGraphicsRssUltimeNews::className(),
                'dashboard_visible' => 1,
                'update' => true
            ]
        ];
    }
}

