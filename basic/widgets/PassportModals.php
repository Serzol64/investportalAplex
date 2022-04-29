<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\web\View;
use yii\helpers\Html;

use app\models\ObjectAttribute;


class PassportModals extends Widget{
    public $query;

    public function init() {
		parent::init();
		
		if($this->query === 'offer'){ $this->query = 'b'; }
		else if($this->query === 'request'){ $this->query = 'a'; }
		else{ $this->query = NULL; }
	}
    public function run(){
		
		switch($this->query){
			case 'a': 
				$regionCont = [
					[0,4],
					[5, 5+4],
					[10, 5+9],
					[11, 3*5],
					[16, 5*4],
					[21, 5*5],
					[26, 5*6],
					[31, 5*7],
					[36, 5*8],
					[41, 5*9],
					[46, 5*10],
					[51, 5*11],
					[56, 6*10],
					[61, 65],
					[66, 7*10],
					[71, 75],
					[76, 8*10],
					[81,85],
					[86, 9*10],
					[91, 95],
					[96, 100],
					[101, 105],
					[106, 22*5],
					[111, 23*5],
					[116, 120],
					[121, 125],
					[126, 65*2],
					[131, 68*2],
					[136, 140],
					[141, 145],
					[146, 75*2],
					[151, 155],
					[156, 160],
					[161, 165],
					[166, 170],
					[171, 175],
					[176, 90*2],
					[181, 185],
					[186, 95*2],
					[191, 192]
				];
				return $this->render('passportModalServices/requests', ['region' => $regionCont, 'datasets' => [ObjectAttribute::find()->all()]]);
			break;
			case 'b': 
				$regionContDouble = [
					[0,4],
					[5, 5+4],
					[10, 5+9],
					[11, 3*5],
					[16, 5*4],
					[21, 5*5],
					[26, 5*6],
					[31, 5*7],
					[36, 5*8],
					[41, 5*9],
					[46, 5*10],
					[51, 5*11],
					[56, 6*10],
					[61, 65],
					[66, 7*10],
					[71, 75],
					[76, 8*10],
					[81,85],
					[86, 9*10],
					[91, 95],
					[96, 100],
					[101, 105],
					[106, 22*5],
					[111, 23*5],
					[116, 120],
					[121, 125],
					[126, 65*2],
					[131, 68*2],
					[136, 140],
					[141, 145],
					[146, 75*2],
					[151, 155],
					[156, 160],
					[161, 165],
					[166, 170],
					[171, 175],
					[176, 90*2],
					[181, 185],
					[186, 95*2],
					[191, 192]
				];
				return $this->render('passportModalServices/offers', ['region' => $regionContDouble, 'datasets' => [ObjectAttribute::find()->all()]]);
			break;
			default: return $this->render('passportModalServices/main'); break;
		}
	}
}
?>
