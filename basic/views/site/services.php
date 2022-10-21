<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Portal services';
?>

 <main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/services']); ?>">Services</a>
        </section>
        <section class="section" id="services-public">
			<h2 id="title">Services list and search</h2>
			<a href="#newSVCForm" class="add-but" rel="modal:open">Add New Service</a>
			<div id="services-list">
			  <header id="search">
				<input type="search" name="servicesQ" placeholder="Services search..."/>
				<div class="last-example">
				  Example: <span id="exmpl"></span>
				  
				  <div class="categories">
					<?php foreach($categories as $cl){ ?>
						<a href="#" data-cat="<?php echo $cl->id; ?>">
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
						$listResponse .= Html::tag('li', Html::a($svc->title, ['site/service-page', 'id' => $svc->id])); 
						$regexIs++;
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
        <div id="newSVCForm" class="modal">
			<section class="newServiceForm">
				<div data-modalpart="header">
					<ul class="formStep">
					  <li id="step" class="active">Enter basic information about the service</li>
					  <li id="step">Select the service access level</li>
						<li id="step">Decide on the operation of logic or other functions inside the service</li>
						<li id="step">Provide parameters to the functionality of your service</li>
					</ul>
				</div>
				<div data-modalpart="content">
					  <header id="formUI">
						<ul class="formStep">
							<li id="step" class="active">
							  <span>Enter the basic information about your service offer from the organization</span>
							  <span>Enter the basic and metadata about your form or special service</span>
							</li>
							<li id="step">
							  <span>Decide on the level of access to your service offer</span>
							  <span>Decide on the level of access to your form or special service</span>
							</li>
							<li id="step">
							  <span>Describe the logic and other features of your service offer</span>
							  <span>Describe the logic and other features of your form or special service</span>
							</li>
							<li id="step">
							  <span>Inform the portal of your contact and other personal data, according to which our users will accept your offer for your service within your organization</span>
							  <span>Will inform the portal about the data processing parameters received from your form or your service</span>
							</li>
						</ul>
			 </header>
			 <main id="formUI">
						<section class="formStep">
							<div id="step" class="active">
							  <section id="formStepUI">
								<div class="header">
								  <a href="#" class="active">Your proposal</a>
								  <a href="#">Your form or separate service</a>
								</div>
								<div class="content">
								  <div id="tab" class="active"></div>
								  <div id="tab"></div>
								</div>
							  </section>
							</div>
							<div id="step">
							  <section id="formStepUI">
								<div class="header">
								  <a href="#" class="active">Your proposal</a>
								  <a href="#">Your form or separate service</a>
								</div>
								<div class="content">
								  <div id="tab" class="active"></div>
								  <div id="tab"></div>
								</div>
							  </section>
							</div>
							<div id="step">
							  <section id="formStepUI">
								<div class="header">
								  <a href="#" class="active">Your proposal</a>
								  <a href="#">Your form or separate service</a>
								</div>
								<div class="content">
								  <div id="tab" class="active"></div>
								  <div id="tab"></div>
								</div>
							  </section>
							</div>
							<div id="step">
							  <section id="formStepUI">
								<div class="header">
								  <a href="#" class="active">Your proposal</a>
								  <a href="#">Your form or separate service</a>
								</div>
								<div class="content">
								  <div id="tab" class="active"></div>
								  <div id="tab"></div>
								</div>
							  </section>
							</div>
						</section>
			 </main>
			 <footer id="formUI">
							<button>Countine</button>
			  </footer>
				</div>
			</section>
	   </div>
 </main>
