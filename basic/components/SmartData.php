<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

use app\models\ObjectAttribute;
use app\models\Cart;
use app\models\Investments;
use app\models\ObjectsData;
use app\models\Offers;

use jcobhams\NewsApi\NewsApi;


class SmartData extends Component{
	public $newsFeed;
	
	public function init(){
		parent::init();
		$this->newsFeed = new NewsApi('e63e9d769ca1465e8d8777971c194ea1');
	}
	private function forecast($input, $type){
		$result = 0;
		
		if($type == 'popularObject'){
			$a = $input['id'];
			$b = $input['parameter'][0];
			$c = $input['parameter'][1];
			$d = $input['parameter'][2];
			$e = $input['parameter'][3];
			
			if($b <= 3){ $b=4; }
			if($c <= 3){ $c=4; }
			if($d <= 3){ $d=4; }
			if($e <= 3){ $e=4; }
			
			$aInSquare = ($a * 5) * ($a * 5);
			$inSquares = ($b * $b) + ($c * $c) + ($d * $d) + ($e * $e);
			
			$fInSquare = $inSquares + $aInSquare;
			$f = sqrt($fInSquare);
			
			$result = (int) round($f / ($e + $d + $c + $b));
			
			if($result > ($b + $c + $d + $e) / 5){ $result = (int) round(($b + $c + $d + $e) / 5); }
		}
		else if($type == 'offeringsObject'){
			$a = $input['id'];
			$b = $input['parameter'][0];
			$c = $input['parameter'][1];
			$d = $input['parameter'][2];
			
			if($b <= 2){ $b=3; }
			if($c <= 2){ $c=3; }
			if($d <= 2){ $d=3; }
			
			$aInSquare = ($a * 4) * ($a * 4);
			$inSquares = ($b * $b) + ($c * $c) + ($d * $d);
			
			$eInSquare = $inSquares + $aInSquare;
			$e = sqrt($eInSquare);
			
			$result = (int) round($e / ($d + $c + $b));
			
			if($result > ($b + $c + $d + $e) / 4){ $result = (int) round(($b + $c + $d + $e) / 4); }
		}
		
		return $result;
	}
	public function getList($type, $index){
		$dataResponse = [];
		
		if($type == 'reviews'){
			$lastMatherial = [
				$this->newsFeed->getEverything('estate', NULL, NULL, NULL, NULL, NULL, 'en', NULL, 3, 1),
				$this->newsFeed->getEverything('estate', NULL, NULL, NULL, NULL, NULL, 'en', NULL, 3, 2),
				$this->newsFeed->getEverything('estate', NULL, NULL, NULL, NULL, NULL, 'en', NULL, 3, 3),
				$this->newsFeed->getEverything('estate', NULL, NULL, NULL, NULL, NULL, 'en', NULL, 9, 1)
			];
			
			$dataResponse = $lastMatherial[$index];
		}
		else if(strrpos($type,'object')){
			if(strrpos($type,'popular')){
				$fastList = round(ObjectsData::find()->count() / 4);
				$lastObjects = [
					'generator' => ObjectsData::find()->select('id, title, category')->orderBy('id DESC')->limit($fastList)->all(),
					'response' => [
						[]
					]
				];
				
				foreach($lastObjects['generator'] as $currentObject){
					$contentData = [
						[
							Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content,"$.meta.mediagallery.photo.data[0].file")) as "photo", JSON_UNQUOTE(JSON_EXTRACT(content,"$.content.parameters.cost[0].value")) as "cost" FROM objectData WHERE id=:obj')->bindValues([':obj' => $currentObject->id])->queryOne(),
							Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content,"$.meta.region.country")) as "country" FROM objectData WHERE id=:obj')->bindValues([':obj' => $currentObject->id])->queryOne()
						],
						[
							function(){
								$categoryId = ObjectsData::findOne(['id' => $currentObject->id])->select('category');
								$objectsCurrentCategoriyCount = ObjectsData::find(['category' => $categoryId])->count();
								
								return $objectsCurrentCategoryCount;
							},
							function(){
								$regionId = Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content,"$.meta.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(content,"$.meta.region.region")) as "region" FROM objectData WHERE id=:obj')->bindValues([':obj' => $currentObject->id])->queryOne();
								$objectsCurrentRegionCount = Yii::$app->db->createCommand('SELECT COUNT(id) as "count" FROM objectData WHERE JSON_EXTRACT(content,"$.meta.region.country") = :country, JSON_EXTRACT(content,"$.meta.region.region") = :region')->bindValues([':country' => $regionId['country'], ':region' => $regionId['region']])->queryOne();
								
								return $objectsCurrentRegionCount['count'];
							},
							function(){
								$objectsCurrentInvestmentsCount = Investments::find(['objectId' => $currentObject->id, 'status' => 0])->count();
								return $objectsCurrentInvestmentsCount;
							},
							function(){
								$objectsCurrentOffersCount = Offers::find(['objectId' => $currentObject->id, 'status' => 0])->count() + (Cart::find(['operationId' => $currentObject->id])->count() + Cart::find(['category' => $currentObject->category])->count());
								return $objectsCurrentOffersCount;
							}
						]
					];
					$forecastQuery = [
						'id' => $currentObject->id,
						'parameter' => [$contentData[1][0], $contentData[1][1], $contentData[1][2], $contentData[1][3]]
					];
					
					$forecast = $this->forecast($forecastQuery, 'popularObject');
					
					$lastObjects['response'][0][] = [
						'id' => $currentObject->id,
						'title' => $currentObject->title,
						'cat' => $currentObject->category,
						'content' => [
							'titlePhoto' => $contentData[0][0]['photo'],
							'country' => $contentData[0][1]['country'],
							'cost' => $contentData[0][0]['cost']
						],
						'raiting' => $forecast
					];
				}
				
				$dataResponse = $lastObjects['response'][$index];
			}
			else if(strrpos($type,'investors')){
				$fastList = round(ObjectAttribute::find()->count() / 13);
				$last = [
					'generator' => ObjectAttribute::find()->limit($fastList)->all(),
					'response' => [
						[]
					]
				];
				
				foreach($last['generator'][0] as $currentAttribute){
					
					$lastObject = Yii::$app->db->createCommand('SELECT id, JSON_UNQUOTE(JSON_EXTRACT(content,"$.meta.mediagallery.photo.data[0].file")) as "photo" FROM objectData WHERE category=:category LIMIT 1 ORDER BY id DESC')->bindValues([':category' => $currentAttribute->name])->queryOne();
					$countries = Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.region.country")) as "countries", COUNT(id) as "objectsCount", GROUP_CONCAT(countries SEPARATOR ', ') as "regions" FROM objectData WHERE category=:category LIMIT 3 ORDER BY objectsCount DESC')->bindValues([':category' => $currentAttribute->name])->queryOne();
					
					$recommendCost = Yii::$app->db->createCommand('SELECT MIN(JSON_EXTRACT(content,"$.content.parameters.cost[0].value")) as "min", MAX(JSON_EXTRACT(content,"$.content.parameters.cost[0].value")) as "max" FROM objectData WHERE category=:category')->bindValues([':category' => $currentAttribute->name])->queryOne();
					$recommendCost = $recommendCost['min'] == $recommendCost['max'] ? '&dollar; ' . $recommendCost['max'] : '&dollar; ' . $recommendCost['min'] . ' - &dollar; ' . $recommendCost['max'];
					
					
					$last['response'][0][] = [
						'id' => $lastObject['id'],
						'title' => $currentAttribute->name,
						'titlePhoto' => $lastObject['photo'],
						'regions' => $countries['regions'],
						'cost' => $recommendCost
					];
				}
				
				$dataResponse = $last['response'][$index];
			}
			else if(strrpos($type,'estates')){
				$offersObjects = [
					'generator' => [
						ObjectsData::find()->select('id, title')->orderBy('id DESC')->limit(3)->all(),
						ObjectsData::find()->select('id, title')->orderBy('id DESC')->limit(6)->offset(3)->all(),
						ObjectsData::find()->select('id, title')->orderBy('id DESC')->limit(9)->offset(6)->all(),
						ObjectsData::find()->select('id, title')->orderBy('id DESC')->limit(9)->all()
					],
					'response' => [
						[],
						[],
						[],
						[]
					]
				];
				
				for($i = 0; $i < count($offersObjects['generator']); $i++){
					foreach($offersObjects['generator'][$i] as $currentObject){
						$contentData = [
							[
								Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content,"$.meta.mediagallery.photo.data[0].file")) as "photo", JSON_UNQUOTE(JSON_EXTRACT(content,"$.content.parameters.cost[0].value")) as "cost" FROM objectData WHERE id=:obj')->bindValues([':obj' => $currentObject->id])->queryOne(),
								Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(content,"$.meta.region.country")) as "country" FROM objectData WHERE id=:obj')->bindValues([':obj' => $currentObject->id])->queryOne()
							],
							[
								function(){
									$categoryId = ObjectsData::findOne(['id' => $currentObject->id])->select('category');
									$objectsCurrentCategoryCount = ObjectsData::find(['category' => $categoryId])->count();
									
									return $objectsCurrentCategoryCount;
								},
								function(){
									$objectsCurrentInvestmentsCount = Investments::find(['objectId' => $currentObject->id, 'status' => 0])->count();
									return $objectsCurrentInvestmentsCount;
								},
								function(){
									$objectsCurrentOffersCount = Offers::find(['objectId' => $currentObject->id, 'status' => 0])->count() + (Cart::find(['operationId' => $currentObject->id])->count() + Cart::find(['category' => $currentObject->category])->count());
									return $objectsCurrentOffersCount;
								}
							]
						];
						$forecastQuery = [
							'id' => $currentObject->id,
							'parameter' => [$contentData[1][0], $contentData[1][1], $contentData[1][2]]
						];
						
						$forecast = $this->forecast($forecastQuery, 'offeringsObject');
						
						$lastObjects['response'][$i][] = [
							'id' => $currentObject->id,
							'title' => $currentObject->title,
							'content' => [
								'titlePhoto' => $contentData[0][0]['photo'],
								'country' => $contentData[0][1]['country'],
								'cost' => $contentData[0][0]['cost']
							],
							'raiting' => $forecast
						];
					}
				}
				
				$dataResponse = $offersObjects['response'][$index];
			}
		}
		
		return $dataResponse;
	}
}

?>
