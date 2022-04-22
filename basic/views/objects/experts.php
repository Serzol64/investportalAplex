<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Experts';
?>
<main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/experts-feed']); ?>">Experts</a>
        </section>
        <section class="section" id="experts">
			<div id="experts-search">
				<header>
					<input type="search" name="consultQ" id="consultQ" placeholder="Expert name or theme" />
				</header>
				<main>
					<div class="searchComponent">
						<div id="search-header">
							<ul>
								<li>
									<label for="consultT">Consult Theme</label>
									<select name="consultT" data-formState='yes'>
										<option>All themes</option>
									</select>
								</li>
								<li>
									<label for="attachment">Attachments cost, $</label>
									<select name="attachment" data-formState='yes'>
										<option>All cost's</option>
									</select>
								</li>
								<li>
									<label for="reg">Region</label>
									<select name="reg" data-formState='yes'>
										<option>All regions</option>
									</select>
								</li>
								<li>
									<label for="type">Type of expert</label>
									<select name="type" data-formState='yes'>
										<option>All types</option>
									</select>
								</li>
								<li>
									<label for="member">Is a member of the SRO:</label>
									<select name="member" data-formState='yes'>
										<option>All SRO</option>
									</select>
								</li>
							</ul>
						</div>
						<div id="search-footer">
							<ul>
								<li>
									<input type="checkbox" name="regionRegulators" />
									<label for="regionRegulators">In the registers of regulators</label>
								</li>
								<li>
									<input type="checkbox" name="fia" />
									<label for="fia">Free introductory appeal</label>
								</li>
							</ul>
						</div>
					</div>
				</main>
				<footer>
					<i>10 results finded</i>
					<ul class="result"></ul>
				</footer>
			</div>
        </section>
</main>
