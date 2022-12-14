amos-rss
=========

Amos Framework extension to provide functionality for consuming RSS and Atom feeds using zend-feed library.

Installation
------------
```code
{
	"require": 
	{
  		"open20/amos-rss": "~1.0.0"
	}
}
```
Configuration
-------------
In config file
```code
/config/web.php
```
Add feed component
```code
'components' => array(
        ...
        'rss' => array(
        	 	'class' => 'amos\rss\components\RssFeed',
        		),
		    )
```
Simple usage
-----

__Read Rss feed:__
```php
$feed=Yii::$app->feed->reader()->import('http://exapmple.com/feed.rss');
```
This will get RSS feed, parse it and return feed object.
For more details you can read the official Zend-feed extention documentaion:
http://framework.zend.com/manual/2.2/en/modules/zend.feed.reader.html

__Create Rss feed:__

Create action Rss in controller
```php
public function actionRss(){
		
     $feed=Yii::$app->feed->writer();
		
    $feed->setTitle(Yii::$app->params['title']);
		$feed->setLink('http://example.com');
		$feed->setFeedLink('http://example.com/rss', 'rss');
		$feed->setDescription(Yii::t('app','Recent headlines'));
		$feed->setGenerator('http://example.com/rss');
		$feed->setDateModified(time()); 
		/**
		* Add one or more entries. Note that entries must
		* be manually added once created.
		*/
		$posts=Post::find()->orderBy('id DESC')->limit(20)->all();
		foreach($posts as $post){
				$entry = $feed->createEntry();
				$entry->setTitle($post->title);
				$entry->setLink(Yii::$app->urlManager->createAbsoluteUrl('/post/view',['id'=>$post->id]));
				$entry->setDateModified(intval($post->created));
				$entry->setDateCreated(intval($post->created));
				$entry->setContent(
				   $post->content
				);
				$entry->setEnclosure(
					[
					 'uri'=>$post->image,
					 'type'=>'image/jpeg',
					 'length'=>filesize(Yii::getAlias('@webroot').$post->image)
					 ]
				);
				$feed->addEntry($entry);
		}
		/**
		* Render the resulting feed to Atom 1.0 and assign to $out.
		* You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
		*/
		$out = $feed->export('rss');
		header('Content-type: text/xml');
		echo $out;
		die();
	}
```
add rss migrations to console modules (console/config/migrations-amos.php):
```
'@vendor/open20/amos-rss/src/migrations'
```
```
add rss module to backend modules (backend/config/modules-amos.php):
```
'rss' => [
       'class' => 'amos\rss\Module',
        'modelsEnabled' => [
            'open20\amos\news\models\News',
        ],
        'federationUrls' => [
            'http://domain.from.readrss.com'
        ]
   ],
   
```