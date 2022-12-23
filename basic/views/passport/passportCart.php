<?php

/* @var $this yii\web\View */

function autoAmount($query){
	$currency = Yii::$app->currencyDB;
							
	$convertQuery = [
		'type' => 'currency',
		'response' => [
			'myCur' => $_COOKIE['servicesCurrency'],
			'amount' => $offer->offer
		]
	];
												
	$dataAmount = [
		'isSymbol' => TRUE,
		'query' => [
			'myCur' => $_COOKIE['servicesCurrency'],
			'amount' => $currency->execute($convertQuery)
		]
	];
												

	return $currency->getFullAmount($dataAmount);
}


use yii\helpers\Html;
use yii\helpers\Url;


use app\models\ObjectsData;
use app\models\Offers;
use app\models\Investments;
use app\models\PortalServices;

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
										<?php 
										$id = 1;
										$cartFragment = '';
										
										foreach($connector[1] as $cartResponse){
											$fragmentPart = '';
											
											$currentObject = ObjectsData::find()->where(['id' => $cartResponse->operationId])->one();
											$dataStatus = [
												'request' => Investments::find()->where(['objectId' => $currentObject->id, 'status' => TRUE])->count(),
												'offer' => Offers::find()->where(['objectId' => $currentObject->id, 'status' => TRUE])->count()
											];
											
											if($dataStatus['offer'] > $dataStatus['request']){ $currentStatus = Html::tag('div', "Active", ['class' => 'status', 'style' => 'background-color:  #72dade;']); }
											else{ $currentStatus = Html::tag('div', "Not active", ['class' => 'status', 'style' => 'background-color:  ;']); }
											
											
											
											$fragmentPart .= Html::tag('td', $id);
											$fragmentPart .= Html::tag('td', $currentObject->title);
											$fragmentPart .= Html::tag('td', $currentObject->category);
											$fragmentPart .= Html::tag('td', autoAmount($currentObject->cost));
											$fragmentPart .= Html::tag('td', $currentStatus);
											
											$cartFragment .= Html::tag('tr', $fragmentPart, ['class' => 'content']);
											
											$id++;
										}
										
										echo $cartFragment;
										?>
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
										<div class="error-container">
											<h2>This block is under development!</h2>
											<span>The data in it is available, but here we implement an algorithm for searching and outputting data in accordance with the parameters that are requested by this block. Be patient.</span>
										</div>
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
										<?php 
										$id = 1;
										$cartFragment = '';
										
										foreach($connector[2] as $cartResponse){
											$fragmentPart = '';
											
											
											$currentService = PortalServices::find()->select(['title', 'category'])->where(['id' => $cartResponse->operationId])->one();
											
											$fragmentPart .= Html::tag('td', $id);
											$fragmentPart .= Html::tag('td', $currentService->title);
											$fragmentPart .= Html::tag('td', $currentService->category);
											
											$cartFragment .= Html::tag('tr', $fragmentPart, ['class' => 'content']);
											$id++;
										}
										
										echo $cartFragment;
										?>
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
