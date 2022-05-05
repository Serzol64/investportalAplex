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
			file_get_contents('../web/df/regions.json')
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
}
?>
