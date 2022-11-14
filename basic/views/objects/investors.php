<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Investors';
?>

<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/investors']); ?>" class="active">Investors</a>
        </section>
        <section class="section" id="investors">
			<a href="#newOffer" rel="modal:open" class="new-ad-form-modal">Add investment search/offer information</a>
			<div id="investors-list">
				<div class="header">
					<h2 class="inv-title">Region</h2>
					<ul class="inv">
						<li>All regions</li>
						<?php foreach($lake['popularRegions'] as $vitrina){ echo Html::tag('li', $vitrina['country']); } ?>
					</ul>
				</div>
				<div class="body">
					<?php foreach($ads as $adList){ ?>
						<aside>
							<div><?php echo $adList->title; ?></div>
							<div><?php echo $adList->description; ?></div>
							<div>
								<i><?php echo $adList->date; ?></i>
								<a href="">Read more</a>
							</div>
						</aside>
					<?php } ?>
				</div>
				<div class="footer">
					<ul>
						<li>
							<label for="at">Ad Type:</label>
							<select name="at">
								<option value="all">All types</option>
								<option value="search">Investments search</option>
								<option value="offers">Investment offers</option>
							</select>
						</li>
						<li>
							<label>Period:</label>
							<input type="date" name="from" placeholder="Created from..."/>
							<input type="date" name="to" placeholder="Created to..."/>
						</li>
						<li>
							<button>Search ad's</button>
						</li>
					</ul>
				</div>
			</div>
        </section>
        <div id="newOffer" class="modal">
			<section class="new-ad-form-modal-data">
				<div id="header">
				  <a href="#" class="modal-active">Investment offer</a>
				  <a href="#">Investment search</a>
				</div>
				<div id="content">
				  <ul>
					<li class="modal-active">
					  <section class="form" data-endpoint="offer">
						<div>
						  <label>Offer title</label>
						  <input type="text" id="title"/>
						</div>
						<div>
						  <label>Payback period(months count)</label>
						  <input type="number" id="period"/>
						</div>
						<div>
						  <label>Investment amount</label>
						  <input type="text" id="amount"/>
						</div>
						<div>
						  <label>Country</label>
						  <select name="region" id="region">
							  <option value="any">Any Country</option>
							  <?php
								$countriesList = Yii::$app->regionDB->getFullDataFrame();
								for($i = 0; $i < count($countriesList); $i++){ 
									$curC = $countriesList[$i];
									echo '<option value="' . $curC['code'] . '">' . $curC['title'] . '</option>';
								}
							  ?>
						  </select>
						</div>
						<div>
						  <label>Offer text</label>
						  <textarea id="content" name="content"></textarea>
						</div>
						<div>
						  <label>Contact name</label>
						  <input type="text" id="contactName"/>
						</div>
						<div>
						  <label>Contact phone</label>
						  <input type="phone" id="contactPhone"/>
						</div>
						<div>
						  <label>Contact E-Mail</label>
						  <input type="email" id="contactMail"/>
						</div>
						<div>
						  <label>Activity to</label>
						  <input type="date" min="<?php echo date('Y-m-d'); ?>" id="activityTo" />
						</div>
					  </section>
					</li>
					<li>
					  <section class="form" data-endpoint="search">
						<div>
						  <label>Title</label>
						  <input type="text" />
						</div>
						<div>
						  <label>Why do you need investments?</label>
						  <textarea id="needI" name="needI"></textarea>
						</div>
						<div>
						  <label>The purpose of existence</label>
						  <textarea id="existence" name="existence"></textarea>
						</div>
						<div>
						  <label>Country of implementation</label>
						  <select name="region" id="region">
							  <option value="any">Any Country</option>
							  <?php
								$countriesList = Yii::$app->regionDB->getFullDataFrame();
								for($i = 0; $i < count($countriesList); $i++){ 
									$curC = $countriesList[$i];
									echo '<option value="' . $curC['code'] . '">' . $curC['title'] . '</option>';
								}
							  ?>
						  </select>
						</div>
						<div>
						  <label>Search offer text</label>
						  <textarea id="contentSearch" name="contentSearch"></textarea>
						</div>
						<div>
						  <label>The problem being solved</label>
						  <input type="text" id="problem"/>
						</div>
						<div>
						  <label>Implementation period</label>
						  <input type="text" id="period"/>
						</div>
						<div>
						  <label>Main competitors</label>
						  <textarea id="competitors" name="competitors"></textarea>
						</div>
						<div>
						  <label>Contact name</label>
						  <input type="text" id="contactName"/>
						</div>
						<div>
						  <label>Contact phone</label>
						  <input type="phone" id="contactPhone"/>
						</div>
						<div>
						  <label>Contact E-Mail</label>
						  <input type="email" id="contactMail"/>
						</div>
						<div>
						  <label>Activity to</label>
						  <input type="date" min="<?php echo date('Y-m-d'); ?>" id="activityTo" />
						</div>
					  </section>
					</li>
				  </ul>
				</div>
				<div id="footer">
				  <button>Send</button>
				</div>
			</section>
        </div>
</main>
