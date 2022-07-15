<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title =  $contentStructure['person']['name'] . '('. $contentStructure['person']['specialization'] .') :: Experts';

?>
<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/experts-feed']); ?>">Experts</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/experts-view']); ?>">Expert page</a>
        </section>
        <section class="section" id="expertPage">
			<header id="expert-head">
				<div>
					<img src="<?php echo $contentStructure['person']['titleImage']; ?>" />
					<button id="add-but">Make an appointment for a consultation</button>
				</div>
				<div>
					<h2><?php echo $contentStructure['person']['name']; ?></h2>
					<span><?php echo $contentStructure['person']['specialization']; ?></span>
					<h4><?php echo $contentStructure['info'][1]['slogan']; ?></h4>
				</div>
				<div>
					<ul>
						<li data-field="0">Work experience: <strong><?php echo $contentStructure['person']['workExperience']; ?> y.o.</strong></li>
						<?php if($contentStructure['person']['regulator']){ ?><li data-field="1">Is a member of the SRO: <strong><?php echo $contentStructure['person']['regulator']; ?></strong></li><?php } ?>
						<?php if($contentStructure['info'][2]['isFreeAppreal']){ ?><li data-field="2">The introductory appeal is free!</li><?php } ?>
						<?php if($contentStructure['info'][0]['attachments']){ ?><li data-field="3">Works with attachments: <strong><?php echo $contentStructure['info'][0]['attachments']; ?></strong></li><?php } ?>
						<?php if($contentStructure['person']['raiting'] == 5){ ?><li data-field="4">High raiting</li><?php } ?>
					</ul>
				</div>
				<div></div>
			</header>
			<footer id="expert-body">
				<ul>
					<li>
						<h2>About me</h2>
						<div data-format="aboutContent">
							<?php echo Html::decode($contentStructure['info'][0]['about']); ?>

							<ul>
								<li>Work experience: <i><?php echo $contentStructure['person']['workExperience']; ?> y.o.</i></li>
								<li>Legal status: <i><?php echo $contentStructure['info'][1]['legalState']; ?></i></li>
								<li>Region: <i><?php echo $contentStructure['info'][2]['region']; ?></i></li>
							</ul>
						</div>
					</li>
					<li>
						<h2>Investment amounts</h2>
						<div data-format="list[info]">
							<span>The amount of investments I work with:</span>
							
							<ul><?php for($i = 0; $i < count($contentStructure['info'][0]['amounts']); $i++){ echo Html::tag('li', '- '. $contentStructure['info'][0]['amounts'][$i][0] . ' from ' . $contentStructure['info'][0]['amounts'][$i][1]); ?></ul>
						</div>
					</li>
					<li>
						<h2>Specialization</h2>
						<div data-format="list[]">
							<ul><?php for($i = 0; $i < count($contentStructure['info'][0]['specialization']); $i++){ echo Html::tag('li', '- '. $contentStructure['info'][0]['specialization'][$i]); ?></ul>
						</div>
					</li>
					<li>
						<h2>Services and prices</h2>
						<div data-format="priceList">
							<ul>
						<?php for($i = 0; $i < count($contentStructure['info'][1]['price']); $i++){ ?>
								<li>
									<header><?php echo $contentStructure['info'][1]['price'][$i]['svc']; ?></header>
									<main><?php echo $contentStructure['info'][1]['price'][$i]['price']; ?></main>
									<footer><?php echo $contentStructure['info'][1]['price'][$i]['description']; ?></footer>
								</li>
						<?php } ?>
							</ul>
						</div>
					</li>
				</ul>
			</header>
        </section>
 </main>
