<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$mid = 1;

$table = (array) $eventTable['programData'];


for($j = 0; $j < count($table); $j++){
	if($table[$j]['program']){
		$program = $table[$j]['feed'];
		for($i = 0; $i < count($program); $i++){
			if($program[$i]['content']){
?>
		<div id="ev<?php echo $mid; ?>" class="modal">
			<div data-modalpart="header"><h3>Program Part Time Description</h3></div>
			<div data-modalpart="content"><?php echo Html::decode($program[$i]['content']); ?></div>
		</div>
<?php
			$mid++;
			}
		}
	}
}
?>

