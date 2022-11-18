<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\Investors;

?>
<ul>
  <li><div id="meta"><div><h1><?php echo $lake->title; ?></h1></div></div></li>
  <li>
    <div id="param">
	  <?php
	  $paramFind = [NULL, Investors::find(), NULL];
	  if($lake->type == 'search'){
		  $paramFind[0] = [
			'target' => "JSON_UNQUOTE(JSON_EXTRACT(description, \"$.parameters.target\"))",
			'purpose' => "JSON_UNQUOTE(JSON_EXTRACT(description, \"$.parameters.purpose\"))",
			'solved' => "JSON_UNQUOTE(JSON_EXTRACT(description, \"$.parameters.solved\"))",
			'competitors' => "JSON_UNQUOTE(JSON_EXTRACT(description, \"$.parameters.competitors\"))",
			'implementation' => "JSON_UNQUOTE(JSON_EXTRACT(description, \"$.parameters.implementation\"))"
		  ];
		  
		  $paramFind[2] = $paramFind[1]->select($paramFind[0])->where(['id' => $lake->id])->one();
		  
		  echo Html::tag('div', Html::tag('h4', 'What investments are required?') . Html::tag('span', $paramFind[2]->target));
		  echo Html::tag('div', Html::tag('h4', 'The purpose of existence') . Html::tag('span', $paramFind[2]->purpose));
		  echo Html::tag('div', Html::tag('h4', 'The problem being solved') . Html::tag('span', $paramFind[2]->solved));
		  echo Html::tag('div', Html::tag('h4', 'Main competitors') . Html::tag('span', $paramFind[2]->competitors));
		  echo Html::tag('div', Html::tag('h4', 'Implementation period') . Html::tag('span', $paramFind[2]->implementation));
	  }
	  else{
		  $paramFind[0] = [
			'payback' => "JSON_UNQUOTE(JSON_EXTRACT(description, \"$.parameters.payback\"))",
			'amount' => "JSON_UNQUOTE(JSON_EXTRACT(description, \"$.parameters.amount\"))"
		  ];
		  
		  $paramFind[2] = $paramFind[1]->select($paramFind[0])->where(['id' => $lake->id])->one();
		  
		  echo Html::tag('div', Html::tag('h4', 'Payback period(months)') . Html::tag('span', $paramFind[2]->payback));
		  echo Html::tag('div', Html::tag('h4', 'Investment amount') . Html::tag('span', $paramFind[2]->amount));
	  }
	  ?>
    </div>
  </li>
  <li>
    <div id="content">
      <div>
        <h3>Description</h3>
        <p><?php echo $lake->description; ?></p>
      </div>
    </div>
  </li>
  <li>
    <div id="contact">
      <div>
        <h2>Activity to</h2>
        <p><?php echo $lake->timeActivity; ?></p>
      </div>
      <div>
        <h2>Region</h2>
        <p><?php echo $lake->region; ?></p>
      </div>
      <div>
        <h2>Contact name</h2>
        <p><?php echo $lake->user; ?></p>
      </div>
      <div>
        <h2>Contact phone</h2>
        <p><a href="tel:<?php echo $lake->phone; ?>" target="_blank"><?php echo $lake->phone; ?></a></p>
      </div>
      <div>
        <h2>EMail</h2>
        <p><a href="mailto:<?php echo $lake->mail; ?>?subject=Offer%20for%20your%20ad%20on%20Investportal" target="_blank"><?php echo $lake->mail; ?></a></p>
      </div>
    </div>
  </li>
</ul>
