<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use app\models\User;


class SignIn extends Component{
	public $signQuery;
	
	public function init(){
		parent::init();

		$this->signQuery = [];
	}

	public function proccess($signQuery = null){
		if($signQuery != null){ $this->signQuery = $signQuery; }

		$model = User::find();
		
		$vLogin = '';
		$vPhone = '';
		$vMail = '';
		$vPass = '';

		
		$login = $this->signQuery['portalId'];
		$pass = sha1($this->signQuery['password']);

		foreach($model->all() as $authData){
			$vLogin = $authData->login;
			$vPhone = $authData->phone;
			$vMail = $authData->email;
			$vPass = $authData->password;

			if(($vLogin == $login || $vPhone == $login || $vMail == $login) && $vPass == $pass){
				$auth = setcookie('portalId', $vLogin, strtotime("+1 year"), "/"); 

				if($auth){ return ['c' => 200, 'm' => 'Authorization success!']; }
				else{ return ['c' => 409, 'm' => 'The portal accounting service is temporarily unavailable! Try again later;-(']; }
			}
			else{
				$validError = [];

				if(!$vLogin == $login || !$vPhone == $login || !$vMail == $login){ array_push($validError, ['validError' => 'The login you entered no exists']); }
				if(!$vPass == $pass){ array_push($validError, ['validError' => 'The password you entered exists']); }
				return ['c' => 400, 'm' => $validError];
			}
		}
	}
}

?>
