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
						$uploadProccess = $this->uploadPhoto($q['photoData'], 'news');
						
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
						$uploadProccess = $this->uploadPhoto($q['photoData'], 'news');
						
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
				if($q['operation'] == 'send'){
					if($q['isTitlePhoto']){
						$uploadProccess = $this->uploadPhoto($q['photoData'], 'analytics');
						
						if($uploadProccess == 'Upload fail'){ 
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
				}
				else if($q['operation'] == 'show'){
					if($q['isTitlePhoto']){
						
					}
					else if($q['isMeta']){ $response[0] = $this->MetaSend($q['article']); }
				}
				else if($q['operation'] == 'update'){
					if($q['isTitlePhoto']){
						$uploadProccess = $this->uploadPhoto($q['photoData'], 'analytics');
						
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
			case 'events':
				if($q['operation'] == 'send'){
					if($q['isTitlePhoto']){
						$uploadProccess = $this->uploadPhoto($q['photoData'], 'events');
						
						if($uploadProccess == 'Upload fail'){ 
							$response[1] = 500;
							$response[0] = 'Operation failed';
						}
					}
				}
				else if($q['operation'] == 'show'){
					if($q['isTitlePhoto']){
						
					}
					else if($q['isMeta']){ $response[0] = $this->MetaSend($q['event']); }
				}
				else if($q['operation'] == 'update'){
					if($q['isTitlePhoto']){
						$uploadProccess = $this->uploadPhoto($q['photoData'], 'events');
						
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
		}
		
		return $response;
	}
	public function uploadPhoto($q, $service){
		$state = 'Upload success';
		
		
		if($service == 'news'){
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
		}
		else if($service == 'analytics'){
			$output = '/images/content/' . date('m-d-Y_H:i:s') . '-analytics.' . $q['ext'];
			$ifp = '../web' . $output;
			
			list($dataType, $imageData) = explode(';', $q['data']);
			list(, $encodedImageData) = explode(',', $imageData);
			$decodedImageData = base64_decode($encodedImageData);

			file_put_contents($ifp, $decodedImageData);
			
			if($q['isSVC']['send']){ $img = setcookie('titleImageAnalytics', $output, strtotime("+2 minutes"), "/"); }
			else if($q['isSVC']['update']){
				$img = setcookie('titleImageAnalytics_update', $output, strtotime("+1 minute"), "/");
			}
		}
		else if($service == 'events'){
			$output = '/images/content/' . date('m-d-Y_H:i:s') . '-events.' . $q['ext'];
			$ifp = '../web' . $output;
			
			list($dataType, $imageData) = explode(';', $q['data']);
			list(, $encodedImageData) = explode(',', $imageData);
			$decodedImageData = base64_decode($encodedImageData);

			file_put_contents($ifp, $decodedImageData);
			
			if($q['isSVC']['send']){ $img = setcookie('titleImageEvents', $output, strtotime("+2 minutes"), "/"); }
			else if($q['isSVC']['update']){
				$img = setcookie('titleImageEvents_update', $output, strtotime("+1 minute"), "/");
			}
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
