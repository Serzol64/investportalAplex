<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;

class CloudCategorizator extends Component{
	public $serviceConnector;
	
	public function init(){
		$this->serviceConnector = (new Client)->createRequest()->setMethod('GET')->setUrl('http://clfapi.base-search.net/classify');
		
		parent::init();
	}
	public function execute($t, $q){
		$highResponse = NULL;
		
		switch($t){
			case 'news': 
				$categoryVariants = [$this->serviceConnector->setData(['text' => $q[0], 'language' => 'auto', 'format' => 'json'])->send(), $this->serviceConnector->setData(['text' => $q[1], 'language' => 'auto', 'format' => 'json'])->send()];
				
				$highResponse = $this->highAccuracy('news', $categoryVariants);
			break;
			case 'analytic': 
				$categoryVariants = [$this->serviceConnector->setData(['text' => $q[0], 'language' => 'auto', 'format' => 'json'])->send(), $this->serviceConnector->setData(['text' => $q[1], 'language' => 'auto', 'format' => 'json'])->send()];
				
				$highResponse = $this->highAccuracy('analytic', $categoryVariants);
			break;
			case 'event': 
				$categoryVariants = [$this->serviceConnector->setData(['text' => $q[0], 'language' => 'auto', 'format' => 'json'])->send(), $this->serviceConnector->setData(['text' => $q[1], 'language' => 'auto', 'format' => 'json'])->send()];
				
				$highResponse = $this->highAccuracy('event', $categoryVariants);
			break;
		}
		
		return $hignResponse;
	}
	private function highAccuracy($t, $brq){
		$highAccuracy = NULL;
		
		switch($t){
			case 'news': 
				$accuracySet = [
					'title' => [array_column($brq[0], 'confidence'), array_column($brq[0], 'heading')],
					'content' => [array_column($brq[1], 'confidence'), array_column($brq[1], 'heading')]
				];
				
				$maxLevel = [max($accuracySet['title'][0]), max($accuracySet['content'][0])];
				
				$activityOne = [0,0];
				$activityData = ['', ''];
				
				for($i = 0; $i < count($accuracySet['title'][1]); $i){ if($maxLevel[0] == $accuracySet['title'][0][$i]){ $activityOne[0] = $accuracySet['title'][0][$i]; } }
				for($i = 0; $i < count($accuracySet['content'][1]); $i){ if($maxLevel[1] == $accuracySet['content'][0][$i])){ $activityOne[1] = $accuracySet['content'][0][$i]; } }
				
				for($i = 0; $i < count($accuracySet['title'][1]); $i){ if($maxLevel[0] == $accuracySet['title'][0][$i]){ $activityData[0] = $accuracySet['title'][1][$i]; } }
				for($i = 0; $i < count($accuracySet['content'][1]); $i){ if($maxLevel[1] == $accuracySet['content'][0][$i])){ $activityData[1] = $accuracySet['content'][1][$i]; } }
				
				if($activityOne[1] > $activityOne[0]){ $highCategory = $activityData[1]; }
				else{ $highCategory = $activityData[0]; }
				
				$highAccuracy = $highCategory;
			break;
			case 'analytic': 
				$accuracySet = [
					'title' => [array_column($brq[0], 'confidence'), array_column($brq[0], 'heading')],
					'content' => [array_column($brq[1], 'confidence'), array_column($brq[1], 'heading')]
				];
				
				$maxLevel = [max($accuracySet['title'][0]), max($accuracySet['content'][0])];
				
				$activityOne = [0,0];
				$activityData = ['', ''];
				
				for($i = 0; $i < count($accuracySet['title'][1]); $i){ if($maxLevel[0] == $accuracySet['title'][0][$i]){ $activityOne[0] = $accuracySet['title'][0][$i]; } }
				for($i = 0; $i < count($accuracySet['content'][1]); $i){ if($maxLevel[1] == $accuracySet['content'][0][$i])){ $activityOne[1] = $accuracySet['content'][0][$i]; } }
				
				for($i = 0; $i < count($accuracySet['title'][1]); $i){ if($maxLevel[0] == $accuracySet['title'][0][$i]){ $activityData[0] = $accuracySet['title'][1][$i]; } }
				for($i = 0; $i < count($accuracySet['content'][1]); $i){ if($maxLevel[1] == $accuracySet['content'][0][$i])){ $activityData[1] = $accuracySet['content'][1][$i]; } }
				
				if($activityOne[1] > $activityOne[0]){ $highCategory = $activityData[1]; }
				else{ $highCategory = $activityData[0]; }
				
				$highAccuracy = $highCategory;
			break;
			case 'event': 
				$accuracySet = [];
			break;
		}
		
		return $highAccuracy;
	}
}
