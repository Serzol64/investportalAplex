<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Expert extends ActiveRecord{
	public $title;
	public $cost;
	public $region;
	public $type;
	
	public function rules(){
		return [
			[['id', 'person', 'content', 'inform', 'contact', 'isModerate'],'required']];
	}
	public static function tableName(){ return 'experts'; }
}
?>
