<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\web\NotFoundHttpException;
use yii\db\Query;
use yii\httpclient\Client;
use app\models\UserService;
use app\models\SenderCode;

class SMSCode extends Component{
	public $service;
	public $code;
	public $phone;

	public function init(){
		parent::init();

		$this->service = 'SignUp';
		$this->code = 1234;
		$this->phone = '79198298765';
	}
	public function sendCode($service = '', $phone = ''){
		if($service != '' && $phone != ''){
			$this->service = $service;
			$this->code = rand(1000,9999);
			$this->phone = $phone;
		}

		$sms = new SenderCode();
		$message = "";

		switch($this->service){
			case 'Forgot': $message = " - Restore your account access code"; break;
			default: $message = " - Your account registration confirm code"; break;
		}

		$to = $this->phone;
		$content = $this->code . $message;

		$sms->phone = $this->phone;
		$sms->code = $this->code;
		$sms->service = $this->service;
		
		
		$smsQuery = [
			'api_id' => getenv('SMSRu_Investportal'),
			'to' => $to,
			'msg' => $content
		];

		$smsStorage = $sms->save();
		(new Client)->createRequest()->setMethod('GET')->setUrl('https://sms.ru/sms/send')->setData($smsQuery)->send();
		
		if($smsStorage){ return ['c' => 200, 'm' => 'SMS code send success!'];}
		else{ return ['c' => 409, 'm' => 'The portal accounting service is temporarily unavailable! Try again later;-(']; }

		
		
	}
	public function validCode($service = '', $phone = '', $code = null){
		if($service != '' && $phone != '' && $code != null){
			$this->service = $service;
			$this->phone = $phone;
			$this->code = $code;
		}

		$sms = SenderCode::find();
		$validCode = $sms->where(['code' => $this->code])->all();
		$deleteCode = (new Query)->createCommand()->delete('senderCodes', ['phone' => $this->phone])->execute();

		foreach($validCode as $data){
			if($this->code === $data->code){
				if($deleteCode){ return ['c' => 200, 'm' => 'SMS code is valid!'];}
				else{ return ['c' => 409, 'm' => 'The portal accounting service is temporarily unavailable! Try again later;-(']; }
			}
			else{ return ['c' => 500, 'm' => 'The code is entered incorrectly and check it carefully, please!']; }
		}

		

		
	}
}
?>
