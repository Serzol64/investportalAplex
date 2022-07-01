<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\web\View;
use yii\helpers\Json;

use app\models\Event;

class EventProgramModal extends Widget{
    public $id;

    public function init() {
		parent::init();
		
		$this->id = Event::findOne(['id' => $this->id]);
	}
    public function run(){
		$readyDatasheet = [];
		
		$responseData = Json::decode($this->id->content, true);
		
		for($i = 0; $i < count($responseData['primeTimeMeta']); $i++){
			$readyDatasheet[] = [
				'id' => $responseData['primeTimeMeta'][$i]['id'],
				'content' => $responseData['primeTimeMeta'][$i]['content']
			];
		}
		
		return $this->render('eventPage/data', ['eventData' => $readyDatasheet]);
	}
}
?>
