<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\utility
 * @category   CategoryName
 */

namespace amos\rss\utility;


use open20\amos\core\utilities\StringUtils;
use amos\rss\Module;
use Yii;

class FeedUtility extends \yii\base\Object
{
   
    private $module = null;
    
    
    public function getListUrl()
    {
        return '/rss/rss/rss';
    }
    
    
    public function getReadUrl()
    {
        return '/rss/rss/rss-feed';
    }
    
    /**
     * 
     * @param type $config
     */
    public function __construct($config = array()) {
        $this->module = Module::instance();
        parent::__construct($config);
    }

    /**
     * 
     * @return Zend\Feed\Writer
     */
    public function createFeedWriter()
    {
        $feed = Yii::$app->rss->writer();

        $feed->setTitle($this->module->title);
        $feed->setLink(Yii::$app->params['platform']['backendUrl']);
        $feed->setFeedLink($this->module->url, 'rss');
        $feed->setDescription($this->module->description);
        $feed->setGenerator($this->module->url);
        $feed->setDateModified(time()); 
        
        return $feed;
    }
    
    
    /**
     * 
     * @param Zend\Feed\Writer $feed
     * @param ActiveRecord $entity
     * @param integer $key
     */
    public function addEntryInFeed($feed, $entity, $key)
    {
        $entry = $feed->createEntry();
        $entry->setTitle($entity->getTitle());
        $entry->setLink(Yii::$app->urlManager->createAbsoluteUrl([$this->getReadUrl(),'id' => $entity->id, 'type' => $key]));
        $entry->setDateModified(new \DateTime($entity->updated_at));
        $entry->setDateCreated(new \DateTime($entity->created_at));
        $description = $entity->getDescription(null);
        $entry->setContent(
           (StringUtils::isEmpty($description) ? '--': $description)
        );
        /*$entry->setEnclosure(
            [
             'uri'=>$post->image,
             'type'=>'image/jpeg',
             'length'=>filesize(Yii::getAlias('@webroot').$post->image)
             ]
        );*/
        $feed->addEntry($entry);
    }
}
