<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Expert extends ActiveRecord{
	public function rules(){
		return [
			[['id', 'person', 'content', 'inform', 'contact'],'required']];
	}
	public static function tableName(){ return 'experts'; }
}
?>
