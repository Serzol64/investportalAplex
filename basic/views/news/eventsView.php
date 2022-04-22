<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

use app\widgets\EventProgram;
use app\widgets\EventProgramModal;

$this->title = $curEvent->title . ":: Events";
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/events-feed']); ?>">Events</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/event', ['contentId' => $contentId]]); ?>" class="active"><?php echo $curEvent->title; ?></a>
        </section>
        <section class="section" id="news">
			<?php echo Html::hiddenInput('eventData', $contentId); ?>
            <div class="news-viewer">
                <div id="left-content">
                    <header>
                        <h2>April abstracts. Commercial real estate</h2>
                        <section class="public-date">
                            <img src="https://img.icons8.com/fluent-systems-regular/24/0079bf/clock--v1.png" alt="Дата публикации" id="clock" />
                            <i><?php echo <?php echo date('d/m/Y', strtotime($curEvent->sprint)); ?>, <?php echo $curEvent->location; ?></i>
                        </section>
                    </header>
                    <main>
                        <section class="title-image"><img src="<?php echo $curEvent->titleImage; ?>" alt="Title Image"></section>
                        <section class="news-content">
							<?php 
							echo Html::decode($curEvent->content); 
							echo EventProgram::widget(['id' => $contentId]);
							
							foreach($curEvent->modals as $progf){ echo EventProgramModal::widget(['id' => $contentId, 'programField' => $progf->programResponse]); }
							?>
						</section>
                    </main>
                    <footer>
                        <section class="share">
                            <strong>Share this event</strong>
                            <ul>
                                <li data-channel="facebook"><i class="fab fa-facebook-f" style="color: gray;"></i></li>
                                <li data-channel="youtube"><i class="fab fa-youtube" style="color: gray;"></i></li>
                                <li data-channel="instagram"><i class="fab fa-instagram" style="color: gray;"></i></li>
                                <li data-channel="telegram"><i class="fab fa-telegram" style="color: gray;"></i></li>
                            </ul>
                        </section>
                        <section class="realted">
                            <strong>Realted events</strong>
                            <ul>
                                <li><a href="">Re: Location - offices, co-working spaces, flexible offices</a></li>
                                <li><a href="">Redevelopment: a new story</a></li>
                                <li><a href="">Moscow International Property Show 2022 - international exhibition of foreign real estate</a></li>
                            </ul>
                        </section>
                    </footer>
                </div>
                <div id="right-content">
                    <div class="realted-news">
                    </div>
                </div>
            </div>
        </section>

    </main>
