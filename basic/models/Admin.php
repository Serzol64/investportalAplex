<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Admin extends ActiveRecord{
	
	public function rules(){
		return [
			[['login','password','firstname','surname','email','role','country'],'required']];
	}
	public static function tableName(){ return 'portalAdmins'; }
}
?>
