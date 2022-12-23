<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Investments extends ActiveRecord{
	public $category;
	
	public function rules(){
		return [
			[['id', 'login', 'query', 'status', 'isMail'],'required']];
	}
	public static function tableName(){ return 'investments'; }
}
?>
