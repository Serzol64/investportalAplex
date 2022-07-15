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
					<?php foreach($categories as $cl){ ?>
						<a data-cat="<?php echo $cl->id; ?>">
						  <img src="<?php echo $cl->icon; ?>" />
						  <strong><?php echo $cl->name; ?></strong>
						</a>
					<?php } ?>
				  </div>
				</div>
			  </header>
			  <main id="list">
					<?php 
					$listResponse = '';
					$regexIs = 0;
					foreach($services as $svc){ 
						$metaData = Json::deocde($svc->meta, true);

						if($metaData['categoryId'] == 1){	
							$listResponse .= Html::tag('li', Html::a($svc->title, ['site/service-page', 'id' => $svc->id])); 
							$regexIs++;
						}
					}
						
					if(!$regexIs == 0){ echo Html::tag('ul', $listResponse); }
					else{ 
					?>
				  <div class="not-found-data">
					  <img src="/images/icons/services/error.gif" />
					  <h3>There are no services in the selected category!</h3>
					  <span>In the category you have selected, services from their collection on the portal are unavailable. Empty, because we have recently registered a category and the first services inside it will be available later or earlier.</span>
				  </div>
				 <?php } ?>
				 <div class="load-screen-services list-smart-close">
				   <center>
					<img src="/images/icons/loading.gif" />
					<span>Please wait... <br />The process of processing the search query is underway</span>
				   </center>
				</div>
			  </main>
			</div>
			<h2 id="title">New services</h2>
			
			<h2 id="title">Popular services</h2>
			
        </section>
 </main>
