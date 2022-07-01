<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\web\View;
use yii\helpers\Json;

use app\models\Event;

class EventProgram extends Widget{
    public $id;

    public function init() {
		parent::init();
		
		$this->id = Event::findOne(['id' => $this->id]);
	}
    public function run(){
		$readyDatasheet = [];
		
		$responseData = Json::decode($this->id->content, true);
		$k = 0;
		for($i = 0; $i < count($responseData['primeTime']); $i++){
			$readyDatasheet[] = [
				'date' => $responseData['primeTime'][$i]['date'],
				'time' => $responseData['primeTime'][$i]['time'],
				'title' => $responseData['primeTime'][$i]['title'],
				'moreInfo' => $isMoreInfo ? 'ev'. $k : FALSE
			];
			
			$k++;
		}
		
		
		
		return $this->render('eventPage/list', ['eventTable' => $readyDatasheet, 'currentEvent' => $this->id]);
	}
}
?>
