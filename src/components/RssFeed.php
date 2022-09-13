<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\utility
 * @category   CategoryName
 */

namespace amos\rss\components;

use yii\base\Component;
use Zend\Feed\Writer\Feed;
use Zend\Feed\Reader\Reader;

class RssFeed extends Component
{
   /**
    * Loads read Zend-feed component
    * @return mixed object Zend\Feed\Reader component
    */
   public function reader(){

       return new Reader;
   }
   /**
    * Loads read Zend-feed component
    * @return mixed object Zend\Feed\Writer component
    */
   public function writer(){

       return new Feed;
   }
}
