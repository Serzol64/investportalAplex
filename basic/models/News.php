<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class News extends ActiveRecord{
	
	public function rules(){
		return [
			[['id','titleImage','title','created','content'],'required']
		];
	}
	public static function primaryKey(){ return['id', 'category']; }
	public static function tableName(){ return 'newsData'; }
}
?>
