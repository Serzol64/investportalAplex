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
			<?php if(isset($_COOKIE['portalId'])){ ?><a href="#newExpert" class="newExpert" rel="modal:open">Add your expert data</a><?php } ?>
			<div id="experts-search">
				<main>
					<div class="searchComponent">
						<div id="search-header">
							<ul>
						<?php if(is_array($lake['theme']) || is_object($lake['theme'])){ ?>
								<li>
									<label for="consultT">Consult Theme</label>
									<select name="consultT" data-formState='yes'>
										<option value="all">All themes</option>
										<?php foreach($lake['theme'] as $vitrina){ echo Html::tag('option', $vitrina->title, ['value' => $vitrina->title]); } ?>
									</select>
								</li>
						<?php } if(is_array($lake['cost']) || is_object($lake['cost'])){ ?>
								<li>
									<label for="attachment">Attachments cost, $</label>
									<select name="attachment" data-formState='yes'>
										<option value="all">All cost's</option>
										<?php foreach($lake['cost'] as $vitrina){ echo Html::tag('option', $vitrina->cost, ['value' => $vitrina->cost]); } ?>
									</select>
								</li>
						<?php } if(is_array($lake['region']) || is_object($lake['region'])){ ?>
								<li>
									<label for="reg">Region</label>
									<select name="reg" data-formState='yes'>
										<option value="all">All regions</option>
										<?php foreach($lake['region'] as $vitrina){ echo Html::tag('option', $vitrina->region, ['value' => $vitrina->region]); } ?>
									</select>
								</li>
						<?php } if(is_array($lake['type']) || is_object($lake['type'])){ ?>
								<li>
									<label for="type">Type of expert</label>
									<select name="type" data-formState='yes'>
										<option value="all">All types</option>
										<?php foreach($lake['type'] as $vitrina){ echo Html::tag('option', $vitrina->type, ['value' => $vitrina->type]); } ?>
									</select>
								</li>
						<?php } if(is_array($lake['regulator']) || is_object($lake['regulator'])){ ?>
								<li>
									<label for="member">Is a member of the SRO:</label>
									<select name="member" data-formState='yes'>
										<option value="all">All SRO</option>
										<?php foreach($lake['regulator'] as $vitrina){ echo Html::tag('option', $vitrina->regulator, ['value' => $vitrina->regulator]); } ?>
									</select>
								</li>
						<?php } ?>
							</ul>
						</div>
						<div id="search-footer">
							<ul>
								<li>
									<input type="checkbox" name="fia" value="true"/>
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
								<?php if($experts['titleImage']){ ?><img src="<?php echo $experts['titleImage']; ?>" alt="<?php echo $experts['name']; ?>" data-block="header" /><?php } else{ ?><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAACuElEQVRYhe2WPWgTcRjGf8/1I7XYuom4ODSJFcHBpNkUHcVWLYrOipp2qFr8/lgVQ4eKgrmCOkuL4tckLs5NcHIwORU3QSsoGGySu9eh52RjrjXi0mf6czzv8/7+793972BFK/rP0lILtuS9tTExZtggkAgvl2R6Vo/ZrVdHEp/+GUDaLR8A7gE9DSzfhB2eHUk+jJrpLLH5dNj8kRx2VLsrq6vdldUYO4HHQK+hmUzeG46aG2kCW/Le2k6ZB/QgO1fIJicW86Xc8nnBdeCrKYgXsxs/N8uONIGYGCPceaPmAMWRRA54CqzBnLEo2ZEAAmwIQA43mnlNmgQQDLUMQNAHUKlVi828Xe31QriMtwwAqEf0Uf/eJgBFrIkK8A5gldOZbmasdSgNYPC2dQCmhfdanGpmlWx8wUqksyASQFu7cwf4AuxNueXzjXwDbvmiYBCYmzfdjZId+STM5L3hQDYDtAFPTZr8UZ+fBYg5sYxk42Fz36QDxWz8UUsBANL50n6kaRpPLsDsYGE0+SBqZvSj+HZ5D1KuSY2DlNuaLw22DsBMKbc0gcNjwvMA8YHA7++odHV3VLq6TcEmxIewos+RnqSnvBxmTSfcFGDA9SaEzgB1xGXgC8YGc9pHg55ab9BT63WCtlGMDcAcpiuAj9m59NTb3F8BpKa8fSZOAzU5tquQTVwTdgyoCjvp+/5H3/c/muwEUDXpaGE0ftXEbqAGdjbtlvcuCyB+sxwTdgPA4MLs8eQLgNmR5EOTbWfhozMHzCGeYMG2X09+MZt4LnQpjJrcPP26s1GfhvdowPUOGXYfKBWy8X4k+9NOfpOZUlPeG0HCxMFiNjGzmK3hBAwbDhHzS24OhDUugEwNf1D+9AxkAAh4ueTmoSxQWGuZ5QCsA6h3tb9fLkCNjnfhcv1yM1a0on+un9mq9YJO1RZHAAAAAElFTkSuQmCC" alt="" data-block="header" /><?php } ?>
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
        <div id="newExpert" class="modal">
			<section class="new-ad-form-modal-data">
					<div id="content">
					  <ul>
						<li class="modal-active">
						  <section class="form">
										<div>
										  <label>Your specialization</label>
										  <input type="text" id="specialization" placeholder=""/>
										</div>
										<div>
										  <label>Your slogan</label>
										  <input type="text" id="slogan" placeholder=""/>
										</div>
										<div>
										  <label>Your region</label>
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
										  <label>Experience start date</label>
										  <input type="date" id="exprStart" placeholder="" min="<?php echo date('Y-m-d'); ?>"/>
										</div>
										<div>
										  <label>About your work</label>
										  <textarea id="about" placeholder=""></textarea>
										</div>
										<div>
										  <label>Your attachments</label>
										  <input type="text" id="attachments" placeholder=""/>
										</div>
										<div>
										  <label>Your investment amounts</label>
										  <textarea id="amounts" placeholder=""></textarea>
										</div>
										<div>
										  <label>Your specialization history</label>
										  <textarea id="specHistory" placeholder=""></textarea>
										</div>
										<div>
										  <label>Your services and prices</label>
										  <textarea id="prices" placeholder=""></textarea>
										</div>
										<div>
										  <label>Is free appreal</label>
										   <select id="isFreeAppreal">
												<option value="true">Yes</option>
												<option value="false">No</option>
										   </select>
										</div>
										<div>
										  <label>Legal state</label>
										   <select id="legalState">
												<option value="unknown">Select state</option>
												<option value="0">Certified Investor</option>
												<option value="1">An expert trusted by financial organizations, institutions and regulators</option>
										   </select>
										</div>
									  </section>
									</li>
								  </ul>
								</div>
								<div id="footer">
								  <button>Send query</button>
								</div>
			</section>
        </div>
</main>
