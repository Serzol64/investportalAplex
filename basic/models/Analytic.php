<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Analytic extends ActiveRecord{
	
	public function rules(){
		return [
			[['id','titleImage','title','created','content'],'required']
		];
	}
	public static function tableName(){ return 'newsData_analytics'; }
}
?>
