<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Events';
?>

<main class="main" style="background-color: #eff3f4;">
	 <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/events-feed']); ?>" class="active">Events</a>
     </section>
     <section class="section" id="events">
			<div id="events-body">
				<section class="events-feed">
					<main>
						<ul class="slider">
						<?php foreach($eventsList as $events){ ?>
							<li>
							  <span id="date"><?php echo $events->date_to ? date('d/m/Y', strtotime($events->date_from)) . ' - ' . date('d/m/Y', strtotime($events->date_to)) : date('d/m/Y', strtotime($events->date_from)); ?></span>
							  <img src="<?php echo $events->titleImage; ?>" alt="<?php echo $events->title; ?>" />
							  <span id="title"><?php echo $events->title; ?></span>
							  <p>
								<?php if($events->location != ''){ ?><span data-type="location"><?php echo $events->location; ?></span><?php } ?>
								<span data-type="description">
									<?php
										preg_match_all('#<p[^>]*>(\X*?)</p>#', $events->content, $description);
										echo strlen(strip_tags(htmlspecialchars_decode($description[1][0]))) > 234 ? mb_strimwidth(strip_tags(htmlspecialchars_decode($description[1][0])), 0, 234, '...') : strip_tags(htmlspecialchars_decode($description[1][0]));
									?>
								</span>
							  </p>
							  <?php echo Html::a('Learn more', ['news/event', 'contentId' => $events->id]); ?>
							</li>
						<?php } ?>
						  </ul>
						  <div class="load-screen-services list-smart-close">
						   <center>
							<img src="/images/icons/loading.gif" />
							<span>Please wait... The process of processing the search query is underway</span>
						   </center>
						  </div>
					</main>
				</section>
			</div>
    </section>      
</main>
