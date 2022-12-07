<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

use app\models\News;
use app\models\Event;
use app\models\Analytic;

class ContentData extends Component{
	public function init(){
		parent::init();
	}
	public function send($svc, $q){
		$response = ['Operation success', 200];
		
		switch($svc){
			case 'news':
				$ncm = new News;
				$ncc = News::find();
				
				if($q['operation'] == 'send'){
					if($q['query']['image']){
						$lastId = $ncc->orderBy('id desc')->limit(1)->all();
						
						if($lastId){
							foreach($lastId as $code){ $newId = $code->id + 1; }
						}
						else{ $newId = 1; }
						
						$ncm->id = $newId;
						$ncm->title = $q['query']['title'];
						$ncm->created = date('Y-m-d h:i:s');
						$ncm->titleImage = $q['query']['image'];
						$ncm->content = $q['query']['content'];
						$ncm->category = Yii::$app->cloudCategorizator('news', [$q['query']['title'], $q['query']['content']]);
						
						if(!$ncm->save()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'show'){
					$getNews = $ncc->where(['id' => $q['query']['id']])->all();
					
					if($getNews){ $response[0] = $getNews; }
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'update'){
					$currentNews = News::findOne(['id' => $q['query']['id']]);
					
					if($q['query']['image']){
						$currentNews->title = $q['query']['title'];
						$currentNews->created = date('Y-m-d h:i:s');
						$currentNews->titleImage = $q['query']['image'];
						$currentNews->content = $q['query']['content'];
						$currentNews->category = Yii::$app->cloudCategorizator('news', [$q['query']['title'], $q['query']['content']]);
						
						if(!$currentNews->save()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'delete'){
					$currentN = News::findOne(['id' => $q['query']['id']]);
					
					if(!$currentN->delete()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
					}
				}
			break;
			case 'analytics':
				$acm = new Analytic;
				$acc = Analytic::find();
				
				if($q['operation'] == 'send'){
					if($q['query']['image']){
						$lastId = $acc->orderBy('id desc')->limit(1)->all();
						
						if($lastId){
							foreach($lastId as $code){ $newId = $code->id + 1; }
						}
						else{ $newId = 1; }
						
						$acm->id = $newId;
						$acm->title = $q['query']['title'];
						$acm->created = date('Y-m-d h:i:s');
						$acm->titleImage = $q['query']['image'];
						$acm->content = $q['query']['content'];
						$acm->category = Yii::$app->cloudCategorizator('news', [$q['query']['title'], $q['query']['content']]);
						
						if(!$acm->save()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'show'){
					$getNews = $acc->where(['id' => $q['query']['id']])->all();
					
					if($getNews){ $response[0] = $getNews; }
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'update'){
					$currentNews = Analytic::findOne(['id' => $q['query']['id']]);
					
					if($q['query']['image']){
						$currentNews->title = $q['query']['title'];
						$currentNews->created = date('Y-m-d h:i:s');
						$currentNews->titleImage = $q['query']['image'];
						$currentNews->content = $q['query']['content'];
						$currentNews->category = Yii::$app->cloudCategorizator('news', [$q['query']['title'], $q['query']['content']]);
						
						if(!$currentNews->save()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'delete'){
					$currentA = Analytic::findOne(['id' => $q['query']['id']]);
					
					if(!$currentA->delete()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
					}
				}
			break;
			case 'events':
				$ecm = new Event;
				$ecc = Event::find();
				
				if($q['operation'] == 'send'){
					if($q['query']['image']){
						$lastId = $ecc->orderBy('id desc')->limit(1)->all();
						
						if($lastId){
							foreach($lastId as $code){ $newId = $code->id + 1; }
						}
						else{ $newId = 1; }
						
						$ecm->id = $newId;
						$ecm->title = $q['query']['title'];
						$ecm->titleImage = $q['query']['image'];
						$ecm->date_from = $q['query']['period']['from'];
						$ecm->date_to = $q['query']['period']['to'];
						$ecm->location = $q['query']['location'];
						$ecm->content = $q['query']['content'];
						$ecm->tematic = $q['query']['tematic'];
						
						if(!$ecm->save()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'show'){
					$getNews = $ecc->where(['id' => $q['query']['id']])->all();
					
					if($getNews){ $response[0] = $getNews; }
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'update'){
					$currentNews = Event::findOne(['id' => $q['query']['id']]);
					
					if($q['query']['image']){
						$currentNews->title = $q['query']['title'];
						$currentNews->titleImage = $q['query']['image'];
						$currentNews->date_from = $q['query']['period']['from'];
						$currentNews->date_to = $q['query']['period']['to'];
						$currentNews->location = $q['query']['location'];
						$currentNews->content = $q['query']['content'];
						$currentNews->tematic = $q['query']['tematic'];
						
						if(!$currentNews->save()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
					else{
						$response[1] = 400;
						$response[0] = 'Not required title photo!';
					}
				}
				else if($q['operation'] == 'delete'){
					$currentE = Event::findOne(['id' => $q['query']['id']]);
					
					if(!$currentE->delete()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
					}
				}
			break;
		}
		
		return $response;
	}
}
?>
