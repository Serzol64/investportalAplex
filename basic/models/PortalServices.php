<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class PortalServices extends ActiveRecord{
	public function rules(){
		return [
			[['id', 'title'],'required']];
	}
	public static function primaryKey(){ return ['id']; }
	public static function tableName(){ return 'investmentsOffer'; }
}
?>
