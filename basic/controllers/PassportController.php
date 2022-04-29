<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\View;
use yii\helpers\Json;
use linslin\yii2\curl\Curl;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;

use app\models\User;
use app\models\Investments;
use app\models\Offers;
use app\models\Cart;

class PassportController extends Controller{
	public function actionService(){
		$this->view->registerCssFile("/css/passport.css");
		$this->view->registerCssFile("/css/inpage_codes/passport/1.css");
		$this->view->registerJsFile("/js/passport.js", ['position' => View::POS_END]);
		
		if(isset($_COOKIE['portalId'])){ 
			$query = $_COOKIE['portalId']; 
			
			$requestsData = Investments::find()->where(['login' => $query])->all();
			return $this->render('passportPage', ['requestData' => $requestsData]);
		}
		else{ 
			Yii::$app->response->statusCode = 401;
			return $this->redirect(['site/index']); 
		}
	}
	public function actionAccountedit(){
		$this->view->registerCssFile("/css/passport.css");
		$this->view->registerCssFile("/css/inpage_codes/passport/2.css");
		$this->view->registerJsFile("/js/passport.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/passport/profile.css");
		$this->view->registerJsFile("/js/passport/profile.js", ['position' => View::POS_END]);
		
		$this->view->registerJsFile("/js/passport/alertify/lib/alertify.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerCssFile("/js/passport/alertify/themes/alertify.core.css");
		$this->view->registerCssFile("/js/passport/alertify/themes/alertify.default.css");
		
		if(isset($_COOKIE['portalId'])){ 
			$query = $_COOKIE['portalId']; 
			
			$wsInit = new Curl();
			$q = $wsInit->setOption(CURLOPT_POSTFIELDS, http_build_query(array('login' => $query)))->setHeaders(array('Content-Type' => 'application/x-www-form-urlencoded'))->post((!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] ."/services/1/post");
			
			$ud_data = JSON::decode($q, true);
			return $this->render('passportProfile', ['ud_data' => $ud_data[0]]);
		}
		else{ 
			Yii::$app->response->statusCode = 401;
			return $this->redirect(['site/index']); 
		}
	}
	public function actionEventsedit(){
		$this->view->registerCssFile("/css/passport.css");
		$this->view->registerCssFile("/css/inpage_codes/passport/3.css");
		$this->view->registerJsFile("/js/passport.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/passport/services.css");
		$this->view->registerJsFile("/js/passport/services.js", ['position' => View::POS_END]);
		
		if(isset($_COOKIE['portalId'])){ 
			$query = $_COOKIE['portalId']; 
			
			$wsInit = new Curl();
			$q = $wsInit->setOption(CURLOPT_POSTFIELDS, http_build_query(array('login' => $query)))->setHeaders(array('Content-Type' => 'application/x-www-form-urlencoded'))->post((!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] ."/services/1/post");
			
			$ud_data = JSON::decode($q, true);
			return $this->render('passportServices', ['ud_data' => $ud_data[0]['country']]);
		}
		else{ 
			Yii::$app->response->statusCode = 401;
			return $this->redirect(['site/index']); 
		}
	}
	public function actionOffer(){
		$this->view->registerCssFile("/css/passport.css");
		$this->view->registerCssFile("/css/inpage_codes/passport/4.css");
		$this->view->registerJsFile("/js/passport.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/passport/offers.css");
		$this->view->registerJsFile("/js/passport/offers.js", ['position' => View::POS_END]);
		
		if(isset($_COOKIE['portalId'])){ 
			$query = $_COOKIE['portalId']; 
			
			$getOffers = Offers::find()->where(['login' => $query])->all();
			
			
			return $this->render('passportOffers', ['getOffers' => $getOffers]);
		}
		else{ 
			Yii::$app->response->statusCode = 401;
			return $this->redirect(['site/index']); 
		}
	}
	public function actionCart(){
		$this->view->registerCssFile("/css/passport.css");
		$this->view->registerCssFile("/css/inpage_codes/passport/5.css");
		$this->view->registerJsFile("/js/passport.js", ['position' => View::POS_END]);
		$this->view->registerCssFile("/css/passport/cart.css");
		$this->view->registerJsFile("/js/passport/cart.js", ['position' => View::POS_END]);
		
		if(isset($_COOKIE['portalId'])){ 
			$query = $_COOKIE['portalId']; 
			
			$connector = [
				Cart::find()->where(['and', ['login' => $query, 'category' => 'b']])->all(),
				Cart::find()->where(['and', ['login' => $query, 'category' => 'a']])->all(),
				Cart::find()->where(['and', ['login' => $query, 'category' => 'c']])->all()
			];
			
			return $this->render('passportCart', ['connector' => $connector]);
		}
		else{ 
			Yii::$app->response->statusCode = 401;
			return $this->redirect(['site/index']); 
		}
	}
	
	public function actionPassportservice($type){
		
		if($type == "get"){
			
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			
			if(isset($_GET['svc'])){
				$service = $_GET['svc'];
				
				switch($service){
					
				}
			}
			else{
				Yii::$app->response->statusCode = 403;
				return 'Action gateway error!';
			}
		}
		else if($type == "post"){
			
			\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
			
			if(isset($_GET['svc'])){
				$service = $_GET['svc'];
				
				switch($service){
					case 'profile':
						if(isset($_POST['svcQuery'])){
							$qp = JSON::decode($_POST['svcQuery']);
							
							$currentUser = News::findOne(['login' => $qp['login']]);
							
							$currentUser->login = $qp['query']['newLogin'];
							$currentUser->password = sha1($qp['query']['password']);
							$currentUser->firstname = $qp['query']['fn'];
							$currentUser->surname = $qp['query']['sn'];
							$currentUser->email = $qp['query']['email'];
							$currentUser->phone = $qp['query']['phone'];
							
							if($currentUser->save()){ 
								setcookie('portalId', $qp['query']['newLogin'], "/"); 
								return 'Investportal ID Update Success!'; 
							}
							else{
								Yii::$app->response->statusCode = 503;
								return 'Investportal ID Update Failed!';
							}
						}
						else{
							Yii::$app->response->statusCode = 403;
							return 'Query required!';
						}
					break;
					default:
						Yii::$app->response->statusCode = 404;
						return 'Service not found!';
					break;
				}
			}
			else{
				Yii::$app->response->statusCode = 403;
				return 'Action gateway error!';
			}
		}
		else{
			Yii::$app->response->statusCode = 402;
			return 'Gateway error!';
		}
	}
}
?>
