<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $curA->title . " :: Analytics";
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/analytics-feed']); ?>">About</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/analytics-view', ['contentId' => $contentId]]); ?>"><?php echo $curA->title; ?></a>
        </section>
        <section class="section" id="news">
            <div class="news-viewer">
                <div id="left-content">
                    <header>
                        <h2><?php echo $curA->title; ?></h2>
						<section class="public-date">
								<img src="https://img.icons8.com/fluent-systems-regular/24/0079bf/clock--v1.png" alt="Дата публикации" id="clock" />
								<i><?php echo date('d/m/Y', strtotime($curA->created)); ?></i>
						</section>
                    </header>
                    <main>
					    <section class="title-image"><img src="<?php echo $curA->titleImage; ?>" alt="Title Image"></section>
                        <section class="news-content"><?php echo Html::decode($curA->content); ?></section>
                    </main>
                    <footer>
                        <section class="share">
                            <strong>Share this article</strong>
                            <ul>
                                <li data-channel="facebook"><i class="fab fa-facebook-f" style="color: gray;"></i></li>
                                <li data-channel="youtube"><i class="fab fa-youtube" style="color: gray;"></i></li>
                                <li data-channel="instagram"><i class="fab fa-instagram" style="color: gray;"></i></li>
                                <li data-channel="telegram"><i class="fab fa-telegram" style="color: gray;"></i></li>
                            </ul>
                        </section>
                        <section class="realted">
                        </section>
                    </footer>
                </div>
            </div>
        </section>
</main>
