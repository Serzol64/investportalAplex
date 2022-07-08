<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'About Investportal';
?>
<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/about']); ?>">About</a>
        </section>
        <section class="section" id="about">
			<div id="about-header">
				<!--Промо блок-->
				
				<h2>Welcome to Investportal world!</h2>
				<span>Here you will learn about the portal's services and the subtleties of its work, organized jointly with Russian developers!</span>
			</div>
			<div id="about-content">
				<ul id="about-q">
					<li>
						<h4 data-block="header">What is portal?</h4>
						<span data-block="body">
							<ul>
								<li>
									<img src="/images/icons/about/whatIs/1.png" />
									<p>A single digital platform for all commercial facilities and investment opportunities in them</p>
								</li>
								<li>
									<img src="/images/icons/about/whatIs/2.png" />
									<p>A source for obtaining the necessary and accurate information about objects and their financial capabilities</p>
								</li>
								<li>
									<img src="/images/icons/about/whatIs/3.png" />
									<p>The portal's services are not only informational and financial in nature, but also service-contact. With the use of a database of unique services and a single ID of the portal user account, the effect of solving all legal and investment issues increases, thanks to online chats and other promising technologies of this kind!</p>
								</li>
							</ul>
						</span>
					</li>
					<li>
						<h4 data-block="header">Advantages</h4>
						<span data-block="body">
							<ul>
								<li>
									<img src="/images/icons/about/avantages/1.png" />
									<p>The income from investing in any object, thanks to the portal, will bring to the buyer what he dreamed of, and to the investor - great advantages and opportunities in his work!</p>
								</li>
								<li>
									<img src="/images/icons/about/avantages/2.png" />
									<p>The presentation of objects takes place in accordance with the agreed format</p>
								</li>
								<li>
									<img src="/images/icons/about/avantages/3.png" />
									<p>The objects available in the portal database are undergoing preliminary examination by specialized agencies and organizations around the world!</p>
								</li>
								<li>
									<img src="/images/icons/about/avantages/4.png" />
									<p>Video calls and broadcasts with investors are conducted by users of the portal and in the near future internal services for broadcasting and calls will be implemented with the possibility of recording and publishing them on the social network.</p>
								</li>
								<li>
									<img src="/images/icons/about/avantages/5.png" />
									<p>The user can use the chat inside the portal at any time and even during calls and broadcasts for feedback from investors and experts of the portal!</p>
								</li>
								<li>
									<img src="/images/icons/about/avantages/6.png" />
									<p>Any popular groups and specializations can become users of the portal: experts, businessmen and private buyers</p>
								</li>
							</ul>
						</span>
					</li>
					<li>
						<h4 data-block="header">New opportunities and discoveries</h4>
						<span data-block="body">
							<ul>
								<li>
									<img src="/images/icons/about/discoveries/1.png" />
									<p>The data of users and services of the portal are successfully protected and they will be distributed by regions in accordance with the regulatory legal acts of countries and continents in the field of personal data protection!</p>
								</li>
								<li>
									<img src="/images/icons/about/discoveries/2.png" />
									<p>The portal and its services have been successfully scaled for all countries and currencies of the world, ensuring their absolute availability and fault tolerance!</p>
								</li>
								<li>
									<img src="/images/icons/about/discoveries/3.png" />
									<p>The introduction and application of promising technologies in the portal services will 100% change the lives of their users - photos, videos, calls inside the portal, VR/AR, artificial intelligence, big data, etc.</p>
								</li>
								<li></li>
								<li></li>
							</ul>
						</span>
					</li>
				</ul>
			</div>
			<div id="about-footer">
				<h2>InvestPortal today:</h2>
				
				<div data-block="forecast">
					<div>
						<p>
							<strong>2000</strong> new objects adding in portal services on average per day!
						</p>
						<p>
							Deals were successfully concluded with <strong>50%</strong> of the total number of objects available in the portal, thanks to its capabilities!
						</p>
					</div>
					<div>
						<p><strong>15000</strong> portal services verifyed users</p>
						<p><strong>400</strong> new verifyed users appear in the databases and services of the portal every month!</p>
					</div>
					<div>
						<p>Objects with a total cost are available in the portal services - <strong>105 800 700 $</strong></p>
						<p><strong>52 900 350 $</strong> - the total amount of successful transactions successfully concluded within the entire portal as a whole</p>
					</div>
					<div>
						<p>
							<strong>Hotels</strong> - one of the most preferred categories of objects by portal users!
						</p>
					</div>
				</div>
			</div>
        </section>
 </main>
