<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\View;
use yii\helpers\Json;
use linslin\yii2\curl\Curl;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;

use app\models\Event;
use app\models\Analytic;

use app\models\User;
use app\models\ObjectAttribute;
use app\models\Investments;
use app\models\Offers;
use app\models\ObjectsData;
use app\models\PortalServices;
use app\models\PortalServicesCategory;


class SiteController extends Controller{
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
		
		
		$eventComing = Event::find()->orderBy('date_from DESC')->limit(5)->all();

		
		$interactive = [
			'analytic' => [
				'last' => Analytic::find()->select('id,titleImage,title')->orderBy('created DESC')->limit(3)->asArray()->all(),
				'prelast' => Analytic::find()->select('id,titleImage,title')->orderBy('created DESC')->limit(6)->offset(3)->asArray()->all(),
				'old' => Analytic::find()->select('id,titleImage,title')->orderBy('created DESC')->limit(9)->offset(6)->asArray()->all()
			],
			'objects' => [
				'popular' => Yii::$app->smartData->getList('object-popular', 0),
				'finding' => Yii::$app->smartData->getList('object-investors', 0),
				'estate' => [
					'last' => Yii::$app->smartData->getList('object-estates', 0),
					'prelast' => Yii::$app->smartData->getList('object-estates', 1),
					'old' => Yii::$app->smartData->getList('object-estates', 2),
					'adaptive' => Yii::$app->smartData->getList('object-estates', 3)
				]
			],
			'reviews' => [
					'last' => Yii::$app->smartData->getList('reviews', 0)->articles,
					'prelast' => Yii::$app->smartData->getList('reviews', 1)->articles,
					'old' => Yii::$app->smartData->getList('reviews', 2)->articles,
					'adaptive' => Yii::$app->smartData->getList('reviews', 3)->articles
			],
			'services' => [
				'desktop' => [
					'last' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 3')->queryAll(),
					'prelast' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 6 OFFSET 3')->queryAll(),
					'old' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 9 OFFSET 6')->queryAll()
				],
				'mobile' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 8')->queryAll()
			]
		];
		
		//var_dump($interactive['reviews']);
		
		return $this->render('index', ['staticCount' => $sc[0], 'staticMeta' => $sc[1], 'interactiveFeed' => $interactive, 'lastUpcoming' => $eventComing]);
	}
	public function actionAbout(){
		$this->view->registerCssFile("/css/about.css");
		$this->view->registerJsFile("/js/about.js", ['position' => View::POS_END]);
		
		return $this->render('about');
	}
	
	public function actionServices(){
		$this->view->registerCssFile("/css/services.css");
		$this->view->registerJsFile("/js/services.js", ['position' => View::POS_END]);
		
		$this->view->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css");
		$this->view->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js", ['position' => View::POS_BEGIN]);

		$sf = [
			PortalServicesCategory::find()->all(),
			PortalServices::find(['meta->seoData->categoryId' => '1'])->all()
		];
		
		return $this->render('services', ['categories' => $sf[0], 'services' => $sf[1]]);
	}
	public function actionServicePage($id){
		$this->view->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css");
		$this->view->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js", ['position' => View::POS_HEAD]);
		
		
		$this->view->registerCssFile("/css/services/portalServices/page.css");
		$this->view->registerJsFile("/js/services/page.js", ['position' => View::POS_END]);
		
		$serviceDataQuery = [':service' => $id];
		$currentServiceQuery = [
			Yii::$app->db->createCommand('SELECT id, title FROM serviceList WHERE id=:service')->bindValues($serviceDataQuery)->queryOne(),
			Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description",  JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.term")) as "term", JSON_EXTRACT(meta, "$.accessRole") as "private" FROM serviceList WHERE id=:service')->bindValues($serviceDataQuery)->queryOne(),
			Yii::$app->db->createCommand('SELECT JSON_EXTRACT(proc, "$.send") as "send",  JSON_EXTRACT(proc, "$.push") as "push",  JSON_EXTRACT(proc, "$.realtime") as "realtime",  JSON_EXTRACT(proc, "$.control") as "control" FROM serviceList WHERE id=:service')->bindValues($serviceDataQuery)->queryOne(),
			Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.faqService[*].question")) as "question",  JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.faqService[*].answer")) as "answer" FROM serviceList WHERE id=:service')->bindValues($serviceDataQuery)->queryAll(),
		];

		return $this->render('servicePage', ['servicePage' => $currentServiceQuery]);
	}
	public function actionServicePageForm($id, $pagetype){

		$this->view->registerJsFile("https://unpkg.com/@babel/standalone/babel.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerJsFile("https://unpkg.com/react@17/umd/react.production.min.js", ['position' => View::POS_HEAD]);
		$this->view->registerJsFile("https://unpkg.com/react-dom@17/umd/react-dom.production.min.js", ['position' => View::POS_HEAD]);

		if($pagetype == 'form'){
			$servicePage = PortalServices::findOne(['id' => $id]);
			
			$this->view->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.11/jquery.autocomplete.min.js", ['position' => View::POS_HEAD]);
			$this->view->registerJsFile("/js/react/serviceFormPage.js", ['position' => View::POS_END]);
		}
		else{
			Yii::$app->response->statusCode = 404;
			return $this->redirect(['site/service-page', ['id' => $id]]);
		}

		return $this->render('serviceViewer', ['serviceForm' => $servicePage, 'type' => $pagetype]);
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
					else if(isset($_POST['countryCities'])){
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return Yii::$app->regionDB->listCitiesOfCountry($_POST['countryCities']);
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
			case 2:
				if($operation == 'post'){
					$cuData = [];
					
					if(isset($_GET['id']) && isset($_POST['cmd'])){
						$cmdQuery = JSON::deocde($_POST['cmd'], true);

						switch($cmdQuery['type']){
							case 'sender': 
								if(isset($_COOKIE['portalId'])){ $senderCall = Yii::$app->consoleRunner->run('portal-service-sender/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=TRUE'); }
								else{ $senderCall = Yii::$app->consoleRunner->run('portal-service-sender/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=FALSE'); }

								$cuData = $senderCall;
							break;
							case 'control': 
								if(isset($_COOKIE['portalId'])){ $controlCall = Yii::$app->consoleRunner->run('portal-service-control/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=TRUE'); }
								else{ $controlCall = Yii::$app->consoleRunner->run('portal-service-control/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=FALSE'); }

								$cuData = $controlCall;
							break;
							default: 
								Yii::$app->response->statusCode = 403;
								$cuData[] = 'Operation not found!';
							break;
						}
					}
					
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $cuData;
				}
				else if($operation == 'get'){
					$vuData = [];
					
					if(isset($_GET['id']) && isset($_GET['cmd'])){
						$cmdQuery = JSON::deocde($_GET['cmd'], true);

						switch($cmdQuery['type']){
							case 'sender': 
								if(isset($_COOKIE['portalId'])){ $senderCall = Yii::$app->consoleRunner->run('portal-service-sender/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=TRUE'); }
								else{ $senderCall = Yii::$app->consoleRunner->run('portal-service-sender/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=FALSE'); }

								$vuData = $senderCall;
							break;
							case 'control': 
								if(isset($_COOKIE['portalId'])){ $controlCall = Yii::$app->consoleRunner->run('portal-service-control/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=TRUE'); }
								else{ $controlCall = Yii::$app->consoleRunner->run('portal-service-control/index --serviceId=' . $_GET['id'] . ' --query=' . $cmdQuery['parameters'] . ' --userAuthType=FALSE'); }

								$vuData = $controlCall;
							break;
							default: 
								Yii::$app->response->statusCode = 403;
								$vuData[] = 'Operation not found!';
							break;
						}
					}

					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $vuData;
				}
				else{
					Yii::$app->response->statusCode = 402;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Operation not found'; 
				}
			break;
			case 3:
				if($operation == 'get'){
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return Yii::$app->regionDB->listCities();
				}
				else{
					Yii::$app->response->statusCode = 402;
					\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
					return 'Operation not found'; 
				}
			break;
			case 4:
				if($operation == 'post'){
					if(isset($_POST['categoryId'])){
						$listResponse = [];
						$listSet = PortalServices::find()->all();
						$cat = $_POST['categoryId'];
						$regexIs = 0;
						
						foreach($listSet as $lds){
							$metaData = Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat" FROM serviceList WHERE id=:service')->bindValues([':service' => $lds->id])->queryOne();
							
							if($metaData['cat'] == $cat){
								$listResponse[] = [
									'id' => $lds->id,
									'title' => $lds->title,
									'meta' => $lds->meta,
									'content' => $lds->content,
									'proc' => $lds->proc
								];
								
								$regexIs++;
							}
						}
						
						if($regexIs == 0){
							Yii::$app->response->statusCode = 404;
							\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
							return 'Services not found'; 
						}
						
						\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
						return $listResponse;
					}
					else{
						Yii::$app->response->statusCode = 402;
						\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
						return 'Operation not found'; 
					}
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
									'api_id' => getenv('SMSRu_Investportal'),
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
	
	
}
?>
