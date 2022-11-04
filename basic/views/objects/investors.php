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
							<label for="kwds">Keywords:</label>
							<input type="search" name="kwds" placeholder="Example: sport gym, hotel" />
						</li>
						<li>
							<label for="at">Ad Type:</label>
							<select name="at">
								<option value="all">All types</option>
								<option value="search">Investments search</option>
								<option value="offers">Investment offers</option>
								<option value="partner">Partner's search</option>
							</select>
						</li>
						<li>
							<label for="acc">Type of activity:</label>
							<select name="acc">
								<option value="all">All categories</option>
								<?php foreach($lake['category'] as $vitrina){ echo Html::tag('option', $vitrina->name, ['value' => $vitrina->id]); } ?>
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
				  <a href="#">Investors search</a>
					</div>
				<div id="content">
				  <ul>
					<li class="modal-active">
					  <section class="form" data-endpoint="">
						<div>
						  <label>Offer title</label>
						  <input type="text" />
						</div>
					  </section>
					</li>
					<li>
					  <section class="form" data-endpoint="">
						<div>
						  <label>Title</label>
						  <input type="text" />
						</div>
					  </section>
					</li>
					<li>
					  <section class="form" data-endpoint="">
						<div>
						  <label>Target title</label>
						  <input type="text" />
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
