<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

$this->title = $servicePage[0]['title'] . ' :: Portal services';

$svcSecure = $servicePage[1]['private'] != 'public' ? isset($_COOKIE['portalId']) ? 1 : 2 : 0;
?>

 <main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/services']); ?>">Services</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/service-page', ['id' => $servicePage[0]['id']]]); ?>" class="active"><?php echo $servicePage[0]['title']; ?></a>
        </section>
        <section class="section" id="service-page">
			<header class="svcMeta">
                <div data-group="metaData">
                    <div data-block="title">
                        <h2><?php echo isset($offerPage['description']) ? $offerPage['title'] : $servicePage[0]['title']; ?></h2>
                        <span><?php echo isset($offerPage['description']) ? Html::decode($offerPage['description']) : Html::decode($servicePage[1]['description']); ?></span>
                    </div>
                    <div data-block="form">
				<?php if(!isset($servicePage[1]['isOffer'])){ ?>
                        <button data-svcLink="<?php echo $servicePage[0]['id']; ?>">
                            <?php
                                if($servicePage[2]['send'] != '' && $servicePage[2]['control'] != ''){ 
                                    if($svcSecure != 2){ echo 'Using this is service'; }
                                    else{ echo 'Sign in for service using'; }
                                }
                                else{
                                    if(!$servicePage[2]['send']){ echo 'Form not avaliabllity in service'; }
                                }
                            ?>
                        </button>
               <?php } ?>
                    </div>
                </div>
            </header>
            <main class="svcContent">
		<?php if(!isset($servicePage[1]['isOffer'])){ ?>
                <h3>Service terms</h3>
                <div><?php echo Html::decode($servicePage[1]['term']); ?></div>
        <?php } ?>
            </main>
            <footer class="svcFooter">
		<?php if(!isset($servicePage[1]['isOffer'])){ ?>
                <h3>FAQ</h3>
                <ul>
                    <?php for($i = 0; $i < count($servicePage[3]); $i++){ ?>
                        <li>
                            <div id="question"><h4><?php echo Json::decode($servicePage[3][$i]['question'], true)[0]; ?></h4></div>
                            <div id="answer" class="faq-answer-close"><?php echo Json::decode($servicePage[3][$i]['answer'], true)[0]; ?></div>
                        </li>
                    <?php } ?>
                </ul>
        <?php } ?>
            </footer>
        </section>
 </main>
