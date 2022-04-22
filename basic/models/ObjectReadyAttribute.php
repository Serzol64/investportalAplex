<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ObjectReadyAttribute extends ActiveRecord{
	
	public function rules(){
		return [
			[['name'],'required']
		];
	}
	public static function tableName(){ return 'objectdata_readyAttributes'; }
}
?>
