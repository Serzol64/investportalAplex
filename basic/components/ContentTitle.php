<?php
namespace app\components;

use Yii;
use yii\base\Component;

use app\models\News;
use app\models\Event;
use app\models\Analytic;

class ContentTitle extends Component{
	public function init(){
		parent::init();
	}
	public function send($svc, $q){
		$response = ['Operation success', 200];
		
		switch($svc){
			case 'news':
				if($q['operation'] == 'send'){
					if($q['isTitlePhoto']){
						$uploadProccess = $this->uploadPhoto($q['photoData']);
						
						if($uploadProccess == 'Upload fail'){ 
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
				}
				else if($q['operation'] == 'show'){
					if($q['isTitlePhoto']){
						
					}
					else if($q['isMeta']){ $response[0] = $this->MetaSend($q['news']); }
				}
				else if($q['operation'] == 'update'){
					if($q['isTitlePhoto']){
						$uploadProccess = $this->uploadPhoto($q['photoData']);
						
						if($uploadProccess == 'Upload fail'){ 
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
				}
				else if($q['operation'] == 'delete'){
					if($q['isTitlePhoto']){
						$deleteTitle = unlink('../web' .  $q['data']);
						
						if(!$deleteTitle){ 
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
				}
			break;
			case 'analytics':
				if($q['operation'] == 'send'){}
				else if($q['operation'] == 'show'){}
				else if($q['operation'] == 'update'){}
				else if($q['operation'] == 'delete'){}
			break;
			case 'events':
				if($q['operation'] == 'send'){}
				else if($q['operation'] == 'show'){}
				else if($q['operation'] == 'update'){}
				else if($q['operation'] == 'delete'){}
			break;
		}
		
		return $response;
	}
	public function uploadPhoto($q){
		$state = 'Upload success';
		$output = '/images/content/' . date('m-d-Y_H:i:s') . '.' . $q['ext'];
		$ifp = '../web' . $output;
		
		list($dataType, $imageData) = explode(';', $q['data']);
		list(, $encodedImageData) = explode(',', $imageData);
		$decodedImageData = base64_decode($encodedImageData);

		file_put_contents($ifp, $decodedImageData);
		
		if($q['isSVC']['send']){ $img = setcookie('titleImage', $output, strtotime("+2 minutes"), "/"); }
		else if($q['isSVC']['update']){
			$img = setcookie('titleImage_update', $output, strtotime("+1 minute"), "/");
		}
		
		if(!$img){ $state = 'Upload fail'; }
		
		
		return $state;
	}
	public function MetaSend($q){
		$dataResult = [];
		
		return $dataResult;
	}
}
?>
