<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;


use app\models\Event;

$this->title = $curEvent->title . ":: Events";
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/events-feed']); ?>">Events</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/event', ['contentId' => $contentId]]); ?>" class="active"><?php echo $curEvent->title; ?></a>
        </section>
        <section class="section" id="news">
            <div class="news-viewer">
                <div id="left-content">
                    <header>
                        <h2>April abstracts. Commercial real estate</h2>
                        <section class="public-date">
                            <img src="https://img.icons8.com/fluent-systems-regular/24/0079bf/clock--v1.png" alt="Дата публикации" id="clock" />
                            <i><?php echo $curEvent->date_to ? date('d/m/Y', strtotime($curEvent->date_from)) . ' - ' . date('d/m/Y', strtotime($curEvent->date_to)) : date('d/m/Y', strtotime($curEvent->date_from)); ?>, <?php echo $curEvent->location; ?></i>
                        </section>
                    </header>
                    <main>
                        <section class="title-image"><img src="<?php echo $curEvent->titleImage; ?>" alt="Title Image"></section>
                        <section class="news-content">
							<?php 
								echo Html::decode($curEvent->content);
							?>
						</section>
                    </main>
                    <footer>
                        <section class="share">
                            <strong>Share this event</strong>
                            <ul>
                                <li data-channel="facebook" onClick='window.open("https://www.facebook.com/sharer.php?u=<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-facebook-f" style="color: gray;"></i></li>
                                <li data-channel="telegram" style="margin-left: 40%;" onClick='window.open("https://telegram.me/share/url?url=<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-telegram" style="color: gray;"></i></li>
                            </ul>
                        </section>
                       <section class="realted"><strong>Realted events</strong><ul><?php foreach($realted as $key => $value){ echo Html::tag('li', Html::a($value[2], ['news/event', 'contentId' => $value[1]])); } ?></ul></ul></section>
                    </footer>
                </div>
               <div id="right-content">
					 <div class="realted-news">
						 <?php 
								foreach($realted as $key => $value){ 
									$currentMatherial = Event::findOne(['id' => $value[1]]);
									
									echo Html::tag('div',
										Html::img($currentMatherial->titleImage, ['alt' => $currentMatherial->title, 'id' => 'header']) .
										Html::a($currentMatherial->title, ['news/event', 'contentId' => $value[1]], ['id' => 'content']), ['class' => 'realted']);
								} 
						?>
					</div>
				</div>
            </div>
        </section>

    </main>
