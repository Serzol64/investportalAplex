<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $serviceForm->title . ' :: Portal services';
$service = Yii::$app->portalService;

if(isset($_COOKIE['portalId'])){ $container = function($index){ return $index == 0 ? ['id' => 'step', 'class' => 'currentStep'] : ['id' => 'step']; }; }
else{ $container = function($index){ return $index == 0 ? ['id' => 'step'] : ['id' => 'step', 'class' => 'currentStep']; }; }
?>

 <main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/services']); ?>">Services</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/service-page', ['contentId' => $serviceForm->id]]); ?>" class="active"><?php echo $serviceForm->title; ?></a>
        </section>
        <section class="section" id="service-page-form">
                <div id="svcForm" data-serviceForm-type="main" data-service="<?php echo $currentService; ?>">
					<header id="formUI"><ul class="formStep"><?php if(!isset($_COOKIE['portalId'])){ ?><li id="step" class="currentStep">Please, input your personal contact data!</li><?php } foreach($form['header'] as $i=>$driven){ echo Html::tag('li', $service->formGenerator('header', $driven), $container($i)); } ?></ul></header>
					<main id="formUI">
						<section class="formStep">
							<?php if(!isset($_COOKIE['portalId'])){ ?>
								<div id="step" class="currentStep">
									<div id="header">
										<p>Since you are not authorized or registered on the portal, you need to enter some mandatory personal data, from which the portal service will accept your request in an average of half an hour after registering the requests you have sent. This will strengthen the level of processing and execution of requests in general, distributing the load most often over time!</p>
									</div>
									<div id="body">
										<label>
											<span>Firstname</span>
											<input type="text" id="fn" placeholder="Jonh" />
										</label>
										<label>
											<span>Surname</span>
											<input type="text" id="sn" placeholder="Jonhson" />
										</label>
										<label>
											<span>Country</span>
											<select id="region">
												<option value="any">All Countries</option>
												<?php
												$countriesList = Yii::$app->regionDB->getFullDataFrame();
												for($i = 0; $i < count($countriesList); $i++){ 
													$curC = $countriesList[$i];
													echo '<option value="' . $curC['code'] . '">' . $curC['title'] . '</option>';
												}
												?>
											</select>
										</label>
									</div>
									<div id="footer">
										<label>
											<span>Your email</span> 
											<input type="email" id="email" placeholder="jonh@gmail.com" />
										</label>
										<label>
											<span>Your phone</span>
											<input type="phone" id="phone" placeholder="79012345678" />
										</label>
									</div>
								</div>
							<?php } foreach($form['content'] as $i=>$driven){ echo Html::tag('div', $service->formGenerator('content', $driven), $container($i)); } ?>
						</section>
					</main>
					<footer id="formUI">
						<section class="formStep">
							<?php if(!isset($_COOKIE['portalId'])){ ?>
								<div id="step" class="currentStep">
									<div id="header">
										<input type="checkbox" name="dataAgree" value="ok" />
										<span>I consent to the provision of temporary services for processing, transferring, searching and destroying the entered personal data in accordance with the Portal Data Privacy Policy and regulatory documents regulating such processes in the country where I will provide the data to the Portal service</span>
									</div>
									<div id="body"><button disabled>Countine</button></div>
								</div>
							<?php } foreach($form['footer'] as $i=>$driven){ echo Html::tag('div', $service->formGenerator('footer', $driven), $container($i)); } ?>
						</section>
					</footer>
                </div>
        </section>
 </main>
