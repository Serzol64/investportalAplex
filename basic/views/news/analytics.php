<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Analytics";
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/analytics-feed']); ?>">About</a>
        </section>
        <section class="section" id="analytics">
			<div id="analytics-page">
				<header>
					<h2 class="tematic-title">Tematics</h2>
					<ul class="tematic"></ul>
				</header>
				<main>
					<div class="news-feed">
						<footer>
							<div id="down-feed">
								<div class="down-feed-cont">
									<div id="cont-content"></div>
								</div>
								<div class="down-feed-cont">
									<div id="cont-content"></div>
								</div>
								<div class="down-feed-cont">
									<div id="cont-content"></div>
								</div>
							</div>
						</footer>
					</div>
				</main>
			</div>
        </section>
  </main>
