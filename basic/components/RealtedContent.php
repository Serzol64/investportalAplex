<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Json;

use PHPHtmlParser\Dom;

use app\models\News;
use app\models\Event;


class RealtedContent extends Component{
	public $connector;
	public $stopwordDB;
	
	public function init(){
		parent::init();
		
		$this->stopwordDB = file_get_contents('../web/df/stop_words.json');
		$this->connector = [
			News::find(),
			Event::find()
		];
	}
	public function topList($svc, $q){
		$listResponse = [];
		
		if($svc == 'news'){
			$sth = News::findOne(['id' => $q]);
			$text = $this->get_minification_array($sth->title . ' ' . $sth->content);
			$sth = $this->connector[0]->all();
		}
		else if($svc == 'events'){
			$sth = Event::findOne(['id' => $q]);
			$text = $this->get_minification_array($sth->title . ' ' . $sth->content);
			$sth = $this->connector[1]->all();
		}
		
		$count = count($text);
		
		foreach($sth as $row) {
			$verifiable = $this->get_minification_array($row->title . ' ' . $svc == 'analytics' ? $row->content : $svc == 'events' ? $row->content : $row->content);
		 
			$similar_counter = 0;
			foreach ($text as $text_row) {
				foreach ($verifiable as $verifiable_row){
					if($text_row == $verifiable_row) {
						$similar_counter++;
						break;
					}
				}
			}
			$listResponse[] = [$similar_counter * 100 / $count, $row->id, $row->title];
		}
		 
		arsort($listResponse);
		
		$listResponse = array_slice($listResponse, 1, 3, true);
		
		return $listResponse;
	}
	public function get_minification_array($text){
		$text = stripslashes($text);	
		
		$text = html_entity_decode($text);
		$text = htmlspecialchars_decode($text, ENT_QUOTES);	
		
		$text = strip_tags($text);
		
		$text = mb_strtolower($text);	
		
		$text = mb_eregi_replace("[^a-z0-9 ]", ' ', $text);
		
		$text = mb_ereg_replace('[ ]+', ' ', $text);
		
		$words = explode(' ', $text);
		
		$words = array_unique($words);
	 
		$array = Json::decode($this->stopwordDB, true);
	 
		$words = array_diff($words, $array);
		$words = array_diff($words, ['']);	
	 
		return $words;
	}
}
?>
