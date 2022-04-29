<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Offers for Investors";
?>
<main class="main" style="background-color:   #eff3f4;">
	<section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['passport/service']); ?>" class="active">Passport</a>
	</section>
	<section class="section" id="passport">
		<div class="passport-page">
                <header>
                    <div id="left-content">
                        <span>My offers for investors</span>
                    </div>
                    <div id="right-content">
                        <a href="../index.html">Exit</a>
                        <nav>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAApUlEQVRIie2SPRKDIBQGHdvo3SjiWOQkJrfVY+DMpgiFf/DeQ+iyNewy39A0f0oCDIBHoKo8KwCMCfkEPIB3VkCQA3ThXG8OKOSEl3fAxxTAsPmRqnIxcFeeDKDbXMLH5K6EHBhjgaWavEAgLb85kSzfRJ7GyAq8NvcB+ZtqIzu5OqCMnOSmgBC5nCWGNRKdJSsQBI7fF54BJ5zVT5TDVaCtVgt8AepKL2apKcmDAAAAAElFTkSuQmCC" id="newoffer" alt="Add Offer" />
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAn0lEQVRIid2Uuw0CMRBER4jsWqAFCoEqLnJdJ5oix9RA+ohOOp0W2PUnMBNZq5kd78eW/g7AFcjEkYGLx6Ak+YqHxwCAgspN3SGaKIqhDBYXKzoDYLbOLQ0AbsAUEUQNAO7AucrA8Q5eQNpqum/Rx1tG+U1a9IXfdch913SjW1y6CgNTN9RfZOJoxJ6STiVtkpT3AauCZBGdydNP1nB4A5tWVezafhVfAAAAAElFTkSuQmCC" id="exit" alt="Exit" />
                        </nav>
                    </div>
                </header>
                <main>
                    <div id="left-content">
						<?php if($getOffers){ ?>
							<table id="table-list">
								<thead>
									<tr class="header">
										<th>№</th>
										<th>Object</th>
										<th>Type</th>
										<th>Cost</th>
										<th style="text-indent: -9%;">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$id = 1;
										foreach($getOffers as $offer){
									?>
											<tr class="content">
												<td><?php echo $id; ?></td>
												<!--<td>Private boarding house on the beach, high-quality service and high profitability</td>-->
												<!--<td>Hotel</td>-->
												<!--<td>$ 10 000 000</td>-->
												<td>
													<?php if($offer->status){ ?><div class="status" style="background-color: #72dade;">Active</div><?php } else { ?><div class="status" style="padding-top: 15px;padding-bottom: 15px;">Not<br/>active</div><?php } ?>
												</td>
											</tr>
									<?php $id++; } ?>
								</tbody>
							</table>
                        <?php } else{ ?>
							<div class="error-container">
								<h2>There is no requested data about your current offers!</h2>
								<span>There is no data on offers with objects in your portal account, since you did not add them...</span>
							</div>
						<?php } ?>
                    </div>
                    <div id="right-content">
                       <ul class="nav">
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/profile">Passport</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport">My investment requests</a></li>
                           <li class="active"><i class="fas fa-circle active-link"></i><a href="/passport/offers">My offers for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/services">My services for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/cart">My shopping Cart</a></li>
                       </ul>
                    </div>
                </main>
                <footer>
                    <div id="left-content">
                        <button class="add-but">Add Offers</button>
                    </div>
                </footer>
            </div>
	</section>
</main>
