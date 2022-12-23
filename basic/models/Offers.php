<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Offers extends ActiveRecord{
	public $title;
	public $category;
	
	public function rules(){
		return [
			[['id', 'login', 'query', 'offer', 'status', 'isMail'],'required']];
	}
	public static function tableName(){ return 'investmentsOffer'; }
}
?>
