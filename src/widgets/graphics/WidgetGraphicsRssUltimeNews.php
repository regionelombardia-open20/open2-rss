<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\news\widgets\graphics
 * @category   CategoryName
 */

namespace amos\rss\widgets\graphics;

use open20\amos\core\widget\WidgetGraphic;
use amos\rss\Module;
use Yii;
use amos\rss\utility\FeedUtility;


class WidgetGraphicsRssUltimeNews extends WidgetGraphic
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setCode('ULTIME_NEWS_GRAPHIC');
        $this->setLabel(Module::tHtml('amosrss', '#ultime_news'));
        $this->setDescription(Module::t('amosrss', '#elenca_le_ultime_rss'));
         
    }

    /**
     * 
     * @return type
     */
    public function getHtml()
    {   
        $feeds = [];
        try{
            $feedUtil = new FeedUtility();
            $module = Module::instance();
            foreach ($module->federationUrls as $url)
            {
                $feeds[] = Yii::$app->rss->reader()->import($url . $feedUtil->getListUrl());
            }
        }catch(Exception $ex){
            Yii::getLogger()->log($ex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        } catch (\Zend\Feed\Reader\Exception\RuntimeException $zex){
            Yii::getLogger()->log($zex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        }
        $viewToRender = 'ultime_rss';
        $moduleLayout = \Yii::$app->getModule('layout');

        if(is_null($moduleLayout)){
            $viewToRender = 'ultime_rss_old';
        }
        return $this->render( $viewToRender, [
            'feeds' => $feeds,
            'widget' => $this,
            'toRefreshSectionId' => $this->className()
        ]);
    }
}