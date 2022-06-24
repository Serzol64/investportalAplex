<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\View;

use app\models\ObjectAttribute;
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
		
		
		return $this->render('objects', ['attrs' => $oads]);
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
		
		return $this->render('experts');
	}
	public function actionExpertsView($objectId){
		$this->view->registerCssFile("/css/experts/view.css");
		$this->view->registerJsFile("/js/experts/view.js", ['position' => View::POS_END]);
		
		return $this->render('expert');
	}
	
	public function actionObjectservice($type){
		
	}
	public function actionExpertsservice($type){
		
	}
	public function actionInvestorssservice($type){
		
	}
}
?>
