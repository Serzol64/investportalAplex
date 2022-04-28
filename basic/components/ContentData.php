<?php
namespace app\components;

use Yii;
use yii\base\Component;

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
				if($q['operation'] == 'send'){}
				else if($q['operation'] == 'show'){}
				else if($q['operation'] == 'update'){}
				else if($q['operation'] == 'delete'){
					$currentA = Analytic::findOne($q['query']['id']);
					
					if(!$currentA->delete()){
							$response[1] = 500;
							$response[0] = 'Operation failed';
					}
				}
			break;
			case 'events':
				if($q['operation'] == 'send'){}
				else if($q['operation'] == 'show'){}
				else if($q['operation'] == 'update'){}
				else if($q['operation'] == 'delete'){
					$currentE = Event::findOne($q['query']['id']);
					
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
