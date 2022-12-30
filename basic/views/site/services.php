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
			<a href="#newSVCForm" class="add-but" rel="modal:open">Add New Service Offer</a>
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
				<div data-modalpart="content">
					<main id="formUI">
						<section class="formStep">
							<div id="step" class="active">
							  <section id="formStepUI">
								<div class="content">
								  <div id="tab" class="active">
									  <form class="newSVCFormContent" method="POST" action="">
										  <ul>
											<li>
											  <span>Input the service offer title</span>
											  <input type="text" id="title" placeholder="Input service offer title" />
											</li>
											<li>
											  <span>Upload the logo of your organization for which you are publishing an offer</span>
											  <label>
												<span>Upload logo file</span>
												<input type="file" id="logo" accept="image/*" data-logo=""/>
											  </label>
											</li>
											<li>
											  <span>Select your service category</span>
											  <select name="category" id="category">
												<option>Any category</option>
												<?php foreach($categories as $cl){ ?><option value="<?php echo $cl->id; ?>"><?php echo $cl->name; ?></option><?php } ?>
											  </select>
											</li>
											<li>
											  <span>Select your service country</span>
											  <select name="country" id="country">
												<option value="any">All Countries</option>
												<?php
												$countriesList = Yii::$app->regionDB->getFullDataFrame();
												for($i = 0; $i < count($countriesList); $i++){ 
													$curC = $countriesList[$i];
													echo '<option value="' . $curC['code'] . '">' . $curC['title'] . '</option>';
												}
												?>
											  </select>
											</li>
											<li>
												<span>Select your service region</span>
												<select name="region" id="region" disabled>
													<option value="any">All Regions</option>
												</select>
											</li>
										  </ul>
										</form>
								  </div>
								  
								</div>
							  </section>
							  <section id="formStepUI">
								<div class="content">
									<div id="tab" class="active">
									  <ul class="SVCData">
										<li>
											<h4>Brief description of the offer</h4>
											<textarea></textarea>
										</li>
										<li>
											<h4>Full information on the service offer</h4>
											<textarea></textarea>
										</li>
										<li>
											<h4>Price list</h4>
											<textarea></textarea>
										</li>
										<li>
											<h4>Advantages of the offer</h4>
											<textarea></textarea>
										</li>
										<li>
											<h4>Disadvantages of the offer</h4>
											<textarea></textarea>
										</li>
										<li>
											<h4>Advantages and privileges</h4>
											<textarea></textarea>
										</li>
										<li>
											<h4>Location and infrastructure</h4>
											<textarea></textarea>
										</li>
										<li>
											<h4>More information</h4>
											<textarea></textarea>
										</li> 
									  </ul>
								  </div>
								</div>
							  </section>
							  <section id="formStepUI">
								<div class="content">
								  <div id="tab" class="active">
									  <nav>
										<div class="wf">
											<h4>Offer contacts</h4>
											<ul class="contactDataForm">
											  <li>
												<img src="/images/icons/user.svg" />
												<input type="text" placeholder="Name and Surname"/>
											  </li>
											  <li>
												<img src="/images/icons/phone.svg" />
												<input type="phone" placeholder="Your phone"/>
											  </li>
											  <li>
												<img src="/images/icons/mail.svg" />
												<input type="email" placeholder="Your EMail"/>
											  </li>
											</ul>
										</div>
									  </nav>
								  </div>
								</div>
							  </section>
							</div>
						</section>
			 </main>
			 <footer id="formUI">
							<button>Send offer</button>
			  </footer>
				</div>
			</section>
	   </div>
 </main>
