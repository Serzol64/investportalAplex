<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord{
	public function rules(){
		return [
			[['login','password','firstname','surname','email','phone','country'],'required']];
	}
	public static function tableName(){ return 'users'; }
}
?>
