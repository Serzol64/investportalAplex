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

		$this->codesDB = new Parser('../web/df/curCodes.csv');
		$this->currency = new CurrencyApi(getenv('CurrencyAPI_Investportal'));
		$this->geoIp = (new Client)->createRequest()->setMethod('GET')->setData(['fields' => 'currency'])->setUrl('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'])->send();
	}
	public function execute($query){
		if($query['type'] == 'list'){ $response = $this->listCurrency(); }
		else if($query['type'] == 'currency'){ $response = $this->covert($query['response']); }
		else{ $response = NULL; }
		
		return $response;
	}
	private function listCurrency(){
		$clientCurrency = $this->geoIp->data['currency'];
		
		$response = [];
		
		foreach($this->codesDB->all() as $data){
			$response[] = [
				'name' => $data->currency,
				'currency' => $data->alphabeticcode,
				'selected' => $clientCurrency == $data->alphabeticcode ? 'Yes' : 'No'
			];
		}
		
		return $response;
	}
	private function convert($query){
		return $this->currency->latest([
			'base_currency' => 'USD',
			'currencies' => $query['myCur'],
		]);
	}
	
}
?>
