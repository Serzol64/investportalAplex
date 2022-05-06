<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

use app\models\News;


$this->title = 'Welcome to Investportal!';
?>
<main class="main">
	<section id="promo" class="section">
		<header>
			<div class="promo-header">
			   <hr style="position: relative; top: -12%;" width="37px" color="#0079bf" size="4" align="left">
			   <h2 style="color: #ffffff;font-size: 160%;">Investments</h2>
			   <strong style="color: #ffffff;font-size: calc(161%/2);margin-top: -35px;">objects and projects</strong>
			   <button class="add-but">Add Object</button>
			   <div class="links">
                   <a href=""><strong>Entire Offer</strong>(<?php echo $staticMeta[1]; ?>)</a>
                   <a href=""><strong>Type Object</strong>(<?php echo $staticMeta[0]; ?>)</a>
               </div>
			</div>
			<div class="marketing-info">
						<header class="banner-block">
							<img src="/images/advbanner.jpg" alt="Реклама">
						</header>
						<footer>
							<ul>
								<li>Objects &amp; Projects: <?php echo $staticCount[0]; ?></li>
								<li>Requests: <?php echo $staticCount[1]; ?></li>
								<li>Services: <?php echo $staticCount[2]; ?></li>
								<li>Users: <?php echo $staticCount[3]; ?></li>
							</ul>
						</footer>
			 </div>
		</header>
		<main class="swiper-container">
                <div class="promo-feed swiper-wrapper">
				</div>

				<div class="swiper-pagination"></div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <div class="swiper-scrollbar"></div>
		</main>
		
	</section>
	<section id="news" class="section" data-text="News">
		<header>
                <hr color="#0079bf" size="4" width="37px" align="left"/>
                <h2>News</h2>
                <a href="<?php echo Url::to(['news/index']); ?>">All news</a>
        </header>
        <main>
                <header id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
                <header id="slider-controller"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
                <main id="slider-view-adaptive">
					<?php foreach(News::find()->orderBy('created DESC')->limit(1)->all() as $firstM){ ?>
						<div class="news">
								<?php echo Html::a($firstM->title, ['news/view', 'contentId' => $firstM->id]); ?>
								<p class="descr">
								<?php 
									preg_match_all('#<p[^>]*>(\X*?)</p>#', $firstM->content, $matches);
									
									echo $matches[0];
								?>
								</p>
								<span class="date"><?php echo date('d/m/Y', strtotime($firstM->created)); ?></span>
						</div>
					<?php } foreach(News::find()->orderBy('created DESC')->limit(8)->offset(1)->all() as $allM){ ?>
						<div class="news" id="hide">
								<?php echo Html::a($allM->title, ['news/view', 'contentId' => $allM->id]); ?>
								<p class="descr">
								<?php 
									preg_match_all('#<p[^>]*>(\X*?)</p>#', $allM->content, $matches);
									
									echo $matches[0];
								?>
								</p>
								<span class="date"><?php echo date('d/m/Y', strtotime($allM->created)); ?></span>
						</div>
					<?php } ?>
                </main>
                <main id="slider-view">
					<div class="news-feed">
						<?php foreach(News::find()->orderBy('created DESC')->limit(3)->all() as $first){ ?>
							<div class="news">
								<?php echo Html::a($first->title, ['news/view', 'contentId' => $first->id]); ?>
								<p class="descr">
								<?php 
									preg_match_all('#<p[^>]*>(\X*?)</p>#', $first->content, $matches);
									
									echo $matches[0];
								?>
								</p>
								<span class="date"><?php echo date('d/m/Y', strtotime($first->created)); ?></span>
							</div>
                        <?php } ?>
                    </div>
                    <div class="news-feed" id="hide">
						<?php foreach(News::find()->orderBy('created DESC')->limit(3)->offset(3)->all() as $two){ ?>
							<div class="news">
								<?php echo Html::a($two->title, ['news/view', 'contentId' => $two->id]); ?>
								<p class="descr">
								<?php 
									preg_match_all('#<p[^>]*>(\X*?)</p>#', $two->content, $matches);
									
									echo $matches[0];
								?>
								</p>
								<span class="date"><?php echo date('d/m/Y', strtotime($two->created)); ?></span>
							</div>
                        <?php } ?>
                    </div>
                    <div class="news-feed" id="hide">
						<?php foreach(News::find()->orderBy('created DESC')->limit(3)->offset(6)->all() as $three){ ?>
							<div class="news">
								<?php echo Html::a($three->title, ['news/view', 'contentId' => $three->id]); ?>
								<p class="descr">
								<?php 
									preg_match_all('#<p[^>]*>(\X*?)</p>#', $three->content, $matches);
									
									echo $matches[0];
								?>
								</p>
								<span class="date"><?php echo date('d/m/Y', strtotime($three->created)); ?></span>
							</div>
                        <?php } ?>
                    </div>
                </main>
                <footer id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer>
                <footer id="slider-controller"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer>
	</section>
	<section id="investsearch" class="section">
			<header>
                <hr color="#0079bf" size="4" width="37px" align="left"/>
                <h2>Investors in Search...</h2>
                <button class="add-but" style="border: solid 2px gray;">Add Request</button>
                <a href=""><strong>Entire Offer</strong>(<?php echo $staticMeta[1]; ?>)</a>
            </header>
            <main class="swiper-container">
                <div class="popular-objects swiper-wrapper">
				</div>

				<div class="swiper-pagination"></div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <div class="swiper-scrollbar"></div>
			</main>
			
	</section>
	<section id="eventcalendar" data-text="Events" class="section">
			<header>
                <hr color="#0079bf" size="4" width="37px" align="left"/>
                <h2>Upcoming Events</h2>
			</header>
            <main>
			</main>
	</section>
	<section id="services" data-text="Service" class="section">
		 <header>
                <hr color="#0079bf" size="4" width="37px" align="left"/>
                <h2>Services</h2>
                <strong>& Collaborations</strong>
                <a href=""><strong>All services</strong>(<?php echo $staticCount[2]; ?>)</a>
                <button class="add-but">Add Object</button>
         </header>
         <main>
				<header id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<header id="slider-controller"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<main id="slider-view-adaptive"></main>
				<main id="slider-view"></main>
				<footer id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer>
				<footer id="slider-controller"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer> 
         </main>
                
	</section>
	<section id="analytics" data-text="Analytic" class="section">
		 <header>
                <hr color="#0079bf" size="4" width="37px" align="left"/>
                <h2>Analytics</h2>
                <a href="<?php echo Url::to(['news/analytics-feed']); ?>">All news</a>
         </header>
         <main>
				<header id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<header id="slider-controller"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<main id="slider-view-adaptive"></main>
				<main id="slider-view"></main>
				<footer id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer>
				<footer id="slider-controller"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer> 
         </main>
	</section>
	<section id="estate" data-text="Investment" class="section">
		 <header>
                <hr color="#0079bf" size="4" width="37px" align="left"/>
                <h2>Real Estate</h2>
                <strong>as Investment</strong>
                <a href="">Entire Offer</a>
                <button class="add-but">Add Object</button>
         </header>
		 <main>
				<header id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<header id="slider-controller"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<main id="slider-view-adaptive"></main>
				<main id="slider-view"></main>
				<footer id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer>
				<footer id="slider-controller"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer> 
         </main>
	</section>
	<section id="reviews" data-text="Review" class="section">
		 <header>
                <hr color="#0079bf" size="4" width="37px" align="left"/>
                <h2>Reviews</h2>
                <strong>and countries</strong>
                <a href="">All material</a>
        </header>
		<main>
				<header id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<header id="slider-controller"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
				<main id="slider-view-adaptive"></main>
				<main id="slider-view"></main>
				<footer id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer>
				<footer id="slider-controller"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer> 
        </main>
	</section>
	
</main>
