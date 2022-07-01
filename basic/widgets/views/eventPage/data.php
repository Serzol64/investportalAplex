<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<?php for($i = 0; $i < count($eventData); $i++){ ?><div id="ev<?php echo $eventData[$i]['id']; ?>" class="modal"><div data-modalpart="header"><h3>Program Part Time Description</h3></div><div data-modalpart="content"><?php echo Html::decode($eventData[$i]['content']); ?></div></div><?php } ?>

