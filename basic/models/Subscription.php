<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Subscription extends ActiveRecord{
	public function rules(){
		return [
			[['login','attribute'],'required']];
	}
	public static function primaryKey(){ return ['login']; }
	public static function tableName(){ return 'userSubscriptions'; }
}
?>
