<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Event extends ActiveRecord{
	
	public function rules(){
		return [
			[['id','titleImage','title','content'],'required']
		];
	}
	public static function tableName(){ return 'newsData_events'; }
}
?>
