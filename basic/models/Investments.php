<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Investments extends ActiveRecord{
	public function rules(){
		return [
			[['id', 'login', 'objectId', 'status'],'required']];
	}
	public static function tableName(){ return 'investments'; }
}
?>
