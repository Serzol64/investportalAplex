<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class SenderCode extends ActiveRecord{
	public function rules(){
		return [
			[['phone','code','service'],'required']];
	}
	public static function tableName(){ return 'senderCodes'; }
}
?>
