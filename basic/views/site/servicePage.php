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
                        <h2><?php echo $servicePage[0]['title']; ?></h2>
                        <span><?php echo Html::decode($servicePage[1]['description']); ?></span>
                        <i>Avabillity for: <strong><?php echo ($servicePage[1][$i]['country'] && $servicePage[1][$i]['region']) ? $servicePage[1][$i]['region'] . ', ' . $servicePage[1][$i]['country'] : ($servicePage[1][$i]['country']) ? $servicePage[1][$i]['country'] : 'Any location'; ?></strong></i>
                    </div>
                    <div data-block="form">
                        <button data-svcLink="<?php echo $servicePage[0]['id']; ?>">
                            <?php
                                if($servicePage[2]['send'] != '' && $servicePage[2]['push'] != '' && $servicePage[2]['control'] != '' && $servicePage[2]['realtime'] != ''){ 
                                    if($svcSecure != 2){ echo 'Using this is service'; }
                                    else{ echo 'Sign in for service using'; }
                                }
                                else{
                                    if(!$servicePage[2]['send']){ $devInfo = 'Form not avaliabllity in service'; }
                                    else if(!$servicePage[2]['realtime']){ 
                                        if($svcSecure != 2){ $devInfo = 'Using this is service(Beta)'; }
                                        else{ $devInfo = 'Sign in for service using(Beta)'; }
                                    }
                                    else if(!$servicePage[2]['push'] || !$servicePage[2]['control']){ $devInfo = 'Service Form coming out'; }

                                    echo $devInfo;
                                }
                            ?>
                        </button>
                    </div>
                </div>
            </header>
            <main class="svcContent">
                <h3>Service terms</h3>
                <div><?php echo Html::decode($servicePage[1]['terms']); ?></div>
            </main>
            <footer class="svcFooter">
                <h3>FAQ</h3>
                <ul>
                    <?php for($i = 0; $i < count($servicePage[3]); $i++){ ?>
                        <li>
                            <div id="question"><h4><?php echo Json::decode($servicePage[3][$i]['question'], true)[0]; ?></h4></div>
                            <div id="answer" class="faq-answer-close"><?php echo Json::decode($servicePage[3][$i]['answer'], true)[0]; ?></div>
                        </li>
                    <?php } ?>
                </ul>
            </footer>
        </section>
 </main>
