<?php
namespace app\components;

use Yii;
use yii\base\Component;
use JamesGordo\CSV\Parser;
use yii\helpers\Json;
use yii\httpclient\Client;
use linslin\yii2\curl\Curl;

class CurrencyDB extends Component{
	public $codesDB;
	public $currency;
	public $currencySymbols;
	public $geoIp;

	public function init(){
		parent::init();

		$this->codesDB = new Parser('../web/df/curCodes.csv');
		$this->currency = "https://api.currencyapi.com/v3/latest?apikey=" . getenv('CurrencyAPI_Investportal');
		$this->currencySymbols = new Parser('../web/df/currency-symbols.csv');
		$this->geoIp = (new Client)->createRequest()->setMethod('GET')->setData(['fields' => 'currency'])->setUrl('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'])->send();
	}
	public function execute($query){
		if($query['type'] == 'list'){ $response = $this->listCurrency(); }
		else if($query['type'] == 'currency'){ $response = $this->convert($query['response']); }
		else{ $response = NULL; }
		
		return $response;
	}
	public function getFullAmount($query){
		$symbol = $query['query']['cur'];
		$amount = $query['query']['amount'];
		
		if(isset($query['isSymbol'])){ foreach($this->currencySymbols->all() as $data){ if($data->_code == $symbol){ echo '\u{{ $data->_unicode-hex }} { $amount }'; } } }
		else{ echo '$symbol - $amount'; }
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
		$convertQuery = $this->currency . "&base_currency=USD&currencies=" . $query['myCur'] . "&value=" . $query['amount'];
		$convertQuery .= (new Curl)->get($convertQuery);
		
		return $convertQuery;
		
	}
	
}
?>
