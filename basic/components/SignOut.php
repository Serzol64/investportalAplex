<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

class SignOut extends Component{
	public function init(){ parent::init(); }

	public function proccess(){
		$out = unset($_COOKIE['portalId']);
		
		if($out){ return ['c' => 200, 'm' => 'Sign account out success!']; }
		else{ 
			return ['c' => 409, 'm' => 'The portal accounting service is temporarily unavailable! Try again later;-(']; 
		}
	}

}
?>
