<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Investors extends ActiveRecord{
	public function rules(){
		return [
			[['id','date','type','description','timeActivity','region','contactData'],'required']
		];
	}
	public static function tableName(){ return 'investors'; }
}
?>
