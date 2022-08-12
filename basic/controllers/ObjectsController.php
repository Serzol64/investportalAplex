<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\View;
use yii\helpers\Json;

use app\models\ObjectAttribute;
use app\models\ObjectsData;
use app\models\Expert;
use app\models\Investors;
use app\models\InvestorsCategory;


class ObjectsController extends Controller{
	public function actionIndex(){
		$this->view->registerCssFile("/css/objects.css");
		$this->view->registerCssFile("/css/inpage_codes/objects/1.css");
		$this->view->registerJsFile("/js/objects.js", ['position' => View::POS_END]);

		$oads = [
			ObjectAttribute::find()->limit(12)->all(),
			ObjectAttribute::find()->limit(24)->offset(12)->all()
		];
		
		$ds = [
			'all' => ObjectsData::find()->select('id')->orderBy('id DESC')->all()
		];
		
		
		return $this->render('objects', ['attrs' => $oads, 'dataset' => $ds]);
	}
	public function actionObject(){
		$this->view->registerCssFile("/css/objects.css");
		$this->view->registerCssFile("/css/objects/hotels.css");
		$this->view->registerCssFile("/css/inpage_codes/objects/2.css");
		$this->view->registerJsFile("/js/objects.js", ['position' => View::POS_END]);
		$this->view->registerJsFile("/js/objects/hotels.js", ['position' => View::POS_END]);
		
		return $this->render('object');
	}
	public function actionView($objectId){
		$this->view->registerCssFile("/css/objects.css");
		$this->view->registerCssFile("/css/objects/view.css");
		$this->view->registerCssFile("/css/inpage_codes/objects/3.css");
		$this->view->registerJsFile("/js/objects.js", ['position' => View::POS_END]);
		$this->view->registerJsFile("/js/objects/view.js", ['position' => View::POS_END]);
		
		return $this->render('objectsView');
	}
	
	public function actionInvestors(){
		$this->view->registerCssFile("/css/investors.css");
		$this->view->registerJsFile("/js/investors.js", ['position' => View::POS_END]);
		
		$adverstments = Investors::find()->all();
		
		return $this->render('investors', ['ads' => $adverstments]);
	}
	public function actionExperts(){
		$this->view->registerCssFile("/css/experts.css");
		$this->view->registerJsFile("/js/experts.js", ['position' => View::POS_END]);
		
		$basicResponse = [
			'list' => Expert::find()->orderBy('created DESC')->all(),
			'expertsCount' => Expert::find()->count()
		];
		
		return $this->render('experts', ['response' => $basicResponse]);
	}
	public function actionExpertsView($expertId){
		$this->view->registerCssFile("/css/experts/view.css");
		$this->view->registerJsFile("/js/experts/view.js", ['position' => View::POS_END]);
		
		$queryPage = Expert::findOne(['id' => $expertId]);
		
		if(!$queryPage){
			Yii::$app->response->statusCode = 404;
			return $this->redirect(['objects/experts']);
		}
		
		$contentStructure = [
			'person' => Json::decode($queryPage->person, true),
			'info' => [
				Json::decode($queryPage->content, true),
				Json::decode($queryPage->inform, true),
				Json::decode($queryPage->contact, true)
			]
		];
		
		return $this->render('expert', ['structureResponse' => $contentStructure]);
	}
	
	public function actionObjectservice($type){
		
	}
	public function actionExpertsservice($type){
		
	}
	public function actionInvestorssservice($type){
		
	}
}
?>
