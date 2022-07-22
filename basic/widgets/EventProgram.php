<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\web\View;
use yii\helpers\Json;

use voku\helper\HtmlMin;
use simplehtmldom\HtmlWeb;

use app\models\Event;

class EventProgram extends Widget{
    public $id;
    public $connector;

    public function init() {
		parent::init();
		
		$this->connector = Event::findOne(['id' => $this->id]);
	}
    public function run(){
		$queryContent = (new HtmlWeb)->load('<html><body>' . (new HtmlMin)->minify($this->connector->content) . '</body></html>');
		
		return $this->render('eventPage/list', ['eventTable' => $queryContent, 'eventId' => $this->id]);
	}
}
?>
