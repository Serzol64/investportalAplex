<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use app\models\User;

class Forgot extends Component{
	public $signQuery;
	
	public function init(){
		parent::init();
		$this->signQuery = [];
	}

	public function proccess($signQuery = null){
		if($signQuery != null){
			$this->signQuery = $signQuery;
		}

		$login = $this->signQuery['portalId'];
		$newPass = sha1($this->signQuery['password']);
		
		if(User::updateAll(['password' => $newPass], ['phone' => $login])){ return ['c' => 200, 'm' => 'Access restore success!']; }
		else{ return ['c' => 409, 'm' => 'The portal accounting service is temporarily unavailable! Try again later;-(']; }
	}
}

?>
