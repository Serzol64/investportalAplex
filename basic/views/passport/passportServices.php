<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

use app\models\ObjectAttribute;

$this->title = "Services for Investors";
?>
<main class="main" style="background-color:   #eff3f4;">
	<section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['passport/service']); ?>" class="active">Passport</a>
	</section>
	<section class="section" id="passport">
		<div class="passport-page">
                <header>
                    <div id="left-content">
                        <span>My services for investors</span>
                    </div>
                    <div id="right-content">
                        <a href="">Exit</a>
                        <nav>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAbklEQVRIie2SMQ6AIAxFuYREjwjHhcHjPAcZCGkaxRod+tbS1/TTEBznDkAE0pvyykm2li9AafIdWF3+YzmQgKjU+2up2lupOWuNj+RNMK6+KbW5zKUh5h8qRDEfy8VN7E9xGGIv74ZEs1icTzgAJ5w0Gqu97rMAAAAASUVORK5CYII=" id="save" alt="Ok" />
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAn0lEQVRIid2Uuw0CMRBER4jsWqAFCoEqLnJdJ5oix9RA+ohOOp0W2PUnMBNZq5kd78eW/g7AFcjEkYGLx6Ak+YqHxwCAgspN3SGaKIqhDBYXKzoDYLbOLQ0AbsAUEUQNAO7AucrA8Q5eQNpqum/Rx1tG+U1a9IXfdch913SjW1y6CgNTN9RfZOJoxJ6STiVtkpT3AauCZBGdydNP1nB4A5tWVezafhVfAAAAAElFTkSuQmCC" id="exit" alt="Exit" />
                        </nav>
                    </div>
                </header>
                <main>
                    <div id="left-content">
                       <form action="" method="post" class="services-settings">
                            <header for="country">
                                <span>Country</span>
                                <select name="country">
                                    <option value="any">Any Countryes</option>
                                    <?php
										$countriesList = Yii::$app->regionDB->getFullDataFrame();
										for($i = 0; $i < count($countriesList); $i++){ 
											$curC = $countriesList[$i];
											
											if($curC['code'] == $ud_data){ echo '<option value="' . $curC['code'] . '" selected>' . $curC['title'] . '</option>'; }
											else{ echo '<option value="' . $curC['code'] . '">' . $curC['title'] . '</option>'; }
										}
									?>
                                </select>
                                <h3 style="color: black;font-weight: normal;font-size: 80%;">Selection of the country</h3>
                            </header>
                            <footer>
								<?php
									$inputQuery = [1, 5];
									
									$strCount = ObjectAttribute::find()->count();
									$strPart = ceil($strCount / $inputQuery[1]);
									
									if($strPart > 1){ 
										for($i = $inputQuery[0]; $i < $strPart; $i++){ 
											$strs = ($i * $inputQuery[1]) - $inputQuery[1];
											$getAttr = ObjectAttribute::find()->limit($strs, $inputQuery[1])->all();
								?>
											<div class="services-selectors" for="types">
												<?php foreach($getAttr as $attr){ ?>
													<label class="selector">
														<input type="checkbox" name="types" value="<?php echo $attr->name; ?>" <?php echo array_search($attr->name, array_column($sd_data, 'service')) ? 'checked' : ''; ?>>
														<span><?php echo $attr->name; ?></span>
													</label>
												<?php } ?>
											</div>
									<?php 
										} 
									}
									else{
										$getFirstAttr = ObjectAttribute::find()->limit(5)->all();
									?>
										<div class="services-selectors" for="types">
											<?php foreach($getFirstAttr as $fattr){ ?>
												<label class="selector">
													<input type="checkbox" name="types" value="<?php echo $fattr->name; ?>" <?php echo array_search($attr->name, array_column($sd_data, 'service')) ? 'checked' : ''; ?>>
													<span><?php echo $fattr->name; ?></span>
												</label>
											<?php } ?>
										</div>
									<?php } ?>
                            </footer>
                       </form>   
                    </div>
                    <div id="right-content">
                       <ul class="nav">
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/profile">Passport</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport">My investment requests</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/offers">My offers for investors</a></li>
                           <li class="active"><i class="fas fa-circle active-link"></i><a href="/passport/services">My services for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/cart">My shopping Cart</a></li>
                       </ul>
                    </div>
                </main>
                <footer>
                    <div id="left-content">
                        <button class="add-but" style="width: 90px;">Ok</button>
                    </div>
                </footer>
            </div>
	</section>
</main>
