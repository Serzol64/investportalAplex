<?php
namespace app\components;

use Yii;
use yii\base\Component;
use JamesGordo\CSV\Parser;

class CountriesList extends Component{
	public $countryDF;

	public function init(){
		parent::init();

		$this->countryDF = [
			new Parser('../web/df/countries.csv')
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
}
?>
