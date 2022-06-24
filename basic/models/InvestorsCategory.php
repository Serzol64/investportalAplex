<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class InvestorsCategory extends ActiveRecord{
	
	public function rules(){
		return [
			[['id','name'],'required']
		];
	}
	public static function tableName(){ return 'investorsCategory'; }
}
?>
