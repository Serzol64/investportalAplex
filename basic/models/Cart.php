<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord{
	public function rules(){
		return [
			[['id', 'category', 'operationId', 'login'],'required']];
	}
	public static function tableName(){ return 'cartDB'; }
}
?>
