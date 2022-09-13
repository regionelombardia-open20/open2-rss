<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\news\migrations
 * @category   CategoryName
 */

use open20\amos\core\migration\AmosMigrationPermissions;
use yii\helpers\ArrayHelper;
use yii\rbac\Permission;

/**
 * Class m160912_144417_add_news_permissions_roles
 */
class m180308_160342_add_rss_permissions_roles extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return $this->setWidgetsPermissions();
    }
    
    /**
     * Plugin widgets permissions
     *
     * @return array
     */
    private function setWidgetsPermissions()
    {
        return [

            [
                'name' => \amos\rss\widgets\graphics\WidgetGraphicsRssUltimeNews::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso per il widget WidgetGraphicsRssUltimeNews',
                'parent' => ['LETTORE_NEWS','ADMIN']
            ],
        ];
    }
}
