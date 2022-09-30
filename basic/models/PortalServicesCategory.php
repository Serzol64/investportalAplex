<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class PortalServicesCategory extends ActiveRecord{
	public function rules(){
		return [
			[['id', 'name', 'icon'],'required']];
	}
	public static function primaryKey(){ return ['id']; }
	public static function tableName(){ return 'servicesCategory'; }
}
?>
