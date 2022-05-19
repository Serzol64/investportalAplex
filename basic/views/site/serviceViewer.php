<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $servicePage->title . ':: Portal services';
?>

 <main class="main" style="background-color:   #eff3f4;">
        <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/services']); ?>">Services</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['site/service-page', ['contentId' => $servicePage->id]]); ?>" class="active"><?php echo $servicePage->title; ?></a>
        </section>
        <section class="section" id="service-page-form">
			
        </section>
 </main>