<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use app\models\User;

class autoSignIn extends Component{
	public $signQuery;
	
	public function init(){
		parent::init();
		$this->signQuery = [];
	}

	public function proccess($signQuery = null){
		if($signQuery != null){ $this->signQuery = $signQuery; }

		$model = User::find();
		$login = $this->signQuery['portalId'];
		$isValid = FALSE;
		$auth = NULL;
		
		foreach($model->all() as $authData){
			$vLogin = $authData->login;
			$vPhone = $authData->phone;
			$vMail = $authData->email;
			
			if($vLogin == $login || $vMail == $login || $vPhone == $login){ 
				$auth = setcookie('portalId', $vLogin, strtotime("+ 1 year"), "/");
				
				if($auth){ return ['c' => 200, 'm' => 'First authorization success!']; }
				else{ return ['c' => 409, 'm' => 'The portal accounting service is temporarily unavailable! Try again later;-(']; }
			}
		}
	}
}
?>
