<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$mid = 1;

for($i = 0; $i < count($program); $i++){
	if($eventTable->find('table > tbody tr', $i)->children(2)){
?>
		<div id="ev<?php echo $mid; ?>" class="modal">
			<div data-modalpart="header"><h3>Program Part Time Description</h3></div>
			<div data-modalpart="content"><?php echo Html::decode($eventTable->find('table > tbody tr', $i)->children(2)->outertext); ?></div>
		</div>
<?php
		$mid++;
	}
}
?>

