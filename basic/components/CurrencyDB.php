<?php
namespace app\components;

use Yii;
use yii\base\Component;
use JamesGordo\CSV\Parser;
use yii\helpers\Json;
use yii\httpclient\Client;
use HouseOfApis\CurrencyApi\CurrencyApi;

class CurrencyDB extends Component{
	public $codesDB;
	public $currency;
	public $geoIp;

	public function init(){
		parent::init();

		$this->codesDB = new Parser('../web/df/countries.csv');
		$this->currency = new CurrencyApi(getenv('CurrencyAPI_Investportal'));
		
		if($_SERVER['REMOTE_ADDR'] != '127.0.0.1'){ $this->geoIp = (new Client)->createRequest()->setMethod('GET')->setUrl('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'])->send(); }
		else{ $this->geoIp = 'RUB'; }
	}
	public function execute($query){
		if($query['type'] == 'list'){ $response = $this->_list(); }
		else if($query['type'] == 'currency'){ $response = $this->_covert($query['response']); }
		else{ $response = NULL; }
		
		return $response;
	}
	private function _list(){
		if($_SERVER['REMOTE_ADDR'] != '127.0.0.1'){ $clientCurrency = $this->geoIp->data['currency']; }
		else{ $clientCurrency = $this->geoIp; }
		
		$response = [];
		
		foreach($this->codesDB->all() as $data){
			$response[] = [
				'name' => $data->currency,
				'currency' => $data->alphabeticcode,
				'selected' => $clientCurrency == $data->alphabeticcode ? TRUE : FALSE
			];
		}
		
		return $response;
	}
	private function _convert($query){
		return $this->currency->latest([
			'base_currency' => 'USD',
			'currencies' => $query['myCur'],
		]);
	}
	
}
?>
