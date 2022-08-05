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
		
		$this->id = (int) $this->id;
	}
    public function run(){
		$queryContent = [];
		$queryData = Event::findOne(['id' => $this->id]);
		
		preg_match_all('#<table[^>]*>(\X*?)</table>#', $queryData->content, $program);
		$queryContent['programData'] = [];
		
		for($i = 0; $i < count($program[1]); $i++){
			preg_match_all('#<tr[^>]*>(\X*?)</tr>#', $program[$i][0], $datagrid);
			
			for($j = 0; $j < count($datagrid); $j++){
				$feedList = [];
				preg_match_all('#<td[^>]*>(\X*?)</td>#', $datagrid[$j][0], $programResponse);
				
				for($k = 0; $k < count($datagrid); $k++){
					
					preg_match_all('#<td[^>]*>(\X*?)</td>#', $datagrid[$k][0], $queryFragment);
					
					if($programResponse[0][0] == $queryFragment[0][0]){
						$feedList[] = [
							'period' => $queryFragment[0][0],
							'title' => $queryFragment[1][0],
							'content' => $queryFragment[2][0] ? $queryFragment[0][0] : NULL
						];
					}
				}
				
				
				$queryContent['programData'][] = [
					'program' => [
						'date' => $programResponse[0][0],
						'feed' => $feedList
					]
				];
			}
		}
		
		
		return $this->render('eventPage/data', ['eventTable' => array_unique($queryContent)]);
	}
}
?>
