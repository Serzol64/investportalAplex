<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

$this->title = ':: Portal services';
?>

 <main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/services']); ?>">Services</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/service-page', ['id' => $servicePage[0]['id']]]); ?>" class="active"><?php echo $servicePage[0]['title']; ?></a>
        </section>
        <section class="section" id="service-page">
			<header class="svcMeta">
                <div data-group="metaData">
                    <div data-block="title">
                        <h2></h2>
                        <span></span>
                        <i>Avabillity for: <strong></strong></i>
                    </div>
                    <div data-block="form">
                        <button data-svcLink=""></button>
                    </div>
                </div>
            </header>
            <main class="svcContent">
                <h3>Service terms</h3>
                <div></div>
            </main>
            <footer class="svcFooter">
                <h3>FAQ</h3>
                <ul>
                        <li>
                            <div id="question"><h4></h4></div>
                            <div id="answer" class="faq-answer-close"></div>
                        </li>
                </ul>
            </footer>
        </section>
 </main>
