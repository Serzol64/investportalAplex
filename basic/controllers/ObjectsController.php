<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\View;

use app\models\Expert;
use app\models\Investors;
use app\models\InvestorsCategory;
use app\models\ObjectAttribute;
use app\models\ObjectsData;
use app\models\User;

class ObjectsController extends Controller
{
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
                'meta' => Yii::$app->db->createCommand('SELECT id, title, CONCAT(JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.region.country")), ', ', JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.region.region"))) as "region", JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.parameters.cost[0].value")) as "cost", JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.parameters.precentable[0].value")) as "profitableness", JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.description")) as "description", JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.mediagallery.video.poster")) as "videoPoster" FROM objectData WHERE id=:object')->bindValues($objectQuery)->queryOne(),
                'parameters' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.parameters..filter")) as "filter", JSON_UNQUOTE(JSON_EXTRACT(content, "content.parameters..value")) as "value" FROM objectData WHERE id=:object')->bindValues($objectQuery)->queryAll(),
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
        $this->view->registerCssFile('/css/investors.css');
        $this->view->registerJsFile('/js/investors.js', ['position' => View::POS_END]);
		
		$this->view->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css");
		$this->view->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js", ['position' => View::POS_BEGIN]);
		
		$dataLake = [
			'category' => InvestorsCategory::find()->all(),
			'popularRegions' => Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(region, "$[*].country")) as "country", COUNT(id) as "objectsCount" FROM investors GROUP BY country ORDER BY objectsCount DESC LIMIT 4')->queryAll()
		];
		
        $adverstments = Investors::find()->all();
		
        return $this->render('investors', ['ads' => $adverstments, 'lake' => $dataLake]);
    }
    public function actionExperts()
    {
        $this->view->registerCssFile('/css/experts.css');
        $this->view->registerJsFile('/js/experts.js', ['position' => View::POS_END]);

        $basicResponse = [
            'list' => Expert::find()->select('id, created, JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].titleImage")) as "titleImage", JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].name")) as "name", JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].specialization")) as "specialization", JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][1].slogan")) as "slogan", JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].workExperience")) as "workExperience", JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].regulator")) as "regulator", JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][2].isFreeAppreal")) as "isFreeAppreal", JSON_UNQUOTE(JSON_EXTRACT(inform, "$[*][0].attachments")) as "attachments", JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].raiting")) as "raiting"')->orderBy('created DESC')->asArray()->all(),
            'expertsCount' => Expert::find()->count(),
        ];
        
        $dataLake = [
			'theme' => Expert::find()->select('JSON_UNQUOTE(JSON_EXTRACT(inform, "$.service[*].svc")) as "title"')->distinct()->all(),
			'cost' => Expert::find()->select('JSON_UNQUOTE(JSON_EXTRACT(inform, "$.amounts[*][0]")) as "cost"')->distinct()->all(),
			'region' => Expert::find()->select('JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].region")) as "region"')->distinct()->all(),
			'type' => Expert::find()->select('JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].specialization")) as "type"')->distinct()->all(),
			'regulation' => Expert::find()->select('JSON_UNQUOTE(JSON_EXTRACT(person, "$[*].regulator")) as "regulator"')->distinct()->all()
        ];

        return $this->render('experts', ['response' => $basicResponse, 'lake' => $dataLake]);
    }

    public function actionExpertsView($expertId)
    {
        $this->view->registerCssFile('/css/experts/view.css');
        $this->view->registerJsFile('/js/experts/view.js', ['position' => View::POS_END]);

        $queryPage = Expert::findOne(['id' => $expertId])->asArray();

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

    public function actionInvestorssservice($type)
    {
		$serviceResponse = array();
		
		if($type == 'get'){
			if(isset($_GET['svcQuery'])){
				$isq = Json::decode($_GET['svcQuery'], true);
			}
			else{
				Yii::$app->response->statusCode = 405;
				$serviceResponse = "Query not found!";
			}
		}
		else if($type == 'post'){
			if(isset($_POST['svcQuery'])){
				$isq = Json::decode($_POST['svcQuery'], true);
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
