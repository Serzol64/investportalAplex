<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Portal services';
?>

 <main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/services']); ?>">Services</a>
        </section>
        <section class="section" id="services-public">
			<h2 id="title">Services list and search</h2>
			<div id="services-list">
			  <header id="search">
				<input type="search" name="servicesQ" placeholder="Services search..."/>
				<div class="last-example">
				  Example: <span id="exmpl"></span>
				  
				  <div class="categories">
					<?php foreach($cl as $categories){ ?>
						<a href="">
						  <img src="<?php echo $cl->catIcon; ?>" />
						  <strong><?php echo $cl->catName; ?></strong>
						</a>
					<?php } ?>
				  </div>
				</div>
			  </header>
			  <main id="list"><ul></ul></main>
			</div>
			<h2 id="title">New services</h2>
			<div class="news-feed">
                <footer><div id="down-feed"><div class="down-feed-cont"><div id="cont-content"></div></div></div></footer>
            </div>
			<h2 id="title">Popular services</h2>
			<div class="news-feed">
                <footer><div id="down-feed"><div class="down-feed-cont"><div id="cont-content"></div></div></div></footer>
            </div>
        </section>
 </main>
