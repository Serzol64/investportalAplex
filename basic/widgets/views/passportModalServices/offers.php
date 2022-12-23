<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<main id="lightbox" class="lightbox-closed">
        <div class="lightwin-passport lightbox-closed" id="offer">
            <header>
                <div id="left-content">
                    <span>New investment object</span>
                </div>
                <div id="right-content">
                    <a href="" class="close"><img src="https://img.icons8.com/material-sharp/24/ffffff/delete-sign.png"/></a>
                </div>
            </header>
            <main>
                <form action="#" method="post">
                    <label for="object">Name of the investment object</label>
                    <input type="text" name="object" class="title" id="textput">
                    <label for="type">Type of investment object</label>
                    <select name="type" id="selector-form">
						<?php foreach($datasets[0] as $attrList){ ?><option value="<?php echo $attrList->name; ?>"><?php echo $attrList->name; ?></option><?php } ?>
                    </select>
                    <label for="country">Country</label>
                    <select name="country" id="selector-form">
						<option value="any">Any Country</option>
						<?php
						$countriesList = Yii::$app->regionDB->getFullDataFrame();
						for($i = 0; $i < count($countriesList); $i++){ 
							$curC = $countriesList[$i];
							echo '<option value="' . $curC['code'] . '">' . $curC['title'] . '</option>';
						}
						?>
                    </select>
                    <label for="cost">Offer cost(in USD)</label>
                    <input type="text" name="cost" id="textput" class="offer" placeholder="Example: 1000000">
                </form>
            </main>
            <footer>
                <div id="left-content">
                    <div class="selectors" style="margin-top: -4%;">
                        <label id="selector">
                            <input type="checkbox" name="actively" id="selector-check" value="Run" checked>
                            <span>Actively</span>
                        </label>
                        <label id="selector">
                            <input type="checkbox" name="mail-notify" id="selector-check" value="Subscribe" checked>
                            <span>Notify by e-mail suitable objects appear</span>
                        </label>
                    </div>
                </div>
                <div id="left-content-plus">
                    <button class="add-but" data-control="default">Add Request</button>
                </div>
            </footer>
        </div>
        <div class="lightwin-passport-regional" id="offer">
            <header>
                <div id="left-content">
                    <span>Selection of the country</span>
                </div>
                <div id="right-content">
                    <a href="" class="close"><img src="https://img.icons8.com/material-sharp/24/000000/delete-sign.png"/></a>
                </div>
            </header>
            <main>
                <form action="" method="post">
					<?php
					$countriesList = Yii::$app->regionDB->getFullDataFrame();
					for($i = 0; $i < count($region); $i++){
					?>
						<div class="countries-part" for="countries">
							<?php for($k = $region[$i][0]; $k < $region[$i][1]; $k++){ ?>
								<label>
									<input type="checkbox" name="countries" id="country-selector" value="<?php echo $countriesList[$k]['code']; ?>" />
									<span class="country-name"><?php echo $countriesList[$k]['title']; ?></span>
								</label>
							<?php } ?>
						</div>
                    <?php } ?>
                </form>
            </main>
            <footer>
                <div id="left-content"><button class="add-but" data-control="region" style="padding-left: 30px;padding-right: 30px;">Ok</button></div>
            </footer>
        </div>
 </main>
<section class="passport-menu-adaptive">
        <center>
          <ul class="nav">
               <li><a href="<?php echo Url::to(['passport/accountedit']); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABk0lEQVRIidWVvVIUQRSFv0YhWikegMSylpAFeQfKjAUtC57CgJ+YUIEMAx8DHwRTflaNLGOFBNiSz2B6txqm52dDTlUnc8859/aZnml46gh1RXUGWAfWgNfAfCz9Ar4BJ8BJCOFu4s7qW/WHzfiubkxi/Ew9yhjdqxdx3Wfqh+pUmwY583N1MeH0YqPHOGgTy2P8U3sZbq9iJ/0q85mYZ2n6moFyu/hpcTgASDNbB15lfGpPWgYvKU5dqcFamQtAtyKiJaBboSl7VWx3hIu0ibqkXtbwx7GGRHQFvKiYCEBgMNoV9dFdhxBmAZ4nD5uyDsBCAycdBnj4Dn63FLfB2CttcJoh/gG+AJsUsXTi6gJbsfY3oyt7qe+Tl3Sj7qqdplHVjroXNSO8yxHTD+24yTij/xy1A3W6irQRSXfq6gTmb9Rh1FZ9T2PyYSQO1X1r/pBqUD+ot1Hzsc00U+pBkueZuq0uq3NxLas7sTbCp7phco36Mc8mDOpiaboyp4E+xb9lhYdX5inFlfk1hDBsPfmTw38lGWaVIbcvxgAAAABJRU5ErkJggg==" alt="Passport" /></a></li>
               <li><a href="<?php echo Url::to(['passport/service']); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAb0lEQVRIie3PQQqAIBSEYYnO0YE6iOdo2SWjhd3jb+NKhMYpKMJZCT7ne4bwuwAzkLjO4gJK+W4jQjnABGz5vD4O5DkPUQEbaQEspBUokfJulL5VWUKdHRygJR3oQAdeAo4bfUkBYm1QLI/Gu4/nBApkWi8qSoUvAAAAAElFTkSuQmCC" alt="Requests" /></a></li>
               <li class="active"><a href="<?php echo Url::to(['passport/offer']); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAkUlEQVRIie3SQQ5AMBBGYXvcrQti4SS4LccgeRa6EIlOp50uJP61fK+ZqKp/lgN6YEdYUTwpAAwBfAJqYE4KCDhA479r1YEIHP/yBlhUARQ3f64oLgZy8WCAuJtL299wZ4EDw1tgK4YbBMJ45olk/BbplJEDGKPwhIgeV0TS8YhIPh6I2OG3iOP6hVfAmeKf2Ak/vse9vVzNfgAAAABJRU5ErkJggg==" alt="Offers" /></a></li>
               <li><a href="<?php echo Url::to(['passport/eventsedit']); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABPElEQVRIieWVPU7DQBCFXyLLbuAatEGp4ATQEPETOiQsDhDukHtAl55cATlcxbRpkoAEH82YDJYd/4QUiCdZHr3ZeTOzs6uV/jWAPmv0f1N4ABwAU5fgybjBtuLXVGOYre+2yHHu7FRSbN+r4y/alS8JCIGlVXrr+Ni4JRBmfJsOdgtg4vY6tcpjszNM6ggVHkFgWGPIV3USjFzAfc5XdEynxp2VCfaAMXAMzAqqmplvDBxu6rJIvAM812g9wwvQqdwGSYH9Q0n5gJWkbFg3kiLn+7CYtzpJsi4Cfp6ES+fzg02BYJPWpiQLJ7Tn+H3HL5pofl80q2rufCfOPnX2vHEHQAQkuUGugAfg0WyPBIiqlddDfpf0mfNFku5K4roW06iLqnuQAEe2ptdIvCShv8mjrQULEuzmOfxz+AI9fTRxjlzNIQAAAABJRU5ErkJggg==" alt="Services" /></a></li>
               <li><a href="<?php echo Url::to(['passport/cart']); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAA5UlEQVRIid3UMUpDQRCH8VkRLFWCtZ294CEM4hk8hWfwBlZCQPAGtqK9N7BMrIKtqBDzs1nwkSfxbTaK5l/PfN/M7rIRKxFMfWbwE4L3huAVO0uXZNG1+tw2mWszjvMlzNmbt0HCQ+UGx3P1OK2A3327H7bxvAB8ioNOh4jBAoLLTvAs2C+Ev2C3syBL7gsEZ6XwHsYdJ7/CRqngIgNukIqaO8C3MMEb9mp5remwHhFPEbFZDEupxZv9KiKlNImIk4gYlwr+TnCER4zQr637qnHUeIrDmrrWHfxK0M/TDXFYW/e/8wEh0HZg6tlFNwAAAABJRU5ErkJggg==" alt="Cart" /></a></li>
          </ul>
        </center>
 </section>
