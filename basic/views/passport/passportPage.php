<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Investment requests";
?>

<main class="main" style="background-color:   #eff3f4;">
	<section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['passport/service']); ?>" class="active">Passport</a>
	</section>
	<section class="section" id="passport">
		<div class="passport-page">
                <header>
                    <div id="left-content">
                        <span>My investment requests</span>
                    </div>
                    <div id="right-content">
                        <a href="">Exit</a>
                        <nav>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABBklEQVRIid2TPQrCQBCFZ8UqCLYWWtt6Dn/wFh5DBBGsvIhn8OcA1oKolTbWESw/m1GjbrK7URsfLEmYt+/bTCYifyegCRxwa5AX4BO+yQ3xCAeoAGu9H38doL4qsA2G+AISkF0QJASg/loQJBSQgOxttaLXa1kO4est5AGE6OeAN7n6bfH3gQYQAdFr3dgATwZj3jwhcrYoZZCmQEHrXWAJnHUtgE5oYFInoKzecYZv5AXIOEjX5nvZ3v4EsPQAzJ0f2aLIGHMBYhEppQ2B5sS//g+wAY6OTXW9rkQeLbknPj+vbICeiBwyALcRnDgO4utJFzDKGNPhR+EJSBuYA7GuGdC61a/HQqNpY0K2UgAAAABJRU5ErkJggg==" id="newrequest" alt="Add Request" />
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAn0lEQVRIid2Uuw0CMRBER4jsWqAFCoEqLnJdJ5oix9RA+ohOOp0W2PUnMBNZq5kd78eW/g7AFcjEkYGLx6Ak+YqHxwCAgspN3SGaKIqhDBYXKzoDYLbOLQ0AbsAUEUQNAO7AucrA8Q5eQNpqum/Rx1tG+U1a9IXfdch913SjW1y6CgNTN9RfZOJoxJ6STiVtkpT3AauCZBGdydNP1nB4A5tWVezafhVfAAAAAElFTkSuQmCC" id="exit" alt="Exit" />
                        </nav>
                    </div>
                </header>
                <main>
                    <div id="left-content">
                       <?php if($requestData){ ?>
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
												<td>
													<?php if($offer->status){ ?><div class="status" style="background-color: #72dade;">Active</div><?php } else { ?><div class="status" style="padding-top: 15px;padding-bottom: 15px;">Not<br/>active</div><?php } ?>
												</td>
											</tr>
									<?php $id++; } ?>
								</tbody>
							</table>
                        <?php } else{ ?>
							<div class="error-container">
								<h2>There is no requested data about your requests!</h2>
								<span>There is no data on investment requests in your portal account, since you did not add them...</span>
							</div>
							<script>$(document).ready(function(){ $('.passport-page > footer #left-content').css('top', '-205px'); });</script>
						<?php } ?>
                    </div>
                    <div id="right-content">
                       <ul class="nav">
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/profile">Passport</a></li>
                           <li class="active"><i class="fas fa-circle active-link"></i><a href="/passport">My investment requests</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/offers">My offers for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/services">My services for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/cart">My shopping Cart</a></li>
                       </ul>
                    </div>
                </main>
                <footer>
                    <div id="left-content" style="position:relative;left: -57vw;top: 428px;">
                        <button class="add-but">Add Request</button>
                    </div>
                </footer>
            </div>
	</section>
</main>
