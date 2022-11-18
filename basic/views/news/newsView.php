<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

use app\models\News;

$this->title = $curNews->title . " :: News";
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/index']); ?>">News</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/view', ['contentId' => $contentId]]); ?>" class="active"><?php echo $curNews->title; ?></a>
        </section>
        <section class="section" id="news">
            <div class="news-viewer">
                <div id="left-content">
                    <header>
                        <h2><?php echo $curNews->title; ?></h2>
						<section class="public-date">
								<img src="https://img.icons8.com/fluent-systems-regular/24/0079bf/clock--v1.png" alt="Дата публикации" id="clock" />
								<i><?php echo date('d/m/Y', strtotime($curNews->created)); ?></i>
						</section>
                    </header>
                    <main>
					    <section class="title-image"><img src="<?php echo $curNews->titleImage; ?>" alt="Title Image"></section>
                        <section class="news-content"><?php echo Html::decode($curNews->content); ?></section>
                    </main>
                    <footer>
						 <section class="share">
                            <strong>Share this story</strong>
                            <ul>
                                <li data-channel="facebook" onClick='window.open("https://www.facebook.com/sharer.php?u=<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-facebook-f" style="color: gray;"></i></li>
                                <li data-channel="telegram" style="margin-left: 40%;" onClick='window.open("https://telegram.me/share/url?url=<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>","sharer","status=0,toolbar=0,width=650,height=500");'><i class="fab fa-telegram" style="color: gray;"></i></li>
                            </ul>
                        </section>
                        <?php if(is_array($realted) || is_object($realted)){ ?><section class="realted"><strong>Realted news</strong><ul><?php foreach($realted as $key => $value){ echo Html::tag('li', Html::a($value[2], ['news/view', 'contentId' => $value[1]])); } ?></ul></ul></section><?php } ?>
                    </footer>
                 </div>
                 <div id="right-content">
			<?php if(is_array($realted) || is_object($realted)){ ?>
					 <div class="realted-news">
						 <?php 
								foreach($realted as $key => $value){ 
									$currentMatherial = News::findOne(['id' => $value[1]]);
									preg_match_all('#<p[^>]*>(\X*?)</p>#', $currentMatherial->content, $matches);
									
									echo Html::tag('div',
										Html::img($currentMatherial->titleImage, ['alt' => $currentMatherial->title, 'id' => 'header']) .
										Html::a($currentMatherial->title, ['news/view', 'contentId' => $value[1]], ['id' => 'content']) .
										Html::tag('span', strlen(strip_tags(htmlspecialchars_decode($matches[1][0]))) > 234 ? mb_strimwidth(strip_tags(htmlspecialchars_decode($matches[1][0])), 0, 234, '...') : strip_tags(htmlspecialchars_decode($matches[1][0])), ['id' => 'footer']) . Html::tag('span', date('d/m/Y', strtotime($currentMatherial->created)), ['id' => 'date']), ['class' => 'realted']);
								} 
						?>
					</div>
		  <?php } ?>
				</div>
             </div>
        </section>
</main>
               
