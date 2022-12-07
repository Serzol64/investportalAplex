<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class PortalServices extends ActiveRecord{
	public $sender;
	public $control;
	
	public function rules(){
		return [
			[['id', 'title', 'created'],'required']];
	}
	public static function primaryKey(){ return ['id']; }
	public static function tableName(){ return 'serviceList'; }
}
?>
