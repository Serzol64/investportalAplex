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
use app\models\Subscription;
use app\models\Investments;
use app\models\Offers;
use app\models\Cart;

class PassportController extends Controller{
	public function beforeAction($action) { 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	}
	public function actionService(){
		$this->view->registerJsFile("https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.4/jquery-ui.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerCssFile("https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.4/themes/flick/jquery-ui.css");
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
		
		$this->view->registerJsFile("/js/passport/alertify/alertify.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerCssFile("/js/passport/alertify/css/alertify.min.css");
		$this->view->registerCssFile("/js/passport/alertify/themes/default.min.css");
		
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
		
		$this->view->registerJsFile("/js/passport/alertify/alertify.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerCssFile("/js/passport/alertify/css/alertify.min.css");
		$this->view->registerCssFile("/js/passport/alertify/css/themes/default.min.css");
		
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
		$this->view->registerJsFile("https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.4/jquery-ui.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerCssFile("https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.4/themes/flick/jquery-ui.css");
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
		$responseData = [];
		
		if($type == "get"){
			
			
			if(isset($_GET['svc'])){
				$service = $_GET['svc'];
				
				switch($service){
					
				}
			}
			else{
				Yii::$app->response->statusCode = 403;
				$responseData = 'Action gateway error!';
			}
		}
		else if($type == "post"){
			if(isset($_GET['svc'])){
				$service = $_GET['svc'];
				switch($service){
					case 'profile':
						if(isset($_POST['svcQuery'])){
							$qp = JSON::decode($_POST['svcQuery']);
							
							$currentUser = User::findOne(['login' => $qp['login']]);
							
							if($qp['query']['newLogin']){ $currentUser->login = $qp['query']['newLogin']; }
							else if($qp['query']['password']){ $currentUser->password = sha1($qp['query']['password']); }
							else if($qp['query']['fn']){ $currentUser->firstname = $qp['query']['fn']; }
							else if($qp['query']['sn']){ $currentUser->surname = $qp['query']['sn']; }
							else if($qp['query']['email']){ $currentUser->email = $qp['query']['email']; }
							else if($qp['query']['phone']){ $currentUser->phone = $qp['query']['phone']; }
							else if($qp['query']['region']){ $currentUser->country = $qp['query']['region']; }
							
							if($currentUser->update()){ 
								if($qp['query']['newLogin']){ 
									unset($_COOKIE['portalId']);
									setcookie('portalId', $qp['query']['newLogin'], strtotime("+ 1 year"), "/"); 
								}
								
								\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
								$postProfile = 'Investportal ID Data Update Success!';
							}
							else{
								\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
								Yii::$app->response->statusCode = 503;
								$postProfile = 'Investportal ID Data Update Failed!';
							}
						}
						else{
							\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
							Yii::$app->response->statusCode = 403;
							$postProfile = 'Query required!';
						}
					break;
					case 'services':
						if(isset($_POST['svcQuery'])){
							$qp = JSON::decode($_POST['svcQuery']);
							
							$updateUS = 0;
							$wscInit = new Curl();
							
							//The first step is to delete existing subscriptions
							
							if(Subscription::findAll(['login' => $qp['login']])){ $deleteUS = Subscription::deleteAll(['login' => $qp['login']]); }
							else{ $deleteUS = TRUE; }
							
							//The second step is to change the region
							
							$regionQuery = [
								'login' => $qp['login'],
								'query' => [ 'region' => $qp['region'] ]
							];
							
							$rq = JSON::encode($regionQuery);
							
							$updateRegion = $wscInit->setOption(CURLOPT_POSTFIELDS, http_build_query(array('svcQuery' => $rq)))->setHeaders(array('Content-Type' => 'application/x-www-form-urlencoded'))->post((!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] ."/passport/api/post?svc=profile");
							
							//The third step is updating the requested subscriptions
							if(count($qp['svc']) > 0){
								$sdq = [];
								for($i = 0; $i < count($qp['svc']); $i++){
									$sdq[] = [
										'login' => $qp['login'],
										'attribute' => $qp['svc'][$i]
									];
								}
								
								$postProfile[] = Yii::$app->db->createCommand()->batchInsert('userSubscriptions', ['login', 'attribute'], $sdq)->execute() ? TRUE : NULL;
							}
							else{ $postProfile[] = "Empty query"; }
							
							
							if($deleteUS && $updateRegion->errorCode === null){
								\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
								$postProfile[] = "User Subscribe Data Update Success!";
							}
							else{
								\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
								Yii::$app->response->statusCode = 503;
								$postProfile = "User Subscribe Data Update Error!";
							}
						}
						else{
							\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
							Yii::$app->response->statusCode = 403;
							$postProfile = 'Query required!';
						}
						
					break;
					default:
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						Yii::$app->response->statusCode = 404;
						$postProfile = 'Service not found!';
					break;
				}
			}
			else{
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				Yii::$app->response->statusCode = 403;
				$postProfile = 'Action gateway error!';
			}
			
			$responseData = $postProfile;
		}
		else{
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			Yii::$app->response->statusCode = 402;
			$responseData = 'Gateway error!';
		}
		
		return $responseData;
	}
}
?>
