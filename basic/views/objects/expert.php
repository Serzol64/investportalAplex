<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

use app\widgets\ExpertList;
use app\widgets\ExpertContent;

$this->title = $curE->name . '('. $curE->specialization .') :: Experts';

$dl = [
	'sc' => JSON::decode($curE->classification),
	'sic' => JSON::decode($curE->expertContent)
];
?>
<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/experts-feed']); ?>">Experts</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/experts-view']); ?>">Expert page</a>
        </section>
        <section class="section" id="expertPage">
			<header id="expert-head">
				<div>
					<img src="<?php echo $curE->titleImage; ?>" />
					<button id="add-but">Make an appointment for a consultation</button>
				</div>
				<div>
					<h2><?php echo $curE->name; ?></h2>
					<span><?php echo $curE->specialization; ?></span>
					<h4><?php echo $curE->slogan; ?></h4>
				</div>
				<div><ul><?php foreach($ds as $dl['sc']){ echo Html::tag('li', $ds['field'] . ': <strong>' . $ds['field']['content'] . '</strong>', ['data-field' => $ds['field']['type']]); } ?></ul></div>
				<div>
					<h3>In the <?php echo $curE->rr['regulator']; ?> registry from <?php echo $curE->rr['registerDate']; ?></h3>
				</div>
			</header>
			<footer id="expert-body">
				<ul>
					<?php
					foreach($ds as $dl['sic']){
						echo "<li><h2>" . $ds['contentBlockTitle'] . "</h2>";
						
						switch($ds['contentType']){
							case 'priceList': echo ExpertList::widget(['type' => 'price', 'query' => $ds['content']]); break;
							case 'infoList': echo ExpertList::widget(['type' => 'info', 'query' => $ds['content']]); break;
							case 'sampleList': echo ExpertList::widget(['type' => 'list', 'query' => $ds['content']]); break;
							case 'about': echo ExpertContent::widget(['type' => 'about', 'query' => $ds['content']]); break;
						}
						echo "</li>";
					}
					?>
				</ul>
			</header>
        </section>
 </main>
