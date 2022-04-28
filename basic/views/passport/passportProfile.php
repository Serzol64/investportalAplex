<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Passport";
?>
<main class="main" style="background-color:   #eff3f4;">
	<section class="section" id="link-switcher">
            <a href="<?php echo Url::to(['site/index']); ?>">Main</a> <span id="delimeter"> / </span> <a href="<?php echo Url::to(['passport/service']); ?>" class="active">Passport</a>
	</section>
	<section class="section" id="passport">
		<div class="passport-page">
					<header>
						<div id="left-content">
							<span>Passport</span>
						</div>
						<div id="right-content">
							<a href="">Exit</a>
							<nav>
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAy0lEQVRIieWUMQ7CMBAE9xAleQL/oIegwKsoeSYJvADRD00QJjjxOQpCgu1srW/svZOlnxFQAWec8ta1ANBIWroPmlna9fqCrJt5NZu6oBsA7IGLsyWHJKkbUU7DXZAIINmTCOT4acAbJBxTpOf4ddd9gNh+eGY+dMOhIl59b0wnB1irhL+WtJG0kFRKakaTeyZk3fGUMVPoyZ2QwsxugaeQdO2awiRye7BKrP3qiejUxrIAtkCdimgIkPsXPeRrPLAbAWmAanRs/6k7RAnoeBvtDckAAAAASUVORK5CYII=" id="save" alt="Save the changes" />
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAn0lEQVRIid2Uuw0CMRBER4jsWqAFCoEqLnJdJ5oix9RA+ohOOp0W2PUnMBNZq5kd78eW/g7AFcjEkYGLx6Ak+YqHxwCAgspN3SGaKIqhDBYXKzoDYLbOLQ0AbsAUEUQNAO7AucrA8Q5eQNpqum/Rx1tG+U1a9IXfdch913SjW1y6CgNTN9RfZOJoxJ6STiVtkpT3AauCZBGdydNP1nB4A5tWVezafhVfAAAAAElFTkSuQmCC" id="exit" alt="Exit" />
							</nav>
						</div>
					</header>
					<main>
                    <div id="left-content">
                        <div class="settings-form">
                            <div class="form-wrapper">
                              <span>Login</span>
                              <input type="text" disabled="true" class="input" value="<?php echo $ud_data['login']; ?>">
                              <button><i class="far fa-edit"></i></button>
                            </div>
                            <div class="form-wrapper-special">
                              <span>E-Mail</span>
                              <input type="email" disabled="true" class="input" value="<?php echo $ud_data['email']; ?>">
                              <button><i class="far fa-edit"></i></button>
                            </div>
                            <div class="form-wrapper-special">
                              <span>New password</span>
                              <input type="password" class="input">
                            </div>
                            <div class="form-wrapper">
                              <span>First name</span>
                              <input type="text" disabled="true" class="input" value="<?php echo $ud_data['firstname']; ?>">
                              <button><i class="far fa-edit"></i></button>
                            </div>
                            <div class="form-wrapper">
                              <span>Second name</span>
                              <input type="text" disabled="true" class="input" value="<?php echo $ud_data['surname']; ?>">
                              <button><i class="far fa-edit"></i></button>
                            </div>
                            <div class="form-wrapper">
                              <span>Fone</span>
                              <input type="phone" disabled="true" class="input" value="<?php echo $ud_data['phone']; ?>">
                              <button><i class="far fa-edit"></i></button>
                            </div>
                          </div>    
                    </div>
                    <div id="right-content">
                       <ul class="nav">
                           <li class="active"><i class="fas fa-circle active-link"></i><a href="/passport/profile">Passport</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport">My investment requests</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/offers">My offers for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/services">My services for investors</a></li>
                           <li><i class="fas fa-circle active-link"></i><a href="/passport/cart">My shopping Cart</a></li>
                       </ul>
                    </div>
					</main>
					<footer>
						<div id="left-content" style="position:relative;left: -57vw;top: 428px;">
							<button class="add-but">Add Request</button>
						</div>
					</footer>
			</div>
	</section>
</main>
