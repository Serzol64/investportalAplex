<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Shopping cart";
?>
<main class="main" style="background-color:   #eff3f4;">
	<section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['passport/service']); ?>" class="active">Passport</a>
	</section>
	<section class="section" id="passport">
		<div class="passport-page" style="padding-bottom: 9%;">
                <header>
                    <div id="left-content">
                        <span>My shopping cart</span>
                    </div>
                    <div id="right-content">
                        <a href="../index.html">Exit</a>
                        <nav>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAn0lEQVRIid2Uuw0CMRBER4jsWqAFCoEqLnJdJ5oix9RA+ohOOp0W2PUnMBNZq5kd78eW/g7AFcjEkYGLx6Ak+YqHxwCAgspN3SGaKIqhDBYXKzoDYLbOLQ0AbsAUEUQNAO7AucrA8Q5eQNpqum/Rx1tG+U1a9IXfdch913SjW1y6CgNTN9RfZOJoxJ6STiVtkpT3AauCZBGdydNP1nB4A5tWVezafhVfAAAAAElFTkSuQmCC" id="exit" alt="Exit" />
                        </nav>
                    </div>
                </header>
                <main>
                    <div id="left-content">
                        <div class="cart-data">
                            <h3>Interesting objects for Investment</h3>
                            <?php if($connector[1]){ ?>
								<table id="table-list">
									<thead>
										<tr class="header">
											<th>№</th>
											<th>Object</th>
											<th>Type</th>
											<th>Cost</th>
											<th style="text-indent: -28%;">Status</th>
										</tr>
									</thead>
									<tbody>
										<tr class="content">
											<td>1</td>
											<td>Private boarding house on the beach, high-quality service and high profitability</td>
											<td>Hotel</td>
											<td>$ 10 000 000</td>
											<td>
												<div class="status" style="background-color: #72dade;">
													Active
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							<?php } else{ ?>
								<div class="error-container">
									<h2>There is no requested data about your interesting objects!</h2>
									<span>There is no data on your interesting objects in your portal account, since you did not add them...</span>
								</div>
							<?php } ?>
                        </div>
                        <div class="cart-data">
                            <h3>Interesting requests from Investors</h3>
                            <?php if($connector[0]){ ?>
								<table id="table-list">
									<thead>
										<tr class="header">
											<th>№</th>
											<th>Amount of investments</th>
											<th>Areas of investment</th>
											<th>Investment regions</th>
										</tr>
									</thead>
									<tbody>
										<tr class="content">
											<td>1</td>
											<td>$ 4 000 000</td>
											<td>Soccer club, Hotel, Rabbit farm</td>
											<td>Austria, Canada</td>
										</tr>
									</tbody>
								</table>
                            <?php } else{ ?>
								<div class="error-container">
									<h2>There is no requested data about your interesting requests!</h2>
									<span>There is no data on interesting objects in your portal account, since investors did not add them...</span>
								</div>
							<?php } ?>
                        </div>
                        <div class="cart-data">
                            <h3>Interesting service</h3>
                            <?php if($connector[2]){ ?>
								<table id="table-list">
									<thead>
										<tr class="header">
											<th>№</th>
											<th>Service</th>
											<th>Region</th>
										</tr>
									</thead>
									<tbody>
										<tr class="content">
											<td>1</td>
											<td>Recruitment, management companies</td>
											<td>Austria</td>
										</tr>
									</tbody>
								</table>
							<?php } else{ ?>
								<div class="error-container">
									<h2>There is no requested data about your interesting services!</h2>
									<span>There is no data on interesting services in your portal account, since you did not add them...</span>
								</div>
							<?php } ?>
                        </div>
                    </div>
                    <div id="right-content">
                       <ul class="nav">
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/profile">Passport</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport">My investment requests</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/offers">My offers for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/services">My services for investors</a></li>
                           <li class="active"><i class="fas fa-circle active-link"></i><a href="/passport/cart">My shopping Cart</a></li>
                       </ul>
                    </div>
                </main>
                <footer>
                    <div id="left-content">
                        
                    </div>
                </footer>
            </div>
	</section>
</main>
