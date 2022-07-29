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
            <div id="events-header">
				<form id="events-search" href="#">
					<h2>Events filter search</h2>
					<section class="content">
						<select id="require" name="eventRegion">
							<option>Location</option>
							<?php foreach($ep as $df){ echo Html::tag('option', $df->location, ['value' => $df->location]); } ?>
						</select>
						<select id="require" name="eventType">
							<option>Type</option>
							<?php foreach($ep as $df){ echo Html::tag('option', $df->type, ['value' => $df->type]); } ?>
						</select>
						<select id="require" name="eventCategory">
							<option>Tematic</option>
							<?php foreach($ep as $df){ echo Html::tag('option', $df->tematic, ['value' => $df->tematic]); } ?>
						</select>
					</section>
					<section class="footer">
						<ul id="period">
							<li><input type="text" data-pm="from" placeholder="From period" onfocus="(this.type='date')" /></li>
							<li><input type="text" data-pm="to" placeholder="To period" onfocus="(this.type='date')" /></li>
						</ul>
					</section>
				</form>
			</div>
			<div id="events-body">
				<section class="events-feed" data-time="coming">
					<header id="title">Coming events</header>
					<main>
						<ul class="slider">
						<?php foreach($eventsList[0] as $events){ ?>
							<li>
							  <span id="date"><?php echo $events->date_to ? date('d/m/Y', strtotime($events->date_from)) . ' - ' . date('d/m/Y', strtotime($events->date_to)) : date('d/m/Y', strtotime($events->date_from)); ?></span>
							  <img src="<?php echo $events->titleImage; ?>" alt="<?php echo $events->title; ?>" />
							  <span id="title"><?php echo $events->title; ?></span>
							  <p>
								<?php if($events->location != ''){ ?><span data-type="location"><?php echo $events->location; ?></span><?php } ?>
								<span data-type="description">
									<?php
										preg_match_all('#<p[^>]*>(\X*?)</p>#', $events->content, $description);
										echo $description[0];
									?>
								</span>
							  </p>
							  <?php echo Html::a('Learn more', ['news/event', 'contentId' => $events->id]); ?>
							</li>
						<?php } ?>
						  </ul>
					</main>
				</section>
			</div>
			<div id="events-footer">
				<section class="events-feed" data-time="exited">
					<header id="title">Exited events</header>
					<main>
						  <ul class="slider">
						<?php foreach($eventsList[1] as $events){ ?>
							<li>
							  <span id="date"><?php echo $events->date_to ? date('d/m/Y', strtotime($events->date_from)) . ' - ' . date('d/m/Y', strtotime($events->date_to)) : date('d/m/Y', strtotime($events->date_from)); ?></span>
							  <img src="<?php echo $events->titleImage; ?>" alt="<?php echo $events->title; ?>" />
							  <span id="title"><?php echo $events->title; ?></span>
							  <p>
								<?php if($events->location != ''){ ?><span data-type="location"><?php echo $events->location; ?></span><?php } ?>
								<span data-type="description">
									<?php
										preg_match_all('#<p[^>]*>(\X*?)</p>#', $events->content, $description);
										echo $description[0];
									?>
								</span>
							  </p>
							  <?php echo Html::a('Learn more', ['news/event', 'contentId' => $events->id]); ?>
							</li>
						<?php } ?>
						  </ul>
					</main>
				</section>
			</div>
    </section>      
</main>
