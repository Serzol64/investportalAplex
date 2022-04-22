<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

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
							<option>Region</option>
						</select>
						<select id="require" name="eventType">
							<option>Type</option>
						</select>
						<select id="require" name="eventCategory">
							<option>Tematic</option>
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
					<main></main>
				</section>
			</div>
			<div id="events-footer">
				<section class="events-feed" data-time="exited">
					<header id="title">Exited events</header>
					<main></main>
				</section>
			</div>
    </section>      
</main>
