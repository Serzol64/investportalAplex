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
										<?php foreach($lake['theme'] as $vitrina){ echo Html::tag('option', $vitrina->title, ['value' => $vitrina->title]); } ?>
									</select>
								</li>
								<li>
									<label for="attachment">Attachments cost, $</label>
									<select name="attachment" data-formState='yes'>
										<option>All cost's</option>
										<?php foreach($lake['cost'] as $vitrina){ echo Html::tag('option', $vitrina->cost, ['value' => $vitrina->cost]); } ?>
									</select>
								</li>
								<li>
									<label for="reg">Region</label>
									<select name="reg" data-formState='yes'>
										<option>All regions</option>
										<?php foreach($lake['region'] as $vitrina){ echo Html::tag('option', $vitrina->region, ['value' => $vitrina->region]); } ?>
									</select>
								</li>
								<li>
									<label for="type">Type of expert</label>
									<select name="type" data-formState='yes'>
										<option>All types</option>
										<?php foreach($lake['type'] as $vitrina){ echo Html::tag('option', $vitrina->type, ['value' => $vitrina->type]); } ?>
									</select>
								</li>
								<li>
									<label for="member">Is a member of the SRO:</label>
									<select name="member" data-formState='yes'>
										<option>All SRO</option>
										<?php foreach($lake['regulator'] as $vitrina){ echo Html::tag('option', $vitrina->regulator, ['value' => $vitrina->regulator]); } ?>
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
								<?php if($experts['titleImage']){ ?><img src="<?php echo $experts['titleImage']; ?>" alt="<?php echo $experts['name']; ?>" data-block="header" /><?php } else{ ?><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAACuElEQVRYhe2WPWgTcRjGf8/1I7XYuom4ODSJFcHBpNkUHcVWLYrOipp2qFr8/lgVQ4eKgrmCOkuL4tckLs5NcHIwORU3QSsoGGySu9eh52RjrjXi0mf6czzv8/7+793972BFK/rP0lILtuS9tTExZtggkAgvl2R6Vo/ZrVdHEp/+GUDaLR8A7gE9DSzfhB2eHUk+jJrpLLH5dNj8kRx2VLsrq6vdldUYO4HHQK+hmUzeG46aG2kCW/Le2k6ZB/QgO1fIJicW86Xc8nnBdeCrKYgXsxs/N8uONIGYGCPceaPmAMWRRA54CqzBnLEo2ZEAAmwIQA43mnlNmgQQDLUMQNAHUKlVi828Xe31QriMtwwAqEf0Uf/eJgBFrIkK8A5gldOZbmasdSgNYPC2dQCmhfdanGpmlWx8wUqksyASQFu7cwf4AuxNueXzjXwDbvmiYBCYmzfdjZId+STM5L3hQDYDtAFPTZr8UZ+fBYg5sYxk42Fz36QDxWz8UUsBANL50n6kaRpPLsDsYGE0+SBqZvSj+HZ5D1KuSY2DlNuaLw22DsBMKbc0gcNjwvMA8YHA7++odHV3VLq6TcEmxIewos+RnqSnvBxmTSfcFGDA9SaEzgB1xGXgC8YGc9pHg55ab9BT63WCtlGMDcAcpiuAj9m59NTb3F8BpKa8fSZOAzU5tquQTVwTdgyoCjvp+/5H3/c/muwEUDXpaGE0ftXEbqAGdjbtlvcuCyB+sxwTdgPA4MLs8eQLgNmR5EOTbWfhozMHzCGeYMG2X09+MZt4LnQpjJrcPP26s1GfhvdowPUOGXYfKBWy8X4k+9NOfpOZUlPeG0HCxMFiNjGzmK3hBAwbDhHzS24OhDUugEwNf1D+9AxkAAh4ueTmoSxQWGuZ5QCsA6h3tb9fLkCNjnfhcv1yM1a0on+un9mq9YJO1RZHAAAAAElFTkSuQmCC" alt="" data-block="header"><?php } ?>
								<div data-block="content">
									<?php
										echo Html::tag('h3', Html::a($experts['name'], ['objects/experts-view', ['expertId' => $experts['id']]]));
										echo Html::tag('span', $experts['specialization']);
										echo Html::tag('h4', $experts['slogan']);
									?>
								</div>
								<ul data-block="footer">
									<li data-field="0">Work experience: <strong><?php echo $experts['workExperience']; ?></strong></li>
									<?php
										if($experts['regulator']){ echo Html::tag('li', 'Is a member of the SRO: ' . Html::tag('strong', $experts['regulator']), ['data-field' => 1]); }
										if($experts[2]['isFreeAppreal']){ echo Html::tag('li', 'The introductory appeal is free!', ['data-field' => 2]); }
										if($experts[0]['attachments']){ echo Html::tag('li', 'Works with attachments: ' . Html::tag('strong', $experts[0]['attachments']), ['data-field' => 3]); }
										if($experts['raiting'] == 5){ echo Html::tag('li', 'High raiting', ['data-field' => 4]); }
									?>
								</ul>
								
								<!--<h4 data-block="alert"></h4>-->
							</li>
						<?php } ?>
					</ul>
				</footer>
			</div>
        </section>
</main>
