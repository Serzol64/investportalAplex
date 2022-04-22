<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

class adminSignOut extends Component{
	public function init(){ parent::init(); }
	
	public function proccess(){
		
		$sessionData = Yii::$app->session;
		$response = [];
		if($sessionData->isActive){
			$svc = $this->adminControl($sessionData->destroy() && $sessionData->close());
			switch($svc['state']){
				case 0:  $response = [201, 'Success!']; break;
				default: $response = [502, 'Fail!']; break;
			}
		}
		
		return $response;
		
		
		
	}
	public function adminControl($wayData){
		$response = ['state' => 2];
		
		if($wayData){ $response['state'] = 0; }
		else{ $response['state'] = 1; }
		
		return $response;
		
	}
}

?>
