<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

$this->title = $servicePage->title . ':: Portal services';
$infoContent = [JSON::decode($servicePage->proc, true), JSON::decode($servicePage->content, true), JSON::decode($servicePage->meta, true)];

$seoData = $infoContent[2]['seoData'];
$svcSecure = $infoContent[2]['accessRole'] != 'public' ? isset($_COOKIE['portalId']) ? 1 : 2 : 0;
?>

 <main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/services']); ?>">Services</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/service-page', ['contentId' => $servicePage->id]]); ?>" class="active"><?php echo $servicePage->title; ?></a>
        </section>
        <section class="section" id="service-page">
			<header class="svcMeta">
                <div data-group="metaData">
                    <div data-block="title">
                        <h2><?php echo $servicePage->title; ?></h2>
                        <span><?php echo $seoData['description']; ?></span>
                        <i>Organiation/Regulator: <strong>Investportal Team</strong></i>
                    </div>
                    <div data-block="form">
                        <button data-svcLink="<?php echo $servicePage->id; ?>">
                            <?php
                                if($infoContent[0]['send'] != '' && $infoContent[0]['push'] != '' && $infoContent[0]['control'] != '' && $infoContent[0]['realtime'] != ''){ 
                                    if($svcSecure != 2){ echo 'Using this is service'; }
                                    else{ echo 'Sign in for service using'; }
                                }
                                else{
                                    if(!$infoContent[0]['send']){ $devInfo = 'Form not avaliabllity in service'; }
                                    else if(!$infoContent[0]['realtime']){ 
                                        if($svcSecure != 2){ $devInfo = 'Using this is service(Beta)'; }
                                        else{ $devInfo = 'Sign in for service using(Beta)'; }
                                    }
                                    else if(!$infoContent[0]['push'] || !$infoContent[0]['control']){ $devInfo = 'Service Form coming out'; }

                                    echo $devInfo;
                                }
                            ?>
                        </button>
                    </div>
                </div>
            </header>
            <main class="svcContent">
                <h3>Service terms</h3>
                <div><?php echo HTML::decode($seoData['terms']); ?></div>
            </main>
            <footer class="svcFooter">
                <h3>FAQ</h3>
                <ul>
                    <?php foreach($seoData['faq'] as $faqR){ ?>
                        <li>
                            <div id="question"><h4><?php echo $faqR['question']; ?></h4></div>
                            <div id="answer"><?php echo HTML::decode($faqR['answer']); ?></div>
                        </li>
                    <?php } ?>
                </ul>
            </footer>
        </section>
 </main>
