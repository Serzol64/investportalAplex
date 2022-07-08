<?php
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\Admin;

/* @var $this yii\web\View */
/* @var $content string */

if(Yii::$app->session->get('adminUser')){ $getAdminData = Admin::findOne(['login' => Yii::$app->session->get('adminUser')]); }
?>
<!DOCTYPE html>
<html lang="en">
	<?php $this->beginPage() ?>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover" />
		<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<title><?= Html::encode($this->title) ?></title>
		<?= Html::csrfMetaTags() ?>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.6.0.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js" integrity="sha512-kp7YHLxuJDJcOzStgd6vtpxr4ZU9kjn77e6dBsivSz+pUuAuMlE2UTdKB7jjsWT84qbS8kdCWHPETnP/ctrFsA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
		<script src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
		<script src="https://kit.fontawesome.com/97c3285af2.js" crossorigin="anonymous"></script>
		<?php $this->head() ?>
	</head>
	<body>
		<?php $this->beginBody() ?>
		<div class="admin-portal-page">
		  <header>
			<nav>
			  <?php if($getAdminData->role == 'admin' || $getAdminData->role == 'moderator' || $getAdminData->role == 'dev'){ ?><a href="/admin">Dashboard</a><?php } ?>
			  <?php if($getAdminData->role == 'admin' || $getAdminData->role == 'dev'){ ?><a href="/admin?dashboardSvc=news">News and Events</a><?php } ?>
			  <?php if($getAdminData->role == 'admin' || $getAdminData->role == 'moderator' || $getAdminData->role == 'dev'){ ?><a href="/admin?dashboardSvc=data">Data Services and Filters</a><?php } ?>
			  <?php if($getAdminData->role == 'moderator' || $getAdminData->role == 'dev'){ ?><a href="/admin?dashboardSvc=user">Users</a><?php } ?>
			</nav>
			<footer>
			  <ul>
				<?php if($getAdminData->role == 'admin' || $getAdminData->role == 'dev'){ ?><li onclick="isExit(false)"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABIUlEQVRIie3UPUoDURTF8ReVkM5aMJ0ktVmDdRrTx1W4AAtJ4xqsUhgCEqwEXUQalxARVEhE0gg/i7zAMGY+SKb0wCvmvjPn/5h734TwryqEJsZYxHWPdpXhH/7qE80qAOMN4WuNqgAscgDzovf3duVXAXjO2Xssf5YMoR0bmtY7jncGREgTI8zjuqss/F+Zwj7OMMATXvCFb9ykvJ1E8ztFwQ1cYpZxud5wGL1dtDBJ7E/i5HU3hR9hmnNz4Sp6ewU+6KUBDyVeOo3eYaI2Qz+u10R9mAYsSwDWn6ee8PcTGRextkQ9/ato5DZopZ+C/Vry4aBEYFonIYRpCOE2caABajH8OtYa0bOdlGvy+daACOlajWR6TFs2jekOoMyL9gutWUn2RJl12AAAAABJRU5ErkJggg=="></li><?php } ?>
				<li onclick="isExit(true)"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAn0lEQVRIid2Uuw0CMRBER4jsWqAFCoEqLnJdJ5oix9RA+ohOOp0W2PUnMBNZq5kd78eW/g7AFcjEkYGLx6Ak+YqHxwCAgspN3SGaKIqhDBYXKzoDYLbOLQ0AbsAUEUQNAO7AucrA8Q5eQNpqum/Rx1tG+U1a9IXfdch913SjW1y6CgNTN9RfZOJoxJ6STiVtkpT3AauCZBGdydNP1nB4A5tWVezafhVfAAAAAElFTkSuQmCC"></li>
			  </ul>
			</footer>
		  </header>
		  <main><?php echo $content; ?></main>
	    </div>
		<?php $this->endBody() ?>
		<script>
			function isExit(state){
				switch(state){
					case false: location.assign('/admin?svc=adminUsers&subSVC=list'); break;
					default: 
						fetch('/admin/logout').then((response) => {
							if(response.ok){ location.assign('/admin/auth'); }
							else{ alert('The portal administration accounting service is temporarily unavailable! Try again later;-('); }
						});
				    break;
				}
			}
		</script>
	</body>
	<?php $this->endPage() ?>
</html>
