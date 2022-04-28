<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Offers extends ActiveRecord{
	public function rules(){
		return [
			[['id', 'login', 'objectId', 'offer', 'status'],'required']];
	}
	public static function tableName(){ return 'investmentsOffer'; }
}
?>
