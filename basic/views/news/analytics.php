<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Analytics";
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/analytics-feed']); ?>">Analytics</a>
        </section>
        <section class="section" id="analytics">
			<div id="analytics-page">
				<header>
					<h2 class="tematic-title">Tematics</h2>
					<ul class="tematic"><?php foreach($afp['categories'] as $sheet){ if($sheet->category) { ?><li><?php echo $sheet->category; ?></li><?php } } ?></ul>
				</header>
				<main>
					<div class="news-feed">
						<footer>
							<div id="down-feed">
								<div class="down-feed-cont"><div id="cont-content"><ul><?php foreach($afp['last'] as $feed){ ?><li><img src="<?php echo $feed->titleImage; ?>" /><?php echo Html::a($feed->title, ['news/analytics-view', 'contentId' => $feed->id]); ?></li><?php } ?></ul></div></div>
								<div class="down-feed-cont"><div id="cont-content"><ul><?php foreach($afp['preLast'] as $feed){ ?><li><img src="<?php echo $feed->titleImage; ?>" /><?php echo Html::a($feed->title, ['news/analytics-view', 'contentId' => $feed->id]); ?></li><?php } ?></ul></div></div>
								<div class="down-feed-cont"><div id="cont-content"><ul><?php foreach($afp['old'] as $feed){ ?><li><img src="<?php echo $feed->titleImage; ?>" /><?php echo Html::a($feed->title, ['news/analytics-view', 'contentId' => $feed->id]); ?></li><?php } ?></ul></div></div>
							</div>
						</footer>
					</div>
				</main>
			</div>
        </section>
  </main>
