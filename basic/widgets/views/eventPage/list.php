<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<div id="eventProgram">
	<?php 
		$allDates = array_unique($eventTable[]['date']);
		
		for($k = 0; $k < count($allDates); $k++){ 
			$dateList = new DateTime($allDates[$i]);
	?>
		<span data-type="day"><?php echo $dateList->format('j F \, l'); ?></span>						
		<ul data-type="todo">
			<?php
				for($i = 0; $i < count($eventTable); $i++){
					if($allDates[$k] == $eventTable[$i]['moreInfo']){
						$currentTitle = $eventTable[$i]['title'];
						$currentTime = $eventTable[$i]['time'];
						
						if(!$eventTable[$i]['moreInfo']){
							echo Html::tag('li',
								Html::tag('span', $currentTime) .
								Html::tag('span', $currentTitle));
						}
						else{
							echo Html::tag('li',
								Html::tag('span', $currentTime) .
								Html::tag('span', $currentTitle).
								Html::a(Html::img('data:image/png;base64,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'), $eventTable[$i]['moreInfo'], ['class' => 'moreInfo', 'rel' => 'modal:open']));
						}
					}
				}
			?>		
		</ul>
	<?php } ?>
	<button data-type="incoming" data-eventid="<?php echo $currentEvent; ?>" class="add-but">Registration in organizator web site</button>
</div>
