<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

use app\models\News;

$this->title = 'News';
?>

<main class="main" style="background-color: #eff3f4;">
	 <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['news/index']); ?>" class="active">News</a>
     </section>
     <section class="section" id="news">
            <div class="news-feed">
                <header>
                    <h2 class="title">News</h2>
                    <div id="top-feed">
                        <div class="left-content">
							<header><?php echo Html::img($feed['firstLastNews']->titleImage, ['alt' => $feed['firstLastNews']->title]); ?></header>
                            <main>
                                <?php 
									preg_match_all('#<p[^>]*>(\X*?)</p>#', $feed['firstLastNews']->content, $matches);
									
									echo Html::a($feed['firstLastNews']->title, ['news/view', 'contentId' => $feed['firstLastNews']->id], ['id' => 'title']); 
									echo Html::tag('span', $matches[0],  ['id' => 'descript']);
								?>
                            </main>
                            <footer><?php echo Html::a('Show more', ['news/view', 'contentId' => $feed['firstLastNews']->id], ['id' => 'more']); ?></footer>
                        </div>
                    
						<div class="right-content">
                            <div class="last-feed-cont">
                                <div id="cont-content">
									<ul>
										<?php foreach($feed['rightLastNews'] as $rnf){ ?>
											<li>
												<?php
													preg_match_all('#<p[^>]*>(\X*?)</p>#', $rnf->content, $matches);
													
													echo Html::img($rnf->titleImage, ['alt' => $rnf->title]);
													echo Html::a($rnf->title, ['news/view', 'contentId' => $rnf->id]); 
													echo Html::tag('span', $matches[0]);
												?>
											</li>
										<?php } ?>
                                    </ul>
                                </div>
                            </div>
						</div>
					</div>
               </header>
               <main>
                    <div id="light-feed">
                        <div class="light-feed-cont">
                            <div id="cont-header">
                                <hr color="gray"  class="feed-header"/>
                                <span id="cont-title">Realty</span>
                            </div>
                            <div id="cont-content">
                                <ul>
                                    <li>
                                        <a href="">The United States is 'looking at' banning TikTok and other Chinese social media</a>
                                        <span>
                                            Pompeo suggested the possible move during an interview with Fox News...
                                        </span>
                                    </li>
                                    <li>
                                        <a href="">Black Friday as we know it is finally dead</a>
                                        <span>
                                            Thousands of shoppers gather sometimes as early as 5 pm Thanksgiving Day...
                                        </span>
                                    </li>
                                    <li>
                                        <a href="">The United States is 'looking at' banning TikTok and other Chinese social media</a>
                                        <span>
                                            Pompeo suggested the possible move during an interview with Fox News...
                                        </span>
                                    </li>
                                    <li>
                                        <a href="">Black Friday as we know it is finally dead</a>
                                        <span>
                                            Thousands of shoppers gather sometimes as early as 5 pm Thanksgiving Day...
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                   </div>
               </main>
               <footer>
                    <div id="down-feed">
						<?php for($i = 0; $i < count($feed['footerNews']); $i++){ ?>
							<div class="down-feed-cont">
								<div id="cont-content">
									<ul>
										<?php foreach($feed['footerNews'][$i] as $bnf){ ?>
											<li>
												<?php
													preg_match_all('#<p[^>]*>(\X*?)</p>#', $bnf->content, $matches);
													
													echo Html::img($bnf->titleImage, ['alt' => $bnf->title]);
													echo Html::a($bnf->title, ['news/view', 'contentId' => $bnf->id]); 
													echo Html::tag('span', $matches[0]);
												?>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
                    </div>
               </footer>
           </div>
    </section>      
</main>
