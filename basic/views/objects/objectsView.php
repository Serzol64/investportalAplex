<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$phone = trim($contactData->phone);
 
$contactPhone = preg_replace(
		array(
			'/[\+]?([0-9])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
			'/[\+]?([0-9])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
			'/[\+]?([0-9])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
			'/[\+]?([0-9])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',	
			'/[\+]?([0-9])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
			'/[\+]?([0-9])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',					
		), 
		array(
			'$1 ($2) $3-$4-$5', 
			'$1 ($2) $3-$4-$5', 
			'$1 ($2) $3-$4-$5', 
			'$1 ($2) $3-$4-$5', 	
			'$1 ($2) $3-$4', 
			'$1 ($2) $3-$4', 
		), 
		$phone
);
	
	
$this->title = $objectDF->title . " :: Investment objects";
?>
<main class="main" style="background-color:   #eff3f4;">
	 <section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="#">Investment Objects</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['objects/view', ['contentId' => $contentId]]); ?>" class="active"><?php echo $objectDF->title; ?></a>
	 </section>
	<section class="section" id="objects">
			<div class="object-viewer">
                <div class="left-content">
                    <header>
                        <button class="add-but">
                            <img src="https://img.icons8.com/windows/32/ffffff/horizontal-settings-mixer--v1.png" style="width:20%;vertical-align:middle;transform: rotate(90deg);"/>
                            Object filter
                        </button>
                        <h2 class="view-title"><?php echo $curObj->title; ?></h2>
                        <div id="object-meta">
                            <div class="title">
                                <span class="view-title">Object</span>
                                <div class="docs">
                                    <img src="../images/icons/pdf.jpg" alt="" class="doc-icon">
                                    <a href="" download="">Download prensetation</a>
                                </div>
                            </div>
                            <div class="metadata">
                                <div>COUNTRY — <span><?php echo Json::decode($metaData['meta']['region']); ?></span></div>
                                <div>COST, USD — <span><?php echo Json::decode($metaData['meta']['cost']); ?></span></div>
                                <div>PROFITABLENESS — <span><?php echo Json::decode($metaData['meta']['profitableness']); ?></span></div>
                            </div>
                        </div>
                        <div class="object-contacts">
                            <div class="contact">
                                <img src="../images/icons/user.svg" alt="">
                                <span><?php echo $contactData->firstname . ' ' . $contactData->surname; ?></span>
                            </div>
                            <div class="contact">
                                <img src="../images/icons/phone.svg" alt="">
                                <span><?php echo $contactPhone[0]; ?></span>
                            </div>
                            <div class="contact">
                                <img src="../images/icons/mail.svg" alt="">
                                <?php echo Html::a($contactData->email, 'mailto:' . $contactData->email . '&subject=Message to the InvestPortal user'); ?>
                            </div>
                        </div>
                   </header>
                   <main><span class="view-title">Specifications</span> <table class="specifications"><tbody><?php foreach($metaData['parameters'] as $result){ ?><tr><td><?php echo Json::decode($result['filter']); ?></td><td><?php echo Json::decode($result['value']); ?></td></tr><?php } ?></tbody></table></main>
                   <footer><a href="" id="more">Show more</a></footer>
               </div>
               <div class="right-content">
                    <header>
                        <div class="add-to-favorite">
                            <i class="far fa-star"></i>
                            <a href="">Add to Favorites</a>
                        </div>
                        <div class="description">
							<span><?php echo $metaData['meta']['description']; ?></span>
                            <a href="">Show more</a>
                        </div>
                   </header>
                   <main>
                        <span class="view-title"><span style="vertical-align:middle;font-size:90%;padding-right:1%;display: inline-block;margin-top: -5px;">&#9632;</span>Photos</span>
                        <div id="images-slider">
                            <div class="header">
                                <header class="switcher"><img src="/images/icons/slider-contorls/back.png" alt=""></header>
                                <footer class="switcher"><img src="/images/icons/slider-contorls/go.png" alt=""></footer>
                            </div>
                            <div class="content"><img src="" alt="Current Image" id="current"></div>
                            <div class="footer"><?php foreach($metaData['meta']['photo'] as $gallery){ ?><div class="image-switcher"><img src="<?php echo Json::decode($gallery['file']); ?>" alt="Switcher image" class="image-current"></div></div>
                       </div>
                  </main>
                  <footer>
                        <span class="view-title"><span style="vertical-align:middle;font-size:90%;padding-right:1%;display: inline-block;margin-top: -5px;">&#9632;</span>Video</span>
                        <video class="view-player" poster="<?php echo $metaData['meta']['videoPoster']; ?>" loop><?php foreach($metaData['meta']['video'] as $support){ ?><source src="<?php echo Json::decode($support['file']); ?>" type="<?php echo mime_content_type(Json::decode($support['file'])); ?>"><?php } ?></video>
                         <div class="video-player">
                            <header class="play">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAD2UlEQVRYhe2WTWwbVRDHf/PsOEEipUQ9pCQRkNppFQRI2fiQG5z4aIkb9dgLqlScRCU9pG24AOaWRkK0BX8hPi5FHCqauCgIxAFuqMSmBdQKx06rqoGChApRODT2eodDTFTFXm8CiAv5X3a1b3bmN7Ozbx5s6f8u2YxxOF7sUkME0b3AQ0BXdekmynUMsz5D5uLh0OK/CjCQzHeURV4BOQT4PcwdgY9s23f80pHuG/8YoD9RGMRwFmgFSsA0KjOofal078oiQOCP5k6M6QOJAENAAFgWODg3HPr4bwNYqeKLgp4CjMA58VUmvj6853qjd8KJ+W71yRTKAcBB5Wh2JPjWpgGqmU8DinI8OxJ6o1HgGvh0cVxUTwIisN+tEqbew4FkvqNadrM+uJUqxAfeudLmBZCLBl9XkQnAKJy10ld3bhigLOY1oFXg3PrMBUbLdqBgpefHrHS2yQsC5DywTdQf2xBAOF7sAp4HSuKrTLj4bhOV06L3fdefWni2EYSKngBKIIcGkvkOTwA1RAAfMN2o4RSuAnvAmQ2nCp+G3y48Us8uFw0tCGQAvy0m4gkAWs1IM27BAVp/XnxckTHgtsJT6nDZShXiVjq/ow5tZvUiNdWqrYAQBHAqZq4RwJexJ+3ccPDNFScQFDjJ6gY0KmoKVqowETxTaF7zqZVs9TboCSDQDnBPi/1LI4C/9P3og7/NDYdeEkMf8DmwXWBye4C1/mhu5qcqygOeAP+16u3rt4DWcqVpJ7Ds5eDRxI37W6QcU0dHq/5+V5hcKnGqOLZrBeCOLR0CINQMqVoAZQGhx3EqFjDvFviJ2Bf+5fauEaEUU2gDbIUE4ryai+7+9W5b4xhLBVC55g1gmEV5pjpYPnQDWG7v/FbQ3tXE+AzDePaF0JW6xkIEQEVna8Otk8+QAWxgKJyY73YDEOgFfgCzd2449PScS/C+eDGoEAHsgONc8AS4eDi0qPA+EFCfTLnEv62iR1WWHssO7/rEDRJAfM4UEEDk3a9Gdv/oCQDglCsxYBnlgJUujt+9ppBo8pdCuWjPmVy0v9woeDhVPCbIELAktq/uLHAdx+FU4TmFGUBVZGJ1sGxc4VTxmKKTgKjoYC7aU/P9GwIA9CeLRxA9DRiQ8yp6IhcNLTR6py9eDIrPmapm7iCMZaOhuJu955GsLzm/z4h8AGwDSgIZR3QG9Js7tr0I0OL3d1Z/tf2sNlwTsKSiB90y3zAAgJXO7zCO72WVtc2mkWzQ91TsWC7ae8vL96aO5QPJfEfJmEFR3YfIw2j1WC7cROWais4GHOdCvW7f0pbc9CfcInoOOTgJHQAAAABJRU5ErkJggg==" alt="Нажмите для воспроизведения видеоролика" />
                            </header>
                            <main class="controls">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAC8ElEQVRYhe2WTW9TRxSGn3euMUglrNi0IVKJ7BJ1GceL/AVAmIjusqmQIpMWWonPFVXYFVREK9Wx00VX7QqRYKr8hqqN3SyrJDcgRIBu+ZAgzvUcFjaqFDu5ie0deTczunNm3mfuPXfmwJ4+dGk3wdlCOGCOHLITwKfAQHPoCcYjHPOBo/zXRHqtpwCjxaX+Dek70FkgERPuBfeiKLiyeH7wcdcAI9Mrp3D8BvQBNWAO030sWqwdXF8DSL7efwTnhkE5YAxIAq8E4wvn0n90DJAphReE/Qg4wV0F9Wt/Tww92m5Odnp50ALdwjgDeEzfViZTP+8aoLnzOcAwrlQm03e2M26BnwkvyewmIMHprd5EW4DGN3f/An0YF3drvgniB+ClaWOomv/8+eYY127ihtwNoE9wt1NzgGo+dRs0CxySJabaxbQAZAvhAPAlUFNQv7Z5fKS0YiOlFdvpc5NdBWqgs6PFpf5YAHPkgACYi0u4naiaT68KykAiksvFAoAdb7blbs3/X5Jyo9HxWAATKQBfdws987d6pdlNxQIIPgZYZ/2/XgG8sfrTJkp8DgAtidStDtaT7338TgCeA3y078AnvQKI9vvGWuJpPICxCuB9PdMrAOddYy3Tw3gAx3yjo5ZfpmOJXMPf5mMBAkcZiICx7PTyYLfew4UwZZADoqT3D1rZ2ihTWvlFMIG4V8mnv+gGIFNanhUaQ5qp5FPnNo+3vQv8Rn0KeIVxJjMTXurUPFsKLwuNAS8UBTu7CwAWLww9E4wDXmY3O4HIlsLLhn0PeJONL3x9tO25sm1BMlIMzyP7qQGqWZNdrebTq9vNGS6EKQX+VnPnHvFNJZ8ubBUfW5INF5dPOul34BBQE5S97D7YP2+jaA3gQCJxxHmXMXGaRsLtA16YbLya/6wl83cFAJCZWTrsfHDdZF8RX5RGYL+aoql2BUhHAO81Wlzqrzl3SmYnkY5izbJcPMH00GTzSe8f/Dl5rOXE29OettI73qkbdiAWJz4AAAAASUVORK5CYII=" alt="Поставить на паузу" class="pause watching">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAACK0lEQVRYhe1XwWoTURQ9N28S+wOTbBNNxAQbCLZ0W5LWP/ADLEgaKvULhKJ/UMSxFFLX/YS0qW6lkUBa0uKMTXfaDrhyYeNMr4vOQB+ZBBF6VsPjvnvOPXfmvjfALf535A0rHmZ/JCx5lLgWJocWhjxGXAeQDSNgJAeukT8MQz6SgHGSDy1gbvMkESX+4JEfymLzhhWfNaxXWGMph7KAuc2ThOO6ewTkAByQqy3KyGPEdSZ+OZv4uhZaQN6w4q7r7hKQA+GIXO1xUk/aQbGFqqnHiHdx5dIxLsVbWe6/voIn2yw6Pyynd5X9hwM3ilKznLKT2yz6985vdaZ+Xjh7Hvlhl6nUWkmdywSovwNe5c2lTGDlAPDxaeoXmN94sYutSlpKDsjngNtYzgw9JxqV+xvpdfO9tZq6UIkPNQlvgrWaUSIHQkzCQZh5Z3L/WmM5Q/1rE3FgGEzMgaBqgzARB9Lr5h3VWJkDoqePhCNytOL+Suq7LOGM8aWMCF482miXPpdz3wYJUHeAkWXh1ApVU78pZH6rMwWi52BkiaM1lcuKUp96TkDPiaSetL2J2TMvClVTF13UAUwDOGb6XZQ5oeRAq5I+F0IsMND2nTi1TwOdaC5l7C7TAq5OyweRy1hFllu5BZ+e3T3ThCgy0AYwzcLZkQnuMpWI6fX+2T3paajUgusIuJCMNLJ9DP0Z+tVhwIVkYgLGLWLkQeSL4DE5MTLC/pjc4p/jD3Qb2ri+v6ADAAAAAElFTkSuQmCC" alt="Выключить звук" class="sound watching">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAB7UlEQVRYhe2Wz2rbQBDGv80qBoOvTXw1xMVlIVCQyLEo7Tv4FWpE38EP0OuiQCD3vENc9y5DoWWJW4XoVDA5GwKKhu3BUpAV+Y/UjU/+TtKi2fkx880gYK+9aur9VfjGxD0HdYJO/bsjHmNkAsCqGuDIqK1ZMgbQMwFQqQJnl/fHmic3ppJXAji7vD8mohEAYSr51gCOjNpE9D1NPt0pwHLZ2W96oo8mAV6Y0L4Idf6diLLHKSPu/vhyMrMvwpUXCqlayhPzTWeZtvMAwy0jyw28zmzdZ7YfDpu8ETgyamdnjozaTd4IbD8clsWsHMPJ5y7bCi6VkKoFhj6AnubJ2JGRCwCapyPL0BdSfS1WotYiKpPyxJyR5WJh0p7myfg5OTBlZLllbTAGAACB15nFmn0AoNLEz8Zd1T6jAADQtA4KrdNrW2kUoGRfTAG85Yd8lDfmqwAIqVrFnhc9IaRqFeNWTsHSPmC4ZYl1vm4MlSfmth9eg6GfH1lHRq7myRga1/VNqPEuHa3SMmaaDLrDR4qdPGjgdWaPFDuTQbd0D2yc9VP/7qjB9Dcs+vqHnsjlh/wvUH1XlGljBX4OTh4YWZ+QM9T/Jq0EAJTO924BgEUlYs3OU4jdA2QQuXbsHgBYascvUxC1ZOq3fK+9/gG08dndgzF6CAAAAABJRU5ErkJggg==" alt="Включить звук" class="nosound watching">
                            </main>
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
					<?php
					foreach($dataset['all'] as $list){
						$objectQuery = [':id' => $list->id];
						$currentObject = Yii::$app->db->createCommand('SELECT title, JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.region.country")) as "country", JSON_UNQUOTE(JSON_EXTRACT(content, "$.meta.region.region")) as "region", JSON_UNQUOTE(JSON_EXTRACT(content, "$.content.cost[0].value")) as "cost" FROM objectData WHERE id=:id')->bindValues($objectQuery)->queryOne();
					?>
                            <tr class="content">
                                <td><?php echo ($currentObject['country'] && $currentObject['region']) ? $currentObject['region'] . ', ' . $currentObject['country'] : ($currentObject['country']) ? $currentObject['country'] : 'Any location'; ?></td>
                                <td><?php echo Html::a($currentObject['title'], ['objects/view', 'objectId' => $objectQuery[':id']]); ?></td>
                                <td>
									<?php
										$listQuery = ['type' => 'list'];
										$dataCurrency = Yii::$app->currencyDB->execute($listQuery);
											
											
										for($i = 0; $i < count($dataCurrency); $i++){
											if(isset($_COOKIE['servicesCurrency'])){
												if($_COOKIE['servicesCurrency'] == $dataCurrency[$i]['currency']){ 
													$convertQuery = [
														'myCur' => $dataCurrency[$i]['currency'],
														'amount' => $currentObject['cost']
													];
													
													$convertResponse = Yii::$app->currencyDB->execute($convertQuery);
													
													$amountQuery = [
														'isSymbol' => TRUE,
														'query' => [
															'cur' => $dataCurrency[$i]['currency'],
															'amount' => $convertResponse['data'][$dataCurrency[$i]['currency']]['value']
														]
													];
													
													echo Yii::$app->currencyDB->getFullAmount($amountQuery);
												}
											}
											else if($dataCurrency[$i]['selected'] == 'Yes'){ 
												$convertQuery = [
														'myCur' => $dataCurrency[$i]['currency'],
														'amount' => $currentObject['cost']
													];
													
													$convertResponse = Yii::$app->currencyDB->execute($convertQuery);
													
													$amountQuery = [
														'isSymbol' => TRUE,
														'query' => [
															'cur' => $dataCurrency[$i]['currency'],
															'amount' => $convertResponse['data'][$dataCurrency[$i]['currency']]['value']
														]
													];
													
													echo Yii::$app->currencyDB->getFullAmount($amountQuery);
											}
										}
									?>
                                </td>
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
                    <?php } ?>
                        </tbody>
                    </table>
                </main>
			</div>
			<section id="services" data-text="Service" class="section">
				<header>
					<hr color="#0079bf" size="4" width="37px" align="left"/>
					<h2>Services</h2>
					<strong>& Collaborations</strong>
					<a href=""></a>
					<button class="add-but">Add Object</button>
				 </header>
				 <main>
						<header id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
						<header id="slider-controller"><img src="/images/icons/slider-contorls/back.png" alt="Назад"></header>
						<main id="slider-view-adaptive">
						<?php for($i = 0; $i < count($serviceList['mobile']); $i++){ ?>
							<div class="service">
								<?php
									$scd = new app\models\PortalServicesCategory;
									$currentTitleImage = $scd::findOne(['id' => $serviceList['mobile'][$i]['cat']])->icon;
									$currentCategory = $scd::findOne(['id' => $serviceList['mobile'][$i]['cat']])->name;
									
									$titleImage = $currentTitleImage;
									$location = ($serviceList['mobile'][$i]['country'] && $serviceList['mobile'][$i]['region']) ? $serviceList['mobile'][$i]['region'] . ', ' . $serviceList['mobile'][$i]['country'] : ($serviceList['mobile'][$i]['country']) ? $serviceList['mobile'][$i]['country'] : 'Any location';
									$description = strlen(strip_tags(htmlspecialchars_decode($serviceList['mobile'][$i]['description']))) > 234 ? mb_strimwidth(strip_tags(htmlspecialchars_decode($serviceList['mobile'][$i]['description'])), 0, 234, '...') : strip_tags(htmlspecialchars_decode($serviceList['mobile'][$i]['description']));
								?>
								<div class="service-content">
									<header><h3><?php echo $currentCategory; ?></h3></header>
									<main><img src="<?php echo $titleImage; ?>" alt="<?php echo $serviceList['mobile'][$i]['title']; ?>"></main>
									<footer>
										<h4 class="title"><?php echo $serviceList['mobile'][$i]['title']; ?></h4>
										<span class="location"><?php echo $location; ?></span>
										<p class="descr"><?php echo $description; ?></p>
									</footer>
								</div>
							</div>
						<?php } ?>
						</main>
						<main id="slider-view">
							<div class="service-feed">
							<?php for($i = 0; $i < count($serviceList['desktop']['last']); $i++){ ?>
								<div class="service">
									<?php
										$scd = new app\models\PortalServicesCategory;
										$currentTitleImage = $scd::findOne(['id' => $serviceList['desktop']['last'][$i]['cat']])->icon;
										$currentCategory = $scd::findOne(['id' => $serviceList['desktop']['last'][$i]['cat']])->name;
										
										$titleImage = $currentTitleImage;
										$location = ($serviceList['desktop']['last'][$i]['country'] && $serviceList['desktop']['last'][$i]['region']) ? $serviceList['desktop']['last'][$i]['region'] . ', ' . $serviceList['desktop']['last'][$i]['country'] : ($serviceList['desktop']['last'][$i]['country']) ? $serviceList['desktop']['last'][$i]['country'] : 'Any location';
										$description = strlen(strip_tags(htmlspecialchars_decode($serviceList['desktop']['last'][$i]['description']))) > 234 ? mb_strimwidth(strip_tags(htmlspecialchars_decode($serviceList['desktop']['last'][$i]['description'])), 0, 234, '...') : strip_tags(htmlspecialchars_decode($serviceList['desktop']['last'][$i]['description']));
									?>
									<div class="service-content">
										<header><h3><?php echo $currentCategory; ?></h3></header>
										<main><img src="<?php echo $titleImage; ?>" alt="<?php echo $serviceList['desktop']['last'][$i]['title']; ?>"></main>
										<footer>
											<h4 class="title"><?php echo $serviceList['desktop']['last'][$i]['title']; ?></h4>
											<span class="location"><?php echo $location; ?></span>
											<p class="descr"><?php echo $description; ?></p>
										</footer>
									</div>
								</div>
							<?php } ?>
                    </div>
                    <div class="service-feed" id="hide">
                        <?php for($i = 0; $i < count($serviceList['desktop']['prelast']); $i++){ ?>
                        <div class="service">
							<?php
								$scd = new app\models\PortalServicesCategory;
								$currentTitleImage = $scd::findOne(['id' => $serviceList['desktop']['prelast'][$i]['cat']])->icon;
								$currentCategory = $scd::findOne(['id' => $serviceList['desktop']['prelast'][$i]['cat']])->name;
								
								$titleImage = $currentTitleImage;
								$location = ($serviceList['desktop']['prelast'][$i]['country'] && $serviceList['desktop']['prelast'][$i]['region']) ? $serviceList['desktop']['prelast'][$i]['region'] . ', ' . $serviceList['desktop']['prelast'][$i]['country'] : ($serviceList['desktop']['prelast'][$i]['country']) ? $serviceList['desktop']['prelast'][$i]['country'] : 'Any location';
								$description = strlen(strip_tags(htmlspecialchars_decode($serviceList['desktop']['prelast'][$i]['description']))) > 234 ? mb_strimwidth(strip_tags(htmlspecialchars_decode($serviceList['desktop']['prelast'][$i]['description'])), 0, 234, '...') : strip_tags(htmlspecialchars_decode($serviceList['desktop']['prelast'][$i]['description']));
							?>
                            <div class="service-content">
                                <header><h3><?php echo $currentCategory; ?></h3></header>
                                <main><img src="<?php echo $titleImage; ?>" alt="<?php echo $serviceList['desktop']['prelast'][$i]['title']; ?>"></main>
                                <footer>
                                    <h4 class="title"><?php echo $serviceList['desktop']['prelast'][$i]['title']; ?></h4>
                                    <span class="location"><?php echo $location; ?></span>
                                    <p class="descr"><?php echo $description; ?></p>
                                </footer>
                            </div>
                        </div>
						<?php } ?>
                    </div>
                    <div class="service-feed" id="hide">
						<?php for($i = 0; $i < count($serviceList['desktop']['old']); $i++){ ?>
                        <div class="service">
							<?php
								$scd = new app\models\PortalServicesCategory;
								$currentTitleImage = $scd::findOne(['id' => $serviceList['desktop']['old'][$i]['cat']])->icon;
								$currentCategory = $scd::findOne(['id' => $serviceList['desktop']['old'][$i]['cat']])->name;
								
								$titleImage = $currentTitleImage;
								$location = ($serviceList['desktop']['old'][$i]['country'] && $serviceList['desktop']['old'][$i]['region']) ? $serviceList['desktop']['old'][$i]['region'] . ', ' . $serviceList['desktop']['old'][$i]['country'] : ($serviceList['desktop']['old'][$i]['country']) ? $serviceList['desktop']['old'][$i]['country'] : 'Any location';
								$description = strlen(strip_tags(htmlspecialchars_decode($serviceList['desktop']['old'][$i]['description']))) > 234 ? mb_strimwidth(strip_tags(htmlspecialchars_decode($serviceList['desktop']['old'][$i]['description'])), 0, 234, '...') : strip_tags(htmlspecialchars_decode($serviceList['desktop']['old'][$i]['description']));
							?>
                            <div class="service-content">
                                <header><h3><?php echo $currentCategory; ?></h3></header>
                                <main><img src="<?php echo $titleImage; ?>" alt="<?php echo $serviceList['desktop']['old'][$i]['title']; ?>"></main>
                                <footer>
                                    <h4 class="title"><?php echo $serviceList['desktop']['old'][$i]['title']; ?></h4>
                                    <span class="location"><?php echo $location; ?></span>
                                    <p class="descr"><?php echo $description; ?></p>
                                </footer>
                            </div>
                        </div>
						<?php } ?>
                    </div>
						</main>
						<footer id="slider-controller-adaptive"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer>
						<footer id="slider-controller"><img src="/images/icons/slider-contorls/go.png" alt="Вперёд"></footer> 
				 </main>
			</section>
	</section>
</main>
