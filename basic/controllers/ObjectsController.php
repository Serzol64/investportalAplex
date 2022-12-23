<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\View;

use app\models\Expert;
use app\models\Investors;
use app\models\ObjectAttribute;
use app\models\ObjectsData;
use app\models\User;

class ObjectsController extends Controller
{
	public function beforeAction($action) { 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	}
    public function actionIndex()
    {
        $this->view->registerCssFile('/css/objects.css');
        $this->view->registerCssFile('/css/inpage_codes/objects/1.css');
        $this->view->registerJsFile('/js/objects.js', ['position' => View::POS_END]);

        $oads = [
            ObjectAttribute::find()->limit(12)->all(),
            ObjectAttribute::find()->limit(24)->offset(12)->all(),
        ];
        $ds = [
            'all' => ObjectsData::find()->select('id')->orderBy('id DESC')->all(),
        ];

        $searchParameters = [
            'min' => Yii::$app->db->createCommand('SELECT MIN(JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.cost[0].value"))) as "cost", MIN(JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.precentable[0].value"))) as "profitability" FROM objectData')->queryOne(),
            'max' => Yii::$app->db->createCommand('SELECT MAX(JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.cost[0].value"))) as "cost", MAX(JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.precentable[0].value"))) as "profitability" FROM objectData')->queryOne(),
        ];

        return $this->render('objects', ['attrs' => $oads, 'dataset' => $ds, 'minObjectParameter' => $searchParameters['min'], 'maxObjectParameter' => $searchParameters['max']]);
    }

    public function actionObject()
    {
        $this->view->registerCssFile('/css/objects.css');
        $this->view->registerCssFile('/css/objects/hotels.css');
        $this->view->registerCssFile('/css/inpage_codes/objects/2.css');
        $this->view->registerJsFile('/js/objects.js', ['position' => View::POS_END]);
        $this->view->registerJsFile('/js/objects/hotels.js', ['position' => View::POS_END]);

        return $this->render('object');
    }

    public function actionView($objectId)
    {
        $this->view->registerCssFile('/css/objects.css');
        $this->view->registerCssFile('/css/objects/view.css');
        $this->view->registerCssFile('/css/inpage_codes/objects/3.css');
        $this->view->registerJsFile('/js/objects.js', ['position' => View::POS_END]);
        $this->view->registerJsFile('/js/objects/view.js', ['position' => View::POS_END]);

        $objectQuery = [':object' => $objectId];

        $connector = [
            'meta' => [
                'meta' => Yii::$app->db->createCommand('SELECT id, title, CONCAT(JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.region.country")), ', ', JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.region.region"))) as "region", JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.parameters.cost.value")) as "cost", JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.parameters.precentable[0].value")) as "profitableness", JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.mediagallery.video.poster")) as "videoPoster" FROM objectData WHERE id=:object')->bindValues($objectQuery)->queryOne(),
                'parameters' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.parameters[*].filter")) as "filter", JSON_UNQUOTE(JSON_EXTRACT(content, "content.parameters[*].value")) as "value" FROM objectData WHERE id=:object')->bindValues($objectQuery)->queryAll(),
                'photo' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.mediagallery.photo.data[*].file")) as "file" FROM objectData WHERE id=:object')->bindValues($objectQuery)->queryAll(),
                'video' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.mediagallery.video.data[*].file")) as "file" FROM objectData WHERE id=:object')->bindValues($objectQuery)->queryAll(),
            ],
            'creator' => function () {
                $login = ObjectsData::findOne(['id' => $objectQuery[':object']]);
                $user = User::findOne(['login' => $login->creator]);

                return $user;
            },
            'objects' => [
                'all' => ObjectsData::find()->select('id')->orderBy('id DESC')->all(),
            ],
            'portalServices' => [
                'desktop' => [
                    'last' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 3')->queryAll(),
                    'prelast' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 6 OFFSET 3')->queryAll(),
                    'old' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 9 OFFSET 6')->queryAll(),
                ],
                'mobile' => Yii::$app->db->createCommand('SELECT id, title, JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.categoryId")) as "cat", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(meta, "$.seoData.region.region")) as "region" FROM serviceList ORDER BY id LIMIT 8')->queryAll(),
            ],
            
        ];

        return $this->render('objectsView', ['metaData' => $connector['meta'], 'contactData' => $connector['creator'], 'dataset' => $connector['objects'], 'serviceList' => $connector['portalServices']]);
    }

    public function actionInvestors()
    {
		$this->view->registerCssFile('/js/lib/modalLoading/modal-loading-animate.css');
		$this->view->registerJsFile('/js/lib/modalLoading/modal-loading.js', ['position' => View::POS_HEAD]);
		
        $this->view->registerCssFile('/css/investors.css');
        $this->view->registerJsFile('/js/investors.js', ['position' => View::POS_END]);
        
		
		$this->view->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css");
		$this->view->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js", ['position' => View::POS_BEGIN]);
		
		$dataLake = [
			'popularRegions' => Yii::$app->db->createCommand('SELECT region as "country", COUNT(id) as "objectsCount" FROM investors GROUP BY country ORDER BY objectsCount DESC LIMIT 4')->queryAll()
		];
		
        $adverstments = Investors::find()->select(['id', 'title', 'descript' => 'CONCAT(SUBSTRING(JSON_UNQUOTE(JSON_EXTRACT(description, "$.data.content")), 1, 340), IF(LENGTH(JSON_UNQUOTE(JSON_EXTRACT(description, "$.data.content"))) > 340, "...", ""))', 'date' => "DATE_FORMAT(date, '%d.%m.%Y %H:%i')"])->orderBy('date DESC')->all();
		
        return $this->render('investors', ['ads' => $adverstments, 'lake' => $dataLake]);
    }
    public function actionInvestor($id){
		$this->layout = 'modalPage';
		
		$findQuery = [
			'id',
			'type',
			'title',
			'region',
			'timeActivity'
		];
		
		$contentQuery = [
			':id' => $id
		];
		
		$dataLake = Investors::find()->select($findQuery)->where(['id' => $id])->one();
		$contentData = Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(description, "$.data.content")) as "description", JSON_UNQUOTE(JSON_EXTRACT(contactData, "$.user")) as "user", JSON_UNQUOTE(JSON_EXTRACT(contactData, "$.phone")) as "phone", JSON_UNQUOTE(JSON_EXTRACT(contactData, "$.mail")) as "mail" FROM investors WHERE id=:id')->bindValues($contentQuery)->queryOne();
		return $this->render('investor', ['lake' => $dataLake, 'content' => $contentData]);
	}
    public function actionExperts()
    {
		$this->view->registerCssFile('/js/lib/modalLoading/modal-loading-animate.css');
		$this->view->registerJsFile('/js/lib/modalLoading/modal-loading.js', ['position' => View::POS_HEAD]);
		
		$this->view->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css");
		$this->view->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js", ['position' => View::POS_BEGIN]);
		
        $this->view->registerCssFile('/css/experts.css');
        $this->view->registerJsFile('/js/experts.js', ['position' => View::POS_END]);

        $basicResponse = [
            'list' => Expert::find()->select(['id', 'created', 'titleImage' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].titleImage"))', 'name' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].name"))', 'specialization' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].specialization"))', 'slogan' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][1].slogan"))', 'workExperience' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].workExperience"))', 'regulator' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].regulator"))', 'isFreeAppreal' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][2].isFreeAppreal"))', 'attachments' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][0].attachments"))', 'raiting' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].raiting"))'])->where(['isModerate' => TRUE])->orderBy('created DESC')->asArray()->all(),
            'expertsCount' => Expert::find()->where(['isModerate' => TRUE])->count(),
        ];
        
        $dataLake = [
			'theme' => Expert::find()->select(['title' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$.service[*].svc"))'])->where(['isModerate' => TRUE])->distinct()->all(),
			'cost' => Expert::find()->select(['cost' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$.amounts[*][0]"))'])->where(['isModerate' => TRUE])->distinct()->all(),
			'region' => Expert::find()->select(['region' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].region"))'])->where(['isModerate' => TRUE])->distinct()->all(),
			'type' => Expert::find()->select(['type' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].specialization"))'])->where(['isModerate' => TRUE])->distinct()->all(),
			'regulation' => Expert::find()->select(['regulator' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].regulator"))'])->where(['isModerate' => TRUE])->distinct()->all()
        ];

        return $this->render('experts', ['response' => $basicResponse, 'lake' => $dataLake]);
    }

    public function actionExpertsView($expertId)
    {
        $this->view->registerCssFile('/css/experts/view.css');
        $this->view->registerJsFile('/js/experts/view.js', ['position' => View::POS_END]);
		
		$currentExpert = [':id' => $expertId];
		
        $queryPage = [
			'person' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(person, "$.name")) as "name", JSON_UNQUOTE(JSON_EXTRACT(person, "$.specialization")) as "specialization", JSON_UNQUOTE(JSON_EXTRACT(person, "$.experience")) as "workExperience", JSON_UNQUOTE(JSON_EXTRACT(contact, "$.regulator")) as "regulator", JSON_UNQUOTE(JSON_EXTRACT(person, "$.titleImage")) as "titleImage", JSON_UNQUOTE(JSON_EXTRACT(person, "$.raiting")) as "raiting" FROM experts WHERE id=:id AND isModerate=true')->bindValues($currentExpert)->queryOne(),
			'content' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content, "$.attachments")) as "attachments", JSON_UNQUOTE(JSON_EXTRACT(content, "$.amounts")) as "amounts", JSON_UNQUOTE(JSON_EXTRACT(inform, "$.about")) as "about", JSON_UNQUOTE(JSON_EXTRACT(inform, "$.specHistory")) as "specialization" FROM experts WHERE id=:id AND isModerate=true')->bindValues($currentExpert)->queryOne(),
			'inform' => Yii::$app->db->createCommand('SELECT  JSON_UNQUOTE(JSON_EXTRACT(inform, "$.slogan")) as "slogan", JSON_UNQUOTE(JSON_EXTRACT(person, "$.legalState")) as "legalState", JSON_UNQUOTE(JSON_EXTRACT(content, "$.price")) as "price" FROM experts WHERE id=:id AND isModerate=true')->bindValues($currentExpert)->queryOne(),
			'contact' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(contact, "$.region")) as "region", JSON_UNQUOTE(JSON_EXTRACT(inform, "$.isFreeAppreal")) as "isFreeAppreal" FROM experts WHERE id=:id AND isModerate=true')->bindValues($currentExpert)->queryOne()
        ];

        if (!$queryPage) {
            Yii::$app->response->statusCode = 404;

            return $this->redirect(['objects/experts']);
        }

        $contentStructure = [
            'person' => $queryPage['person'],
            'info' => [
                $queryPage['content'],
                $queryPage['inform'],
                $queryPage['contact'],
            ]
        ];

        return $this->render('expert', ['structureResponse' => $contentStructure]);
    }

    public function actionObjectservice($type)
    {
		$serviceResponse = array();
		
		if($type == 'get'){
			if(isset($_GET['svcQuery'])){
				$osq = Json::decode($_GET['svcQuery'], true);
			}
			else if(isset($_GET['sheet'])){
				if($_GET['sheet'] == 'attribute'){ $sheetResponse = ObjectAttribute::find()->select('name')->all(); }
				
				$serviceResponse = $sheetResponse;
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

    public function actionExpertsservice($type)
    {
		$serviceResponse = array();
		
		if($type == 'get'){
			if(isset($_GET['svcQuery'])){
				$esq = Json::decode($_GET['svcQuery'], true);
				
				if(isset($_GET['service'])){
					if($_GET['service'] == 'find'){
						$findQuery = ['isModerate' => TRUE];
						
						if($esq['theme']){ $findQuery[] = ['JSON_EXTRACT(inform, "$.service[*].svc")' => $esq['theme']]; }
						if($esq['cost']){ $findQuery[] = ['JSON_EXTRACT(inform, "$.amounts[*][0]"))' => $esq['cost']]; }
						if($esq['region']){ $findQuery[] = ['JSON_EXTRACT(person, "$[*].region")' => $esq['region']]; }
						if($esq['type']){ $findQuery[] = ['JSON_EXTRACT(person, "$[*].specialization")' => $esq['type']]; }
						
						if($esq['isFreeAppreal']){ $findQuery[] = ['JSON_EXTRACT(inform, "$.isFreeAppreal")' => $esq['isFreeAppreal']]; }
						
						
						$getResponse = Expert::find()->select(['id', 'created', 'titleImage' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].titleImage"))', 'name' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].name"))', 'specialization' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].specialization"))', 'slogan' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][1].slogan"))', 'workExperience' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].workExperience"))', 'regulator' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].regulator"))', 'isFreeAppreal' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][2].isFreeAppreal"))', 'attachments' => 'JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][0].attachments"))', 'raiting' => 'JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].raiting"))'])->where($findQuery)->orderBy('created DESC')->all();
					}
				}
			
				$serviceResponse = $getResponse;
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else if($type == 'post'){
			if(isset($_POST['svcQuery'])){
				$esq = Json::decode($_POST['svcQuery'], true);
				$ex = new Expert();
				
				if($esq['service'] == 'newExpert'){
					$query = $esq['parameters'];
					
					$ex->created = date('Y-m-d');
					$ex->person = $query['person'];
					$ex->inform = $query['content']['i'];
					$ex->content = $query['content']['m'];
					$ex->contact = $query['content']['c'];
					$ex->isModerate = FALSE;
					
					if($ex->save(false)){ $serviceResponse[] = "New expert added success!"; }
					else{
						Yii::$app->response->statusCode = 405;
						$serviceResponse[] = 'Gateway error';
					}
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

    public function actionInvestorsservice($type)
    {
		$serviceResponse = array();
		
		if($type == 'get'){
			if(isset($_POST['svcQuery'])){
				$isq = Json::decode($_POST['svcQuery'], true);
				$adversting = Investors::find();
				
				if(isset($_GET['service'])){
					if($_GET['service'] == 'find'){
						$findQuery = [];
						
						if(isset($isq['type'])){
							if($isq['type'] != 'all'){ $findQuery['type'] = $isq['type']; }
						}
						
						if(isset($isq['region'])){
							$findQuery['region'] = $isq['region'];
						}
						
						if(isset($isq['activityFrom']) && isset($isq['activityTo'])){
							$findQuery['date'] = $isq['activityFrom'];
							$findQuery['timeActivity'] = $isq['activityTo'];
						}
						else if(isset($isq['activityFrom']) || isset($isq['activityTo'])){
							if(isset($isq['activityTo'])){ $findQuery['timeActivity'] = $isq['activityTo']; }
							else{ $findQuery['date'] = $isq['activityFrom']; }
						}
						
						
						$getResponse = $findQuery ? $adversting->select(['id', 'title', 'description' => "CONCAT(SUBSTRING(JSON_UNQUOTE(JSON_EXTRACT(description, '$.data.content')), 1, 340), IF(LENGTH(JSON_UNQUOTE(JSON_EXTRACT(description, '$.data.content'))) > 340, '...', ''))", 'date' => "DATE_FORMAT(date, '%m.%d.%Y %H:%i')"])->where($findQuery)->orderBy('date DESC')->all() : $adversting->select(['id', 'title', 'description' => "CONCAT(SUBSTRING(JSON_UNQUOTE(JSON_EXTRACT(description, '$.data.content')), 1, 340), IF(LENGTH(JSON_UNQUOTE(JSON_EXTRACT(description, '$.data.content'))) > 340, '...', ''))", 'date' => "DATE_FORMAT(date, '%m.%d.%Y %H:%i')"])->orderBy('date DESC')->all();
					}
				}
			
				$serviceResponse = $getResponse;
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else if($type == 'post'){
			if(isset($_POST['svcQuery'])){
				$isq = Json::decode($_POST['svcQuery'], true);
				
				$meta    = $isq['header'];
				$content = $isq['body'];
				$contact = $isq['footer'];
				
				if(isset($_GET['service'])){
					if($_GET['service'] == 'send'){
						
						if(isset($_GET['subService'])){
							if($_GET['subService'] == 'search'){
								$query = [
									'type' => 'search',
									'content' => $content
								];
							}
							else if($_GET['subService'] == 'offer'){
								$query = [
									'type' => 'offers',
									'content' => $content
								];
							}
							
							$newAdversting = new Investors();
							
							$newAdversting->title = $meta['title'];
							$newAdversting->type = $query['type'];
							$newAdversting->date = date('Y-m-d H:i:s');
							$newAdversting->timeActivity = $contact['activity'];
							$newAdversting->region = $meta['country'];
							$newAdversting->description = $query['content'];
							$newAdversting->contactData = $contact['data'];
							
							if($newAdversting->save(false)){ $postResponse = 'Send success'; }
							else{
								Yii::$app->response->statusCode = 405;
								$postResponse = 'Gateway error';
							}
						}
					}
				}
			
				$serviceResponse = $postResponse;
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
