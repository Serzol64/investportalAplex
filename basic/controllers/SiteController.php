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
use app\models\ObjectAttribute;
use app\models\Investments;
use app\models\Offers;
use app\models\ObjectsData;
use app\models\PortalServices;


class SiteController extends Controller{
	public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
	public function beforeAction($action) { 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	}
	public function actionIndex(){
		$this->view->registerCssFile("https://unpkg.com/swiper/swiper-bundle.min.css");
		$this->view->registerJsFile("https://unpkg.com/swiper/swiper-bundle.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerCssFile("/css/inpage_codes/homepage_styles.css");
		$this->view->registerJsFile("/js/addons/slidesshow.js", ['position' => View::POS_END]);
		$this->view->registerJsFile("/js/inpage_codes/homepage_script.js", ['position' => View::POS_END]);
		
		
		$sc = [
			[ObjectsData::find()->count(), Investments::find()->count(), PortalServices::find()->count(), User::find()->count()], 
			[ObjectAttribute::find()->count(), Offers::find()->count()]
		];
		
		return $this->render('index', ['staticCount' => $sc[0], 'staticMeta' => $sc[1]]);
	}
	public function actionAbout(){
		$this->view->registerCssFile("/css/about.css");
		$this->view->registerJsFile("/js/about.js", ['position' => View::POS_END]);
		
		return $this->render('about');
	}
	
	public function actionServices(){
		$this->view->registerCssFile("/css/news.css");
		$this->view->registerCssFile("/css/services.css");
		$this->view->registerJsFile("/js/services.js", ['position' => View::POS_END]);
		
		$sf = [
			
		];
		
		return $this->render('services', ['categories' => $sf[0]);
	}
	public function actionServicesApi($serviceId, $operation){
		switch($serviceId){
			case 0: 
				if($operation == 'get'){
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return Yii::$app->regionDB->getFullDataFrame();
				}
				else if($operation == 'post'){
					if(isset($_POST['country'])){
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return Yii::$app->regionDB->listRegion(strtoupper($_POST['country']));
					}
					else{
						Yii::$app->response->statusCode = 403;
						\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
						return 'Query not found';
					}
				}
				else{
					Yii::$app->response->statusCode = 402;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Operation not found'; 
				}
			break;
			case 1: 
				if($operation == 'post'){
					$cuData = [];
					
					if($_POST['login']){
						$portalId = $_POST['login'];
						
						$ud_response = User::find()->where(['login' => $portalId])->all();
						
						$cuData = $ud_response;
					}
					else{
						Yii::$app->response->statusCode = 403;
						$cuData = 'Action not found!';
					}
					
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $cuData;
				}
				else{
					Yii::$app->response->statusCode = 402;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Operation not found'; 
				}
			break;
			default: 
				Yii::$app->response->statusCode = 404;
				\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
				return 'Service not found'; 
			break;
		}
	}
	public function actionAccountService($service){
		$q = JSON::decode($_POST['serviceQuery'], true);
		
		if($service == "signIn"){
			if(isset($_POST['serviceQuery'])){
					$sign = $q['asq']; //Authoriation service query
					
					$rs = Yii::$app->portalLogin->proccess($sign);
					
					Yii::$app->response->statusCode = $rs['c'];
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $rs['m'];
			}
			else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Query conflict'; 
			}
		}
		
		else if($service == "signUp"){
			if(isset($_POST['serviceQuery'])){
					$sign = $q['rsq']; //Registration service query
					
					$rs = Yii::$app->portalReg->proccess($sign);
					
					Yii::$app->response->statusCode = $rs['c'];
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $rs['m'];
			}
			else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Query conflict'; 
			}
		}
		else if($service == "forgot"){
			if(isset($_POST['serviceQuery'])){
					$sign = $q['fsq']; //Forgot service query
					
					$rs = Yii::$app->portalPass->proccess($sign);
					
					Yii::$app->response->statusCode = $rs['c'];
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $rs['m'];
			}
			else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Query conflict'; 
			}
		}
		else if($service == "autoAuth"){
			if(isset($_POST['serviceQuery'])){
					$sign = $q['fsq']; //Forgot service query
					
					$rs = Yii::$app->autoLogin->proccess($sign);
					
					Yii::$app->response->statusCode = $rs['c'];
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $rs['m'];	
			}
			else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Query conflict'; 
			}
		}
		else if($service == "signOut"){
			if(!Yii::$app->user->isGuest){ 
					
				$rs = Yii::$app->autoLogin->proccess();
					
				Yii::$app->response->statusCode = $rs['c'];
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return $rs['m']; 
			}
			else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Service conflict'; 
			}
		}
		else if($service == "fb"){
			\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
			
			if(isset($_POST['serviceQuery'])){
				$service = $q['fbsvc'];
				$fbQuery = $q['fbq'];
				
				switch($service){
					case 'login': 
						$inModel = [
							User::find(),
							new User()
						];
						
						$vMail = '';

						foreach($inModel[0]->all() as $authData){
							$vLogin = $authData->login;
							$vMail = $authData->email;

							if($vMail == $fbQuery['login']){
								$auth = setcookie('portalId', $vLogin, strtotime("+1 year"), "/"); 

								if($auth){ return 'Authorization success!'; }
								else{ 
									Yii::$app->response->statusCode = 409;
									return 'The portal accounting service is temporarily unavailable! Try again later;-('; 
								}
							}
							else{
								Yii::$app->response->statusCode = 404;
								return 'Quered user data not exists!';
							}
						}
					break;
					case 'registration': 
						$upModel = [
							User::find(),
							new User()
						];
						
						$userRegion = (new Client)->createRequest()->setMethod('GET')->setUrl('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'])->send();
						
						$login = $fbQuery['l'];
						$pass = sha1($fbQuery['p']);
						$firstname = $fbQuery['fn'];
						$surname = $fbQuery['sn'];
						$mail = $fbQuery['e'];
						$phone = $fbQuery['m'];
						$region = strtolower($userRegion->data['countryCode']);

						$validLogin = $upModel[0]->where(['login' => $login])->all();
						$validEMail = $upModel[0]->where(['email' => $mail])->all();
						$validPassword = $upModel[0]->where(['password' => $pass])->all();
						$validPhone = $upModel[0]->where(['phone' => $phone])->all();

						if(!$validLogin && !$validEMail && !$validPassword && !$validPhone){
							$upModel[1]->firstname = $firstname;
							$upModel[1]->surname = $surname;
							$upModel[1]->login = $login;
							$upModel[1]->password = $pass;
							$upModel[1]->email = $mail;
							$upModel[1]->phone = $phone;
							$upModel[1]->country = $region;
										
										
							if($upModel[1]->save()){ 
								$contentAuth = 'The provided access data to your account on the portal:\n\n';
								
								$contentAuth .= 'Login: '. $login .'\n';
								$contentAuth .= 'Password: '. $fbQuery['p'];
								
								
								$smsQuery = [
									'api_id' => '7FFF14D0-E44B-DA7B-7ABD-EB36D169FE29',
									'to' => $phone,
									'msg' => $contentAuth
								];
								(new Client)->createRequest()->setMethod('GET')->setUrl('https://sms.ru/sms/send')->setData($smsQuery)->send();
								setcookie('portalId', $login, "/");
								
								return 'Registration success!'; 
							}
							else{ 
								Yii::$app->response->statusCode = 409;
								return 'The portal accounting service is temporarily unavailable! Try again later;-('; 
							}
						}
						else{
							Yii::$app->response->statusCode = 404;
							return 'Quered user data is exists!';
						}
					break;
					default:
						Yii::$app->response->statusCode = 403;
						return 'Service not found!';
					break;
				}
			}
			else{ 
					Yii::$app->response->statusCode = 405;
					return 'Query conflict'; 
			}
		}
		else{
				Yii::$app->response->statusCode = 404;
				\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
				return 'Service not found'; 
		}
	}
	public function actionServiceCodeCenter($service){
		$q = JSON::decode($_POST['serviceQuery'], true);
		
		if($service == "signUp"){
			if(isset($_POST['serviceQuery'])){
					$sign = $q['rsq']; //Registration service query

					if($sign['service'] === 'Inbox'){
						$query = JSON::encode(['fsq' => ['svc' => 'SignUp']]);

						$wsInit = new Curl();
						$query = $wsInit->setOption(CURLOPT_POSTFIELDS, http_build_query(array('serviceQuery' => $query)))->post((!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] ."/accounts/accept/codeGenerator");

						$sign['code'] = $query;
					}

					if($sign['service'] === 'Inbox'){ 
						$sndr = Yii::$app->smsCoder->sendCode('SignUp', $sign['phone']); 
						
						Yii::$app->response->statusCode = $sndr['c'];
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return $sndr['m'];
					}
					else if($sign['service'] === 'Valid'){ 
						$vld = Yii::$app->smsCoder->validCode('SignUp', $sign['phone'], $sign['code']); 
						
						Yii::$app->response->statusCode = $vld['c'];
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return $vld['m'];
					}
					else{ 
						Yii::$app->response->statusCode = 403;
						\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
						return 'Operation conflict'; 
					}
			}
			else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Query conflict'; 
			}
		}
		else if($service == "forgot"){
				if(isset($_POST['serviceQuery'])){
					$sign = $q['fsq']; //Forgot service query

					if($sign['service'] === 'Inbox'){
						$query = JSON::encode(['fsq' => ['svc' => 'Forgot']]);

						$wsInit = new Curl();
						$query = $wsInit->setOption(CURLOPT_POSTFIELDS, http_build_query(array('serviceQuery' => $query)))->post((!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST'] ."/accounts/accept/codeGenerator");

						$sign['code'] = $query;
					}

					if($sign['service'] === 'Inbox'){ 
						$sndr = Yii::$app->smsCoder->sendCode('Forgot', $sign['phone']); 
						
						Yii::$app->response->statusCode = $sndr['c'];
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return $sndr['m'];
					}
					else if($sign['service'] === 'Valid'){ 
						$vld = Yii::$app->smsCoder->validCode('Forgot', $sign['phone'], $sign['code']); 
						
						Yii::$app->response->statusCode = $vld['c'];
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return $vld['m'];
					}
					else{ 
						Yii::$app->response->statusCode = 403;
						\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
						return 'Operation conflict'; 
					}
					
				}
				else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Query conflict'; 
				}
		}
		
		else if($service == "codeGenerator"){
				if(isset($_POST['serviceQuery'])){
					$source = $q['fsq'];

					$generateCode = [
						ceil(getRandomFromRange(1000,9999)),
						ceil(getRandomFromRange(2000,4600))
					];

					$isSignUp = $source['svc'] === 'SignUp' ? TRUE : FALSE;
					$isForgot = $source['svc'] === 'Forgot' ? TRUE : FALSE;

					if($isSignUp){ $newCode = $generateCode[0]; }
					else if($isForgot){ $newCode = $generateCode[1]; }

					return $newCode;
					
				}
				else{ 
					Yii::$app->response->statusCode = 405;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Query conflict'; 
				}
		}
		else{
				Yii::$app->response->statusCode = 404;
				\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
				return 'Service not found'; 
		}
	}
	public function actionError(){
		$exception = Yii::$app->errorHandler->exception;
		if ($exception->statusCode == 404) {
			return $this->redirect(['site/index']);
		}
	}
	
	
}
?>
