<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ObjectsData extends ActiveRecord{
	public function rules(){
		return [
			[['id', 'category', 'title', 'content', 'creator'],'required']];
	}
	public static function tableName(){ return 'objectData'; }
}
?>
