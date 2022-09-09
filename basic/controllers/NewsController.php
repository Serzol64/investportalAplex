<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\View;

use app\models\News;
use app\models\Analytic;
use app\models\Event;

class NewsController extends Controller{
	public function actionIndex(){
		$this->view->registerCssFile("/css/news.css");
		$this->view->registerJsFile("/js/news.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/inpage_codes/news/1.css");
		
		$nl = News::find();
		
		$feed = [
			'firstLastNews' => $nl->select('id, title, titleImage, content, created')->orderBy('created DESC')->limit(1)->one(),
			'rightLastNews' => $nl->select('id, title, titleImage, content, created')->orderBy('created DESC')->limit(4)->offset(1)->all(),
			'cat' => $nl->select('category')->orderBy('category ASC')->limit(3)->distinct()->all(),
			'footerNews' => [
				$nl->select('id, title, titleImage, content, created')->orderBy('created DESC')->limit(4)->offset(5)->all(),
				$nl->select('id, title, titleImage, content, created')->orderBy('created DESC')->limit(4)->offset(9)->all()
			]
		];
		
		
		return $this->render('news', ['feed' => $feed]);
	}
	public function actionView($contentId){
		$this->view->registerCssFile("/css/news.css");
		$this->view->registerJsFile("/js/news.js", ['position' => View::POS_END]);
		$this->view->registerJsFile("/js/news/view.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/news/view.css");
		$this->view->registerCssFile("/css/inpage_codes/news/2.css");
		
		$curNews = News::findOne(['id' => $contentId]);
		$curRealted = Yii::$app->realtedDB->topList('news', $contentId);
		
		if(!$curNews){
			Yii::$app->response->statusCode = 404;
			return $this->redirect(['site/index']);
		}
		
		return $this->render('newsView', ['curNews' => $curNews, 'realted' => $curRealted]);
	}
	public function actionEventsFeed(){
		$this->view->registerCssFile("/css/news.css");
		$this->view->registerJsFile("/js/events.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/events.css");
		
		$list = Event::find()->orderBy('date_from DESC')->all();
		
		$eventParameters = Event::find()->select('location, tematic, type')->distinct()->all();
		return $this->render('eventsFeed', ['eventsList' => $list, 'ep' => $eventParameters]);
	}
	public function actionEvent($contentId){
		$this->view->registerCssFile("/css/news/view.css");
		$this->view->registerJsFile("/js/events/view.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/events/view.css");
		
		$this->view->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css");
		$this->view->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js", ['position' => View::POS_BEGIN]);
		
		$curEvent = Event::findOne(['id' => $contentId]);
		$curRealted = Yii::$app->realtedDB->topList('events', $contentId);
		
		if(!$curEvent){
			Yii::$app->response->statusCode = 404;
			return $this->redirect(['site/index']);
		}
		
		return $this->render('eventsView', ['curEvent' => $curEvent, 'realted' => $curRealted]);
	}
	public function actionAnalyticsFeed(){
		$this->view->registerCssFile("/css/news.css");
		$this->view->registerJsFile("/js/analytics.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/analytics.css");
		
		$af = Analytic::find();
		
		$parts = [
			'categories' => $af->select('category')->orderBy('category DESC')->limit(5)->distinct()->all(),
			'last' => $af->select('id, titleImage, title, created')->orderBy('created DESC')->limit(3)->all(),
			'preLast' => $af->select('id, titleImage, title, created')->orderBy('created DESC')->limit(6)->offset(3)->all(),
			'old' => $af->select('id, titleImage, title, created')->orderBy('created DESC')->limit(9)->offset(6)->all()
		];
		
		$curRealted = Yii::$app->realtedDB->topList('analytics', $contentId);
		return $this->render('analytics', ['afp' => $parts, 'realted' => $curRealted]);
	}
	public function actionAnalyticsView($contentId){
		$this->view->registerCssFile("/css/news/view.css");
		$this->view->registerJsFile("/js/analytics/view.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/analytics/view.css");
		
		$curA = Analytic::findOne(['id' => $contentId]);
		
		if(!$curA){
			Yii::$app->response->statusCode = 404;
			return $this->redirect(['site/index']);
		}
		
		return $this->render('analytic', ['curA' => $curA]);
	}
	public function actionNewsservice($type){
		$serviceResponse = array();
		$nsd = News::find();
		
		if($type == 'get'){
			if(isset($_GET['svcQuery'])){
				
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else if($type == 'post'){
			if(isset($_POST['svcQuery'])){
				
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else{
			Yii::$app->response->statusCode = 404;
			$serviceResponse = "Not command found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
	}
	public function actionEventsservice($type){
		$serviceResponse = array();
		$esd = Event::find();
		
		if($type == 'get'){
			if(isset($_GET['svcQuery'])){
				$cq = Json::decode($_GET['svcQuery'], true);
				$cqContent = $cq['query'];
				
				if($cq['service'] == 'eventsFind'){
					$searchData = $cqContent['search'];
					$paramFind = [];
					$resultFind = [];
					$statusFind = 200;
					
					if(isset($searchData['region'])){
						if($searchData['region']){ $paramFind[] = ['location' => $searchData['region']]; }
					}
					
					if(isset($searchData['type'])){
						if($searchData['type']){ $paramFind[] = ['type' => $searchData['type']]; }
					}
					
					if(isset($searchData['tematic'])){
						if($searchData['tematic']){ $paramFind[] = ['tematic' => $searchData['tematic']]; }
					}
					
					if(isset($searchData['period'])){
						$dateQuery = $searchData['period'];
						
						if(isset($dateQuery['from'])){ 
							if($dateQuery['from']){ $paramFind[] = ['date_from' => $dateQuery['from']]; }
						}
						
						if(isset($dateQuery['to'])){ 
							if($dateQuery['to']){ $paramFind[] = ['date_to' => $dateQuery['to']]; }
						}
						
					}
					
					$queryFind = sizeOf($paramFind) > 0 ? Event::find()->where($paramFind)->all() : Event::find()->all();
					
					if($queryFind){ $resultFind = $queryFind; }
					else{
						$statusFind = 404;
						$resultFind = 'No events were found for the query!';
					}
					
					Yii::$app->response->statusCode = $statusFind;
					$serviceResponse = $resultFind;
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Service not found!";
				}
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else if($type == 'post'){
			if(isset($_POST['svcQuery'])){
				$cq = Json::decode($_POST['svcQuery'], true);
				$cqContent = $cq['query'];
				
				if($cq['service'] == 'currentEventOrganizator'){
					$currentContent = $esd->select('content')->where(['id' => $cqContent['eventId']])->one();
					$dataResponse = 200;
					$readyLink = 'about:blank';
					
					$isOrganizator = strrpos($currentContent->content, '<p>Organizator web site:');
					
					if($isOrganizator){
						$readyQuery = explode('<p>Organizator web site:', $currentContent->content);
						$readyQuery .= explode('</p>', $readyQuery[0]);
						
						if(!strrpos($readyQuery[0], '&nbsp;')){ $readyLink = $readyQuery[0]; }
						else{
							$readyQuery .= explode('&nbsp;', $readyQuery[0]);
							$readyLink = $readyQuery[0];
						}
					}
					else{ $dataResponse = 404; }
					
					Yii::$app->response->statusCode = $dataResponse;
					$serviceResponse = ['url' => $readyLink];
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Service not found!";
				}
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else{
			Yii::$app->response->statusCode = 404;
			$serviceResponse = "Not command found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
	}
	public function actionAnalyticsservice($type){
		$serviceResponse = array();
		$asd = Analytic::find();
		
		if($type == 'get'){
			if(isset($_GET['svcQuery'])){
				$cq = Json::decode($_GET['svcQuery'], true);
				$cqContent = $cq['query'];
				
				if($cq['service'] == 'categoryLastNews'){
					$acng = [
						'last' => $asd->where(['category' => $cqContent['name']])->orderBy('created DESC')->limit(3)->all(),
						'preLast' => $asd->where(['category' => $cqContent['name']])->orderBy('created DESC')->limit(6)->offset(3)->all(),
						'old' => $asd->where(['category' => $cqContent['name']])->orderBy('created DESC')->limit(9)->offset(6)->all()
					];
						
					$serviceResponse = [ 'l' => $acng['last'], 'pl' => $acng['preLast'], 'o' => $acng['old'] ];
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Service not found!";
				}
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else{
			Yii::$app->response->statusCode = 404;
			$serviceResponse = "Not command found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
	}
}
?>
