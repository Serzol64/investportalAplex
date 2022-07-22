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
			'firstLastNews' => $nl->orderBy('created DESC')->limit(1)->one(),
			'rightLastNews' => $nl->orderBy('created DESC')->limit(4)->offset(1)->all(),
			'cat' => $nl->select('category')->distinct()->all(),
			'footerNews' => [
				$nl->orderBy('created DESC')->limit(4)->offset(5)->all(),
				$nl->orderBy('created DESC')->limit(4)->offset(9)->all()
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
		
		$list = [
			Event::find()->where(['<=', 'date_from', date('Y-m-d')])->orderBy('date_from DESC')->all(),
			Event::find()->where(['<=', 'date_to', date('Y-m-d')])->orderBy('date_from ASC')->all()
		];
		
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
			'categories' => $af->select('category')->distinct()->orderBy('created DESC')->limit(5),
			'last' => $af->orderBy('created DESC')->limit(3)->all(),
			'preLast' => $af->orderBy('created DESC')->limit(6)->offset(3)->all(),
			'old' => $af->orderBy('created DESC')->limit(9)->offset(6)->all()
		];
		
		return $this->render('analytics', ['afp' => $parts]);
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
	public function actionAnalyticsservice($type){
		$serviceResponse = array();
		$asd = Analytic::find();
		
		if($type == 'get'){
			if(isset($_GET['svcQuery'])){
				$cq = Json::decode($_GET['svcQuery'], true);
				$cqContent = $cq['query'];
				
				switch($cq['service']){
					case 'categoryLastNews':
						$acng = [
							'last' => $asd->where(['category' => $cqContent['name'])->orderBy('created DESC')->limit(3)->all(),
							'preLast' => $asd->where(['category' => $cqContent['name'])->orderBy('created DESC')->limit(6)->offset(3)->all(),
							'old' => $asd->where(['category' => $cqContent['name'])->orderBy('created DESC')->limit(9)->offset(6)->all()
						];
						
						$serviceResponse = [ 'l' => $acng['last'], 'pl' => $acng['preLast'], 'o' => $acng['old'] ];
					break;
					default:
						Yii::$app->response->statusCode = 404;
					    $serviceResponse = "Service not found!";
					break;
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
}
?>
