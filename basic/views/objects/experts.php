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
					<i><?php echo $response['expertsCount']; ?> results finded</i>
					<ul class="result">
						<?php foreach($response['list'] as $experts){ ?>
							<li>
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAACuElEQVRYhe2WPWgTcRjGf8/1I7XYuom4ODSJFcHBpNkUHcVWLYrOipp2qFr8/lgVQ4eKgrmCOkuL4tckLs5NcHIwORU3QSsoGGySu9eh52RjrjXi0mf6czzv8/7+793972BFK/rP0lILtuS9tTExZtggkAgvl2R6Vo/ZrVdHEp/+GUDaLR8A7gE9DSzfhB2eHUk+jJrpLLH5dNj8kRx2VLsrq6vdldUYO4HHQK+hmUzeG46aG2kCW/Le2k6ZB/QgO1fIJicW86Xc8nnBdeCrKYgXsxs/N8uONIGYGCPceaPmAMWRRA54CqzBnLEo2ZEAAmwIQA43mnlNmgQQDLUMQNAHUKlVi828Xe31QriMtwwAqEf0Uf/eJgBFrIkK8A5gldOZbmasdSgNYPC2dQCmhfdanGpmlWx8wUqksyASQFu7cwf4AuxNueXzjXwDbvmiYBCYmzfdjZId+STM5L3hQDYDtAFPTZr8UZ+fBYg5sYxk42Fz36QDxWz8UUsBANL50n6kaRpPLsDsYGE0+SBqZvSj+HZ5D1KuSY2DlNuaLw22DsBMKbc0gcNjwvMA8YHA7++odHV3VLq6TcEmxIewos+RnqSnvBxmTSfcFGDA9SaEzgB1xGXgC8YGc9pHg55ab9BT63WCtlGMDcAcpiuAj9m59NTb3F8BpKa8fSZOAzU5tquQTVwTdgyoCjvp+/5H3/c/muwEUDXpaGE0ftXEbqAGdjbtlvcuCyB+sxwTdgPA4MLs8eQLgNmR5EOTbWfhozMHzCGeYMG2X09+MZt4LnQpjJrcPP26s1GfhvdowPUOGXYfKBWy8X4k+9NOfpOZUlPeG0HCxMFiNjGzmK3hBAwbDhHzS24OhDUugEwNf1D+9AxkAAh4ueTmoSxQWGuZ5QCsA6h3tb9fLkCNjnfhcv1yM1a0on+un9mq9YJO1RZHAAAAAElFTkSuQmCC" alt="Unknown expert" data-block="header">
								<div data-block="content">
									<h3><a href="">Unknown Expert</a></h3>
									<span>Unknown specialisation</span>
									<h4>Unknown slogan</h4>
								</div>
								<ul data-block="footer">
									<li data-field="0">Work experience: <strong>10 y.o.</strong></li>
									<li data-field="1">Is a member of the SRO: <strong>EFA</strong></li>
									<li data-field="2">The introductory appeal is free!</li>
									<li data-field="3">Works with attachments: <strong>1 000 000 $</strong></li>
									<li data-field="4">High raiting</li>
								</ul>
								
								<h4 data-block="alert">The expert is a member of the European Central Bank registry from 1.02.2022</h4>
							</li>
						<?php } ?>
					</ul>
				</footer>
			</div>
        </section>
</main>
