<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\web\View;
use yii\helpers\Json;

use simplehtmldom\HtmlWeb;

use app\models\Event;

class EventProgramModal extends Widget{
    public $id;
	public $connector;
	
    public function init() {
		parent::init();
		
		$this->connector = Event::findOne(['id' => $this->id]);
	}
    public function run(){
		$queryContent = (new HtmlWeb)->load($this->connector->content);
		return $this->render('eventPage/data', ['eventTable' => $queryContent]);
	}
}
?>
