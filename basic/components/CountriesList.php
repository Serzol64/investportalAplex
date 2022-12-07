<?php
namespace app\components;

use Yii;
use yii\base\Component;
use JamesGordo\CSV\Parser;
use yii\helpers\Json;

class CountriesList extends Component{
	public $countryDF;

	public function init(){
		parent::init();

		$this->countryDF = [
			new Parser('../web/df/countries.csv'),
			file_get_contents('../web/df/regions.json'),
			new Parser('../web/df/world-cities.csv')
		];
	}
	public function getFullDataFrame(){
		$response = [];
		
		foreach($this->countryDF[0]->all() as $data){
			$response[] = [
				'code' => $data->alpha2,
				'title' => $data->name
			];
		}
		
		return $response;
	}
	public function listRegion($query){
		$response = [];
		$regId = 0;
		
		$cities = Json::decode($this->countryDF[1], true);
		for($i = 0; $i < count($cities); $i++){
			if($query == $cities[$i]['country']){
				$response[] = [
					'id' => $regId,
					'region' => $cities[$i]['region']
				];
				$regId++;
			}
		}
		
		return $response;
	}
	public function listAllRegions(){
		$response = [];
		$regId = 0;
		
		$cities = Json::decode($this->countryDF[1], true);
		for($i = 0; $i < count($cities); $i++){
				$response[] = [
					'id' => $regId,
					'region' => $cities[$i]['region']
				];
				$regId++;
		}
		
		return $response;
	}
	public function listCities(){
		$response = [];
		$regId = 0;
		
		foreach($this->countryDF[2]->all() as $cities){
				$response[] = [
					'id' => $regId,
					'country' => $cities->country,
					'region' => $cities->subcountry,
					'city' => $cities->name
				];
				$regId++;
		}
		
		return $response;
	}
	public function listCitiesOfCountry($q){
		$response = [];
		$regId = 0;
		
		foreach($this->countryDF[2]->all() as $cities){
			if($q == $cities->country){
				$response[] = [
					'id' => $regId,
					'country' => $cities->country,
					'region' => $cities->subcountry,
					'city' => $cities->name
				];
				$regId++;
			}
		}
		
		return $response;
	}
}
?>
