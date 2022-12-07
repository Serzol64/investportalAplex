<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\Investors;

?>
<ul class="viewer">
  <li><div id="meta"><div><h1><?php echo $lake->title; ?></h1></div></div></li>
  <li>
    <div id="param">
	  <?php
	  $searchBind = [
		':id' => $lake->id
	  ];
	  if($lake->type == 'search'){
		  
		  $paramFind = Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(description, "$.parameters.target")) as "target", JSON_UNQUOTE(JSON_EXTRACT(description, "$.parameters.purpose")) as "purpose", JSON_UNQUOTE(JSON_EXTRACT(description, "$.parameters.solved")) as "solved", JSON_UNQUOTE(JSON_EXTRACT(description, "$.parameters.competitors")) as "competitors", JSON_UNQUOTE(JSON_EXTRACT(description, "$.parameters.implementation")) as "implementation" FROM investors WHERE id=:id')->bindValues($searchBind)->queryOne();
		  
		  echo Html::tag('div', Html::tag('h4', 'What investments are required?') . Html::tag('span', $paramFind['target']));
		  echo Html::tag('div', Html::tag('h4', 'The purpose of existence') . Html::tag('span', $paramFind['purpose']));
		  echo Html::tag('div', Html::tag('h4', 'The problem being solved') . Html::tag('span', $paramFind['solved']));
		  echo Html::tag('div', Html::tag('h4', 'Main competitors') . Html::tag('span', $paramFind['competitors']));
		  echo Html::tag('div', Html::tag('h4', 'Implementation period') . Html::tag('span', $paramFind['implementation']));
	  }
	  else{
		  
		  $paramFind = Yii::$app->db->createCommand('SELECT JSON_UNQUOTE(JSON_EXTRACT(description, "$.parameters.payback")) as "payback", JSON_UNQUOTE(JSON_EXTRACT(description, "$.parameters.amount")) as "amount" FROM investors WHERE id=:id')->bindValues($searchBind)->queryOne();
		  
		  echo Html::tag('div', Html::tag('h4', 'Payback period(months)') . Html::tag('span', $paramFind['payback']));
		  echo Html::tag('div', Html::tag('h4', 'Investment amount') . Html::tag('span', $paramFind['amount']));
	  }
	  ?>
    </div>
  </li>
  <li>
    <div id="content">
      <div>
        <h3>Description</h3>
        <p><?php echo $content['description']; ?></p>
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
        <p>
			<?php
				$countriesList = Yii::$app->regionDB->getFullDataFrame();
				for($i = 0; $i < count($countriesList); $i++){ 
					$curC = $countriesList[$i];
					if($curC['code'] == $lake->region){ echo $curC['title']; }
				}
			?>
		</p>
      </div>
      <div>
        <h2>Contact name</h2>
        <p><?php echo $content['user']; ?></p>
      </div>
      <div>
        <h2>Contact phone</h2>
        <p><a href="tel:<?php echo $content['phone']; ?>" target="_blank"><?php echo $content['phone']; ?></a></p>
      </div>
      <div>
        <h2>EMail</h2>
        <p><a href="mailto:<?php echo $content['mail']; ?>?subject=Offer%20for%20your%20ad%20on%20Investportal" target="_blank"><?php echo $content['mail']; ?></a></p>
      </div>
    </div>
  </li>
</ul>
