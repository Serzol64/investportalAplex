<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;



$this->title = $curA->title . " :: Analytics";
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/analytics-feed']); ?>">Analytics</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/analytics-view', ['contentId' => $contentId]]); ?>"><?php echo $curA->title; ?></a>
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
							
							preg_match_all('#<h3[^>]*>(\X*?)</h3>#', $curA->content, $part);
							preg_match_all('#<div[^>]*>(\X*?)</div>#', $curA->content, $content);
						?>
                            <p class="bookmark">Content</p>
                            <p></p>
                            <ul id="content-list"><?php for($i = 0; $i < count($part); $i++){ echo Html::tag('li', Html::a(htmlspecialchars_decode($part[1][$i]), '#' . htmlspecialchars_decode($part[1][$i]))); } ?></ul>
                            <p></p>
                            <hr>
                        <?php for($i = 0; $i < count($content); $i++){ ?>
                            <a name="<?php echo htmlspecialchars_decode($part[1][$i]); ?>"><p class="bookmark"><?php echo htmlspecialchars_decode($part[1][$i]); ?></p></a>
                            <?php echo htmlspecialchars_decode($content[1][$i]); ?>
                         <?php } ?>
                        </section>
                    </main>
                    <footer>
                        <section class="share">
                            <strong>Share this article</strong>
							<ul>
                                <li data-channel="facebook" onClick='window.open("https://www.facebook.com/sharer.php?u=<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-facebook-f" style="color: gray;"></i></li>
                                <li data-channel="telegram" style="margin-left: 40%;" style="margin-left: 40%;" onClick='window.open("https://telegram.me/share/url?url=<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-telegram" style="color: gray;"></i></li>
                            </ul>
                        </section>
                        <?php if(is_array($realted) || is_object($realted)){ ?><section class="realted"><strong>Realted events</strong><ul><?php foreach($realted as $key => $value){ echo Html::tag('li', Html::a($value[2], ['news/event', 'contentId' => $value[1]])); } ?></ul></section><?php } ?>
                    </footer>
                </div>
            </div>
        </section>
</main>
