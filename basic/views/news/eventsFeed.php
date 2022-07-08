<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

use PHPHtmlParser\Dom;

$this->title = 'News';
?>

<main class="main" style="background-color: #eff3f4;">
	 <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/events-feed']); ?>" class="active">Events</a>
     </section>
     <section class="section" id="events">
            <div id="events-header">
				<form id="events-search" href="#">
					<h2>Events filter search</h2>
					<section class="header">
						<ul id="noRequire">
							<li>
								<input type="checkbox" name="noRequire_Free" value="true" />
								<span for="noRequire_Free">Free event</span>
							</li>
							<li>
								<input type="checkbox" name="noRequire_Online" value="true" />
								<span for="noRequire_Online">Event remote format</span>
							</li>
						</ul>
					</section>
					<section class="content">
						<select id="require" name="eventRegion">
							<option>Location</option>
							<?php
							?>
						</select>
						<select id="require" name="eventType">
							<option>Type</option>
							<?php
							
							?>
						</select>
						<select id="require" name="eventCategory">
							<option>Tematic</option>
							<?php
							
							?>
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
										$contentQuery = (new Dom)->loadStr($events->content);
										$description = (mb_strlen($contentQuery->find('p')[0]->text) > 45)? mb_substr($contentQuery->find('p')[0]->text, 0, (mb_strlen($contentQuery->find('p')[0]->text) > 45)? mb_strripos(mb_substr($contentQuery->find('p')[0]->text, 0, 45), ' ') : 45).' ...' : mb_substr($contentQuery->find('p')[0]->text, 0, (mb_strlen($contentQuery->find('p')[0]->text) > 45)? mb_strripos(mb_substr($contentQuery->find('p')[0]->text, 0, 45), ' ') : 45);
										
										echo $description;
									?>
								</span>
							  </p>
							  <?php echo Html::a('Learn more', ['news/event', 'contentId' => $events->id]);
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
										$contentQuery = (new Dom)->loadStr($events->content);
										$description = (mb_strlen($contentQuery->find('p')[0]->text) > 45)? mb_substr($contentQuery->find('p')[0]->text, 0, (mb_strlen($contentQuery->find('p')[0]->text) > 45)? mb_strripos(mb_substr($contentQuery->find('p')[0]->text, 0, 45), ' ') : 45).' ...' : mb_substr($contentQuery->find('p')[0]->text, 0, (mb_strlen($contentQuery->find('p')[0]->text) > 45)? mb_strripos(mb_substr($contentQuery->find('p')[0]->text, 0, 45), ' ') : 45);
										
										echo $description;
									?>
								</span>
							  </p>
							  <?php echo Html::a('Learn more', ['news/event', 'contentId' => $events->id]);
							</li>
						<?php } ?>
						  </ul>
					</main>
				</section>
			</div>
    </section>      
</main>
