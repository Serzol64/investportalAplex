<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ObjectsData extends ActiveRecord{
	public function behaviors(){
		return [
			[
				'class' => JsonBehavior::class,
				'property' => 'content'
			]
		];
	}
	public function rules(){
		return [
			[['id', 'category', 'title', 'content'],'required']];
	}
	public static function tableName(){ return 'objectData'; }
}
?>
