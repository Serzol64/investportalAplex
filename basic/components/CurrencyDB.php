<?php
namespace app\components;

use Yii;
use yii\base\Component;
use JamesGordo\CSV\Parser;
use yii\helpers\Json;
use HouseOfApis\CurrencyApi\CurrencyApi;

class CurrencyDB extends Component{
	public $countryDF;

	public function init(){
		parent::init();

		$this->codesDB = new Parser('../web/df/countries.csv');
		$this->currency = new CurrencyApi(getenv('CurrencyAPI_Investportal'));
	}
	public function execute(){
		
	}
	protected function _list($query){
		
	}
	protected function _convert($query){
		
	}
	
}
?>
