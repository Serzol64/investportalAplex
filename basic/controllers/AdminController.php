<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\View;
use yii\web\Url;
use yii\helpers\Json;
use org\apache\hadoop\WebHDFS;

use app\models\ObjectAttribute;
use app\models\ObjectReadyAttribute;
use app\models\ObjectFilter;
use app\models\Admin;
use app\models\News;
use app\models\Analytic;
use app\models\Event;
use app\models\PortalServices;
use app\models\PortalServicesCategory;

class AdminController extends Controller{
	public function beforeAction($action) { 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	}
    public function actionIndex(){
		$sessionData = Yii::$app->session;
		if(!$sessionData->isActive && !$sessionData->get('adminUser')){ return $this->redirect(['admin/auth']); }
		else{
			$pgUI = '';
			$this->layout = "adminPortal";
			$this->view->registerCssFile("/css/admin/admin.css");

			if(isset($_GET['svc'])){
				$service = $_GET['svc'];

				if($service == "dataManagment"){
					if(isset($_GET['subSVC'])){
						 switch($_GET['subSVC']){
							case "filters": 
								$service = 'dataFilters'; 
								$this->view->registerJsFile("/js/react/admin/addons/validParams.js", ['position' => View::POS_END]);
							break;
							case "news": $service='newsCMS/main'; break;
							case "analytics": $service='newsCMS/analytics'; break;
							case "events": $service='newsCMS/events'; break;
							case "portalServices":
								if(isset($_GET['page'])){ 
									$this->view->registerJsFile("/js/ckeditor/ckeditor.js", ['position' => View::POS_HEAD]); 
									$this->view->registerJsFile("/js/react/admin/portalServices/managment.js", ['type' => 'text/babel']); 
								}
								$service = 'portalServices';
							break;
							default: $service = 'dataAttributes'; break;
						 }
						 
						 if($_GET['subSVC'] == "news" || $_GET['subSVC'] == "analytics" || $_GET['subSVC'] == "events"){  
							 $this->view->registerJsFile("/js/ckeditor/ckeditor.js", ['position' => View::POS_HEAD]); 
							 $this->view->registerJsFile("/js/addons/strtotime.js"); 
						 }
					 }
				}
				else if($service == "adminUsers"){
					$service = 'adminUsers';
				}

				$pgUI = $service;
			}
			else{ 
				if(isset($_GET['dashboardSvc'])){
					switch($_GET['dashboardSvc']){
						case "portal": $pgUI = 'dashboards/portal'; break;
						case "data": $pgUI = 'dashboards/data'; break;
						case "news": $pgUI = 'dashboards/news'; break;
						case "user": $pgUI = 'dashboards/user'; break;
					}
				}
				else{ $pgUI = 'dashboard'; } 
			}

			$this->view->registerCssFile("/css/admin/pages/". $pgUI .".css");
			

			return $this->render('admin',['pgUI' => $pgUI]);
		}
	}
	public function actionAuth(){
		$sessionData = Yii::$app->session;
		if($sessionData->isActive && $sessionData->get('adminUser')){ header('Location: '. Url::to(['admin/index'])); }
		else{
			$this->layout = "adminAuth";
			$this->view->registerCssFile("/css/admin/auth.css");
			
			if(isset($_POST['username'])){
				$u = $_POST['username'];
				$p = $_POST['pass'];
				
				$query = ['admin' => $u, 'password' => $p];
				
				$svc = Yii::$app->asLogin->proccess($query);
				
				switch($svc['state']){
					case 1: return $this->redirect(['admin/index']); break;
					default:
						$validError = '';

						if($svc['noValidUser']){ $validError .= 'The login you entered no exists\n'; }
						if($svc['noValidPass']){ $validError .= 'The password you entered exists\n'; }
						
						$res = '<script>let problem=alert("'. $validError .'"),res="";res=problem?"/":"/admin/auth",window.location.assign(res);</script>';
						header($_SERVER['SERVER_PROTOCOL'] ." 400 Bad Request");
						echo $res;
					break;
				}
			}
		}
	
		return $this->render('auth');
	}
	public function actionSignout(){
		$response = Yii::$app->asExit->proccess();
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
		Yii::$app->response->statusCode = $response[0];
		return $response[1];
		
	}
	public function actionAdminDataFiltersSendService($svc){
		$hadoop = [new ObjectFilter, ObjectFilter::find()];
		$hive = [new ObjectAttribute, ObjectAttribute::find()];
		$tmpA = [new ObjectReadyAttribute, ObjectReadyAttribute::find()];

		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				if($svc == "Filters"){
					
					$attributeId = $pm['attribute'];
					
					switch($pm['type']){
						case "int": $dataType = 'int'; break;
						case "precentable": $dataType = 'precentable'; break;
						case "cost": $dataType = 'cost'; break;
						case "photogallery": $dataType = 'photogallery'; break;
						case "selecting": $dataType = 'selecting'; break;
						case "country": $dataType = 'country'; break;
						case "region": $dataType = 'region'; break;
						default: $dataType = 'text'; break;
					}
					
					$hadoop[0]->name = $attributeId;
					$hadoop[0]->field = $pm['field'];
					$hadoop[0]->type = $dataType;
					
					if($hadoop[0]->save()){ $serviceResponse[] = 'New filter in current attribute table created!'; }
					else{
						Yii::$app->response->statusCode = 503;
						$serviceResponse[] = 'DBA Service Error!';
					}
					
				}
				else if($svc == "Attribute"){
					$attributeId = $pm['attribute'];
					
					$groupCreate = $pm['group'];
					$key = 'readyAttribute';
										
										
					if($groupCreate == 'meta'){
						
						$tmpA[0]->name = $attributeId;
											 
						if(!$tmpA[0]->save()){
							Yii::$app->response->statusCode = 503;
							$serviceResponse[] = 'DBA Service Error!';
						}
						else{ $serviceResponse[] = 'Ready proccess success!'; }			
					}
					else if($groupCreate == 'data'){						
												
							$delR = $tmpA[0]::deleteAll(['name' => $attributeId]);
								
							$hive[0]->name = $attributeId;

							if($delR && $hive[0]->save()){ $serviceResponse[] = 'New attribute table created!'; }
							else{
								Yii::$app->response->statusCode = 502;
								$serviceResponse[] = 'Services gateway!';
							}
												
					}
										
				}
				else if($svc == "portalServices" || $svc == "portalServicesCategory"){
					$SConnector = [
						'c' => [new PortalServices, PortalServices::find()],
						's' => [new PortalServicesCategory, PortalServicesCategory::find()]
					];
					
					if($svc == "portalServicesCategory"){
						if($q['query']['iconBlob']){
							$lastId = $SConnector['s'][1]->orderBy('id desc')->limit(1)->all();
						
							if($lastId){
								foreach($lastId as $code){ $newId = $code->id + 1; }
							}
							else{ $newId = 1; }
							
							$SConnector['s'][0]->id = $newId;
							$SConnector['s'][0]->name = $q['query']['title'];
							$SConnector['s'][0]->icon = $q['query']['iconBlob'];
							
							if($SConnector['s'][0]->save()){ $serviceResponse[] = 'New service category added!'; }
							else{
								Yii::$app->response->statusCode = 502;
								$serviceResponse[] = 'Services gateway!';
							}
						}
						else{
							Yii::$app->response->statusCode = 402;
							$serviceResponse[] = 'Icon required!';
						}
					}
					else if($svc == "portalServices"){
						$lastId = $SConnector['c'][1]->orderBy('id desc')->limit(1)->all();
						
						if($lastId){
							foreach($lastId as $code){ $newId = $code->id + 1; }
						}
						else{ $newId = 1; }

						$SConnector['c'][0]->id = $newId;
						$SConnector['c'][0]->title = $q['query']['title'];

						if($q['query']['head']){ $SConnector['c'][0]->meta = $q['query']['head']; }
						if($q['query']['body']){ $SConnector['c'][0]->content = $q['query']['body']; }
						if($q['query']['footer']){ $SConnector['c'][0]->proc = $q['query']['footer']; }

						if($SConnector['c'][0]->save()){ $serviceResponse[] = 'New service added!'; }
						else{
							Yii::$app->response->statusCode = 502;
							$serviceResponse[] = 'Services gateway!';
						}
							
					}
				}
				else if($svc == "adminPortalUsers"){
					$adminDB = new Admin;
					
					$adminDB->login = $pm['login'];
					$adminDB->firstname = $pm['fn'];
					$adminDB->surname = $pm['sn'];
					$adminDB->role = $pm['rl'];
					$adminDB->email = $pm['mail'];
					$adminDB->password = sha1($pm['pwd']);
					$adminDB->country = $pm['region'];
					
					if($adminDB->save()){ $serviceResponse = 'New admin user success!'; }
					else{
						Yii::$app->response->statusCode = 502;
						$serviceResponse = 'Services gateway!';
					}
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Not command found!";
				}
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse = "Query not found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
		
	}
	public function actionAdminDataFiltersUpdateService($svc){
		$hadoop = [new ObjectFilter, ObjectFilter::find()];
		$hive = [new ObjectAttribute, ObjectAttribute::find()];
		
		
		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				if($svc == "Filters"){
					$attributeId = $pm['attribute'];
					
										
					switch($pm['type']){
						case "int": $dataType = 'int'; break;
						case "precentable": $dataType = 'precentable'; break;
						case "cost": $dataType = 'cost'; break;
						case "photogallery": $dataType = 'photogallery'; break;
						case "selecting": $dataType = 'selecting'; break;
						case "country": $dataType = 'country'; break;
						case "region": $dataType = 'region'; break;
						default: $dataType = 'text'; break;
					}
										
				
										
					$updateP = $hadoop[0]::updateAll(['type' => $dataType], ['name' => $attributeId, 'field' => $pm['field']]);
					
					if($pm['newField']){ $updateF = $hadoop[0]::updateAll(['field' => $pm['newField']], ['name' => $attributeId, 'field' => $pm['field']]); }
											
					if(($updateP && $updateF) || $updateP){ $serviceResponse[] = 'The filter in current attribute table updated!'; }
					else{
						Yii::$app->response->statusCode = 503;
						$serviceResponse[] = 'DBA Service Error!';
					}	
				}
				else if($svc == "Attribute"){
					$attributeId = $pm['attribute'];
					$attributeNewId = $pm['newAttribute'];
									
					if($hive[0]::updateAll(['name' => $attributeNewId],['name' => $attributeId]) && $hadoop[0]::updateAll(['name' => $attributeNewId],['name' => $attributeId])){ 
						$serviceResponse[] = 'Current attribute table update!';
					}
					else{
						Yii::$app->response->statusCode = 502;
						$serviceResponse[] = 'DBA Service Error!';
					}
									
				}
				else if($svc == "portalServices" || $svc == "portalServicesCategory"){
					$SConnector = [
						'c' => [new PortalServices, PortalServices::find()],
						's' => [new PortalServicesCategory, PortalServicesCategory::find()]
					];
					
					if($svc == "portalServicesCategory"){
						if($q['query']['iconBlob']){
							$sq = $SConnector['s'][1]->where(['id' => $q['query']['id']])->one();
						
							
							$sq->name = $q['query']['title'];
							if($q['query']['iconBlob']){ $sq->icon = $q['query']['iconBlob']; }
							
							if($sq->save()){ $serviceResponse[] = 'Service category updated!'; }
							else{
								Yii::$app->response->statusCode = 502;
								$serviceResponse[] = 'Services gateway!';
							}
						}
						else{
								Yii::$app->response->statusCode = 402;
								$serviceResponse[] = 'Icon required!';
						}
						
					}
					else if($svc == "portalServices"){
						$sq = $SConnector['c'][1]->where(['id' => $q['query']['id']])->one();
						
							
						$sq->title = $q['query']['title'];

						if($q['query']['head']){ $sq->meta = $q['query']['head']; }
						else{ $sq->meta = NULL; }

						if($q['query']['body']){ $sq->content = $q['query']['body']; }
						else{ $sq->content = NULL; }

						if($q['query']['footer']){ $sq->proc = $q['query']['footer']; }
						else{ $sq->proc = NULL; }

						if($sq->save()){ $serviceResponse[] = 'Service data updated!'; }
						else{
							Yii::$app->response->statusCode = 502;
							$serviceResponse[] = 'Services gateway!';
						}
					}
				}
				else if($svc == "adminPortalUsers"){
					$currentLogin = $q['login'];
					
					$adminDB = new Admin;
					
					$updateQuery = [
						'login' => $pm['login'],
						'firstname' => $pm['fn'],
						'surname' => $pm['sn'],
						'role' => $pm['rl'],
						'email' => $pm['mail'],
						'password' => sha1($pm['pwd']),
						'country' => $pm['region']
					];
					
					$updateData =  $adminDB::updateAll($updateQuery,['login' => $currentLogin]);
					
					if($updateData){ $serviceResponse[] = 'Update current admin user success!'; }
					else{
						Yii::$app->response->statusCode = 502;
						$serviceResponse[] = 'Services gateway!';
					}		
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Not command found!";
				}
								
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse = "Query not found!";
		}
		
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
	}
	public function actionAdminDataFiltersDeleteService($svc){
		$hadoop = [new ObjectFilter, ObjectFilter::find()];
		$hive = [new ObjectAttribute, ObjectAttribute::find()];

		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				if($svc == "Attribute"){
					$attributeId = $pm['attribute'];

					if($hadoop[0]::deleteAll('name = :attribute', [':attribute' => $attributeId]) && $hive[0]::deleteAll('name = :attribute', [':attribute' => $attributeId])){ 
						$serviceResponse[] = 'Current attribute table deleted!'; 
					}
					else{
						Yii::$app->response->statusCode = 502;
						$serviceResponse[] = 'DBA Service Error!';
					}	
				}
				else if($svc == "Filters"){
					$attributeId = $pm['attribute'];

					if($hadoop[0]::deleteAll('name = :attr AND field = :f', [':attr' => $attributeId, ':f' => $pm['field']])){ 
						$serviceResponse[] = 'Current filter deleted!'; 
					}
					else{
						Yii::$app->response->statusCode = 502;
						$serviceResponse[] = 'DBA Service Error!';
					}
				}
				else if($svc == "portalServices" || $svc == "portalServicesCategory"){
					$SConnector = [
						'c' => [new PortalServices, PortalServices::find()],
						's' => [new PortalServicesCategory, PortalServicesCategory::find()]
					];
					
					if($svc == "portalServicesCategory"){
						if($SConnector['s'][0]::deleteAll('id = :attr', [':attr' => $q['query']['id']])){ 
							$serviceResponse[] = 'Current category deleted!'; 
						}
						else{
							Yii::$app->response->statusCode = 502;
							$serviceResponse[] = 'DBA Service Error!';
						}
					}
					else if($svc == "portalServices"){
						if($SConnector['c'][0]::deleteAll('id = :attr', [':attr' => $q['query']['id']])){ 
							$serviceResponse[] = 'Current service deleted!'; 
						}
						else{
							Yii::$app->response->statusCode = 502;
							$serviceResponse[] = 'DBA Service Error!';
						}
					}
				}
				else if($svc == "adminPortalUsers"){
					$currentLogin = $q['login'];
					$adminDB = new Admin;
					
					$deleteQuery = $adminDB::deleteAll('login = :l', [':l' => $currentLogin]);
					
					if($deleteQuery){ $serviceResponse[] = 'Delete current admin user success!'; }
					else{
						Yii::$app->response->statusCode = 502;
						$serviceResponse[] = 'Services gateway!';
					}
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Not command found!";
				}
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse = "Query not found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
	}
	public function actionAdminDataFiltersResService($svc){
		$hadoop = [new ObjectFilter, ObjectFilter::find()];
		$hive = [new ObjectAttribute, ObjectAttribute::find()];
		$tmpA = [new ObjectReadyAttribute, ObjectReadyAttribute::find()];

		
		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				if($svc == "Filters"){
					$currentAttribute = $pm['attribute'];
					$query = ['name' => $currentAttribute];
					
					$filters = [];

					$result = $hadoop[1]->where($query)->all();

					foreach( $result as $row ) { 
						$filters[] = [
							'name' => $row->field,
							'type' => $row->type
						];
					}

					$serviceResponse = $filters;
										
					if(!$result){
						Yii::$app->response->statusCode = 503;
						$serviceResponse[] = 'DBA Service Error!';
					}
				}
				else if($svc == "adminPortalUsers"){
					$currentLogin = $q['login'];
					$adminDB = Admin::find();
					$query = ['login' => $currentLogin];
					
					$filters = [];

					$result = $adminDB->where($query)->all();

					foreach( $result as $row ) { 
						$filters = [
							'fn' => $row->firstname,
							'sn' => $row->surname,
							'rl' => $row->role,
							'region' => $row->country,
							'login' => $row->login,
							'mail' => $row->email
						];
					}

					$serviceResponse = $filters;
										
					if(!$result){
						Yii::$app->response->statusCode = 503;
						$serviceResponse[] = 'DBA Service Error!';
					}
				}
				else{
						Yii::$app->response->statusCode = 404;
						$serviceResponse[] = "Not command found!";	
				}
		}
		else if($svc == "portalServices" || $svc == "portalServicesCategory"){
			$SConnector = [
				'c' => [new PortalServices, PortalServices::find()],
				's' => [new PortalServicesCategory, PortalServicesCategory::find()]
			];
					
			if($svc == "portalServicesCategory"){ $serviceResponse[] = $SConnector['s'][1]->all(); }
			else if($svc == "portalServicesCategory"){ $serviceResponse[] = $SConnector['c'][1]->all(); }
		}
		else if($svc == "Attributes"){
				$tables = [];
				
				
				$ready = $hive[1]->all();
				$al = $tmpA[1]->all();
						
				$df = array_merge($ready, $al);

				foreach($df as $row ) { 
					$isFilters = $hadoop[1]->where(['name' => $row->name])->all();
					
					if(!$isFilters){ $state = 1; }
					else{ $state = 0; }
					$tables[] = [
						'name' => $row->name,
						'status' => $state
					];
				}

				$serviceResponse = $tables;
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse[] = "Query not found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
		
	}
	public function actionNewsSendService($svc){
		$news = [new News, News::find()];
		$events = [new Event, Event::find()];
		$analytics= [new Analytic, Analytic::find()];
		
		$dataCluster = [
			'n' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'a' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'e' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData]
		];

		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				
				if($svc == "News"){
					if(isset($q['svc'])){
						switch($q['svc']){
							case 'titleImage': 
								$ir = $dataCluster['n'][0]->send('news', $pm);
								
								Yii::$app->response->statusCode = $ir[1];
								$serviceResponse = $ir[0];
							break;
							case 'content': 
								$cr = $dataCluster['n'][1]->send('news', $pm);
								
								Yii::$app->response->statusCode = $cr[1];
								$serviceResponse = $cr[0];
							break;
							default: 
								Yii::$app->response->statusCode = 403;
								$serviceResponse = "Not service found!";
							break;
						}
					}
					
				}
				else if($svc == "Analytics"){
					
										
				}
				else if($svc == "Events"){
					
										
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Not command found!";
				}
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse = "Query not found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
		
	}
	public function actionNewsUpdateService($svc){
		$news = [new News, News::find()];
		$events = [new Event, Event::find()];
		$analytics= [new Analytic, Analytic::find()];
		
		$dataCluster = [
			'n' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'a' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'e' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData]
		];

		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				if($svc == "News"){
					if(isset($q['svc'])){
						switch($q['svc']){
							case 'titleImage': 
								$ir = $dataCluster['n'][0]->send('news', $pm);
								
								Yii::$app->response->statusCode = $ir[1];
								$serviceResponse = $ir[0];
							break;
							case 'content': 
								$cr = $dataCluster['n'][1]->send('news', $pm);
								
								Yii::$app->response->statusCode = $cr[1];
								$serviceResponse = $cr[0];
							break;
							default: 
								Yii::$app->response->statusCode = 403;
								$serviceResponse = "Not service found!";
							break;
						}
					}
				}
				else if($svc == "Analytics"){
					
										
				}
				else if($svc == "Events"){
					
										
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Not command found!";
				}
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse = "Query not found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
	}
	public function actionNewsDeleteService($svc){
		$news = [new News, News::find()];
		$events = [new Event, Event::find()];
		$analytics= [new Analytic, Analytic::find()];
		
		$dataCluster = [
			'n' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'a' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'e' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData]
		];
		
		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				if($svc == "News"){
					if(isset($q['svc'])){
						switch($q['svc']){
							case 'titleImage': 
								$ir = $dataCluster['n'][0]->send('news', $pm);
								
								Yii::$app->response->statusCode = $ir[1];
								$serviceResponse = $ir[0];
							break;
							case 'content': 
								$cr = $dataCluster['n'][1]->send('news', $pm);
								
								Yii::$app->response->statusCode = $cr[1];
								$serviceResponse = $cr[0];
							break;
							default: 
								Yii::$app->response->statusCode = 403;
								$serviceResponse = "Not service found!";
							break;
						}
					}
				}
				else if($svc == "Analytics"){
					
										
				}
				else if($svc == "Events"){
					
										
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Not command found!";
				}
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse = "Query not found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
	}
	public function actionNewsResService($svc){
		$news = [new News, News::find()];
		$events = [new Event, Event::find()];
		$analytics= [new Analytic, Analytic::find()];
		
		$dataCluster = [
			'n' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'a' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData],
			'e' => [Yii::$app->adminCMSHeader, Yii::$app->adminCMSData]
		];

		$serviceResponse = array();
		
		if(isset($_POST['svcQuery'])){
				$q = Json::decode($_POST['svcQuery']);
				$pm = $q['parameters'];
				
				if($svc == "News"){
					if(isset($q['svc'])){
						switch($q['svc']){
							case 'titleImage': 
								$ir = $dataCluster['n'][0]->send('news', $pm);
								
								Yii::$app->response->statusCode = $ir[1];
								$serviceResponse = $ir[0];
							break;
							case 'content': 
								$cr = $dataCluster['n'][1]->send('news', $pm);
								
								Yii::$app->response->statusCode = $cr[1];
								$serviceResponse = $cr[0];
							break;
							case 'meta': 
								$ir = $dataCluster['n'][0]->send('news', $pm);
								
								Yii::$app->response->statusCode = $ir[1];
								$serviceResponse = $ir[0];
							break;
							case 'list': 
								$queryList = $news[1]->select('id,title,created')->all();
								
								if($queryList){
									$newsData = [];
									foreach($queryList as $n){ $newsData[] = $n; }
									$serviceResponse = $newsData;
								}
								else{ 
									Yii::$app->response->statusCode = 402;
									$serviceResponse = "Not matherials!"; 
								}
							break;
							default: 
								Yii::$app->response->statusCode = 403;
								$serviceResponse = "Not service found!";
							break;
						}
					}
				}
				else if($svc == "Analytics"){
					
										
				}
				else if($svc == "Events"){
					
										
				}
				else{
					Yii::$app->response->statusCode = 404;
					$serviceResponse = "Not command found!";
				}
		}
		else{
			Yii::$app->response->statusCode = 405;
			$serviceResponse = "Query not found!";
		}
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $serviceResponse;
		
	}
}
?>
