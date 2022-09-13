<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\utility
 * @category   CategoryName
 */

namespace amos\rss\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use amos\rss\utility\FeedUtility;


class RssController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'rss',
                            'rss-feed'
                        ],
                        'roles' => ['?', '@']
                    ],
                ],
            ],
        ];
    }
    
    public function actionRss()
    {
        $out = '';
        
        try{
            $feedUtil = new FeedUtility();
            $feed = $feedUtil->createFeedWriter();
            /**
            * Add one or more entries. Note that entries must
            * be manually added once created.
            */
            $this->buildRss($feed);
            /**
            * Render the resulting feed to Atom 1.0 and assign to $out.
            * You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
            */
            $out = $feed->export('rss');
        }catch(Exception $ex){
            Yii::getLogger()->log($ex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        }catch(\Zend\Feed\Writer\Exception\RuntimeException $zex){
            Yii::getLogger()->log($zex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        }
        header('Content-type: text/xml');
        return $out;
    }
    
    
    /**
     * 
     * @param type $id
     * @param type $type
     * @return type
     */
    public function actionRssFeed($id, $type)
    {
        $out = '';
        try{
            $feedUtil = new FeedUtility();
            $feed = $feedUtil->createFeedWriter();

            $model = $this->module->modelsEnabled[$type];
            $modelObj = $model::findOne(['id' => $id]);
            if(!is_null($modelObj))
            {
                $feedUtil->addEntryInFeed($feed, $modelObj,$type);
            }
            $out = $feed->export('rss');
        }catch(Exception $ex){
            Yii::getLogger()->log($ex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        }catch(\Zend\Feed\Writer\Exception\RuntimeException $zex){
            Yii::getLogger()->log($zex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        }
        header('Content-type: text/xml');
        return $out;
        
    }
    
    /**
     * 
     * @param \Zend\Feed\Writer\Feed $feed
     */
    
    private function buildRss(\Zend\Feed\Writer\Feed $feed)
    {
    
        $feedUtil = new FeedUtility();
        
        foreach($this->module->modelsEnabled as $key => $model)
        {
            $entities = $this->loadModels($model);
            foreach($entities as $entity)
            {
                $feedUtil->addEntryInFeed($feed,$entity, $key);
            }
        }
    }
    
    /**
     * 
     * @param string $model
     * @return arry
     */
    private function loadModels($model)
    {
        $entities = null;
        $cwh = Yii::$app->getModule('cwh');
        
        try{
            $modelObj = \Yii::createObject( $model );
            if(!is_null($cwh))
            {
                $modelObj = \Yii::createObject( $model );
                $configContent = \open20\amos\cwh\models\CwhConfigContents::findOne(['tablename' => $modelObj->tableName()]);
                $entities = $modelObj->find()
                        ->innerJoin('cwh_pubblicazioni','cwh_config_contents_id = ' . $configContent->id .' and cwh_pubblicazioni.content_id = ' . $modelObj->tableName() 
                                . '.id and cwh_regole_pubblicazione_id = 1')
                        ->andWhere(['status' => $modelObj->getValidatedStatus()])
                        ->limit($this->module->limitRss)->orderBy( [
                            'created_at' => SORT_DESC
                        ])->all();
            }
            else
            {
                 $entities = $modelObj->find()
                         ->andWhere(['status' => $modelObj->getValidatedStatus()])
                        ->limit($this->module->limitRss)->orderBy( [
                            'created_at' => SORT_DESC
                        ])->all();
            }
        }catch(Exception $ex){
            Yii::getLogger()->log($ex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        }
        return $entities;
    }
}
