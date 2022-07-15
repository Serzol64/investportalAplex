<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use simplehtmldom\HtmlWeb;

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
                        <section class="news-content">
						<?php
							
							$contentQuery = (new HtmlWeb)->load($curA->content);
							
							$part = $contentQuery->find('#part');
							$content = $contentQuery->find('div#matherial');
						?>
                            <p class="bookmark">Content</p>
                            <p></p>
                            <ul id="content-list"><?php for($i = 0; $i < count($part); $i++){ echo Html::tag('li', Html::a($part[$i]->outertext, '#' . urlencode(strtolower($part[$i]->outertext)))); } ?></ul>
                            <p></p>
                            <hr>
                        <?php for($i = 0; $i < count($content); $i++){ ?>
                            <p class="bookmark" name="<?php echo urlencode(strtolower($part[$i]->outertext)); ?>"><?php echo $part[$i]->outertext; ?></p>
                            <?php echo Html::decode($content[$i]->outerHtml); ?>
                         <?php } ?>
                        </section>
                    </main>
                    <footer>
                        <section class="share">
                            <strong>Share this article</strong>
							<ul>
                                <li data-channel="facebook" onClick='window.open("https://www.facebook.com/sharer.php?u=<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-facebook-f" style="color: gray;"></i></li>
                                <li data-channel="telegram" style="margin-left: 40%;" style="margin-left: 40%;" onClick='window.open("https://telegram.me/share/url?url=А<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-telegram" style="color: gray;"></i></li>
                            </ul>
                        </section>
                    </footer>
                </div>
            </div>
        </section>
</main>
