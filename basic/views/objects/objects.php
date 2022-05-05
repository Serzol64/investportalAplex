<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

use app\models\ObjectsData;

$this->title = "Investment Objects and Projects";
?>
<main class="main" style="background-color:   #eff3f4;">
	 <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="#">Investment Objects</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/index']); ?>" class="active">Investment Objects and Projects</a>
     </section>
     <section class="section" id="objects">
        <div class="projects-search-form">
		<header>
                    <div id="left-content">
                        <span class="title objects-header">Investment Objects and Projects</span>
                    </div>
                    <div id="right-content" class="objects-close">
                        <a href="" class="close"><img src="https://img.icons8.com/material-sharp/24/000000/delete-sign.png"/></a>
                    </div>
                </header>
                <main>
                    <form action="" method="get">
                        <h4>Object Type</h4>
                        <?php
							for($i = 0; $i < count($attrs); $i++){	
								if($attrs[$i]){
						?>
                        <div class="selectors" for="types">
							<?php 
									foreach($attrs[$i] as $get){
							?>
								<label class="selector">
									<?php if(ObjectsData::find()->where(['category' => $get->name])->exists()){ ?><input type="checkbox" name="types" id="type-selector" value="<?php echo $get->name; ?>" /><?php } else { ?><input type="checkbox" name="types" id="type-selector" value="<?php echo $get->name; ?>" disabled /><?php } ?>
									<span><?php echo $get->name; ?></span>
								</label>
                            <?php } ?>
                        </div>
                        <?php } } ?>
                    </form>
                </main>
                <footer class="objects-foot">
                    <div id="left-content">
                        <div class="filter">
                            <div class="option">
                                <span>Country</span>
                                <select name="country" id="option-selector" onchange="regionAutoList(this)">
                                    <option value="any">All Countries</option>
                                    <?php
									$countriesList = Yii::$app->regionDB->getFullDataFrame();
									for($i = 0; $i < count($countriesList); $i++){ 
										$curC = $countriesList[$i];
										echo '<option value="' . $curC['code'] . '">' . $curC['title'] . '</option>';
									}
									?>
                                </select>
                            </div>
                            <div class="option">
                                <span>Region</span>
                                <select name="region" id="option-selector" disabled>
                                    <option value="any">All Regions</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="parameters">
                                <span>Profitability</span>
                                <div class="parameter-form">
                                    Profitability from 
                                    <input type="text" name="profitability-from" id="text-from" value="0%">
                                    to
                                    <input type="text" name="profitability-to" id="text-to" value="100%">
                                </div>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="parameters">
                                <span>Cost</span>
                                <div class="parameter-form">
                                    Cost from 
                                    <input type="text" name="cost-from" id="text-from" value="$100">
                                    to
                                    <input type="text" name="cost-to" id="text-to" value="$10 000 000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="left-content-add">
                        <button class="add-but">Show objects</button>
                    </div>
                </footer>
        </div>
        <div class="objects-list">
			 <header>
                    <h2>Similar Offer</h2>
                </header>
                <main>
                    <table>
                        <thead>
                            <tr class="header">
                                <th>Location</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Expert Raiting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="content">
                                <td>Spain</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain, Barcelona</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain, Barcelona</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain,Madrid</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>France</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain, Barcelona</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain, Barcelona</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>France</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td>Spain, Barcelona</td>
                                <td><a href="">Apartamentos Central Park</a></td>
                                <td>$ 15 000 000</td>
                                <td>
                                    <div class="rating-mini">
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span> 
                                        <span class="active"></span>	
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span class="active"></span>    
                                        <span class="active"></span>
                                        <span></span>    
                                        <span></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </main>
            </div>
     </section>
        
</main>
