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
		
		
		
		
		return $this->render('eventPage/list', ['eventTable' => $readyDatasheet, 'currentEvent' => $this->id]);
	}
}
?>
