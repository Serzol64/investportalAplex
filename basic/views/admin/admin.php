<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

use app\models\Admin;

$this->title = 'Admin Services portal';
?>
<?php if(isset($_GET['svc'])){ ?>
	<?php if($_GET['svc'] == "dataManagment"){ ?>
		<?php
		 if($_GET['subSVC']){
			 switch($_GET['subSVC']){
				 case "filters": echo "<section class=\"data-page\"><header><h2></h2><nav></nav></header><main></main></section>"; break;
				 case "news": echo "<section class=\"data-page cms-service\"><header><h2></h2><nav></nav></header><main></main></section>"; break;
				 case "events": echo "<section class=\"data-page cms-service\"><header><h2></h2><nav></nav></header><main></main></section>"; break;
				 case "analytics": echo "<section class=\"data-page cms-service\"><header><h2></h2><nav></nav></header><main></main></section>"; break;
				 case "portalServices": echo "<section class=\"data-page\"><header><h2></h2><nav></nav></header><main></main></section>"; break;
				 default: echo "<section class=\"data-page\"><header><h2></h2><nav></nav></header><main></main></section>"; break;
			 }
		 }
		?>
	<?php } else if($_GET['svc'] == "adminUsers"){ ?>
		<?php
		 if($_GET['subSVC']){
			 switch($_GET['subSVC']){
				 case "add": 
				  echo "<section class=\"data-page\"><header><h2>Add new user</h2><nav></nav></header><main id=\"cms-service\"></main></section>"; 
				 break;
				 case "delete": 
				  echo "<section class=\"data-page\"><header><h2>Delete Admin User</h2><nav></nav></header><main id=\"cms-service\"></main></section>"; 
				 break;
				 case "edit": 
				  echo "<section class=\"data-page\"><header><h2>Edit Admin User</h2><nav></nav></header><main id=\"cms-service\"></main></section>"; break;
				 case "list": 
				  $usersList = GridView::widget([
						'dataProvider' => new ActiveDataProvider([
							'query' => Admin::find(),
							'pagination' => [
								'pageSize' => 9
							]
						]),
						'columns' => [
							[ 'class' => \yii\grid\SerialColumn::class ],
							'firstname',
							'surname',
							'login',
							[
								'attribute' => 'role',
								'value' => function ($model){
									switch($model->role){
										case 'moderator': $r = 'Portal moderator'; break;
										case 'dev': $r = 'Developer'; break;
										default: $r = 'Portal administrator'; break;
									}
									return $r;
								}
							],
							[
								'attribute' => 'country',
								'value' => function ($model){
									$rdf = Yii::$app->regionDB->getFullDataFrame();
									for($i = 0; $i < count($rdf); $i++){
										if($model->country == $rdf[$i]['code']){
											$rg = $rdf[$i]['title'];
										}
									}
									return $rg;
								}
							]
						],
						'tableOptions' => [
							'class' => 'admin-list-table'
						]
				  ]);
				  echo "<section class=\"data-page\"><header><h2>Admin Portal Users</h2><nav></nav></header><main>". $usersList ."</main></section>"; 
				 break;
			 }
		 } }
		?>
<?php } else{?>
	<section class="admin-dashboard">
	  <h1>Dashboard</h1>
	  <header>
		<div id="board-tabs">
		  <section class="active"><span>Basic</span></section>
		  <section><span>Data</span></section>
		  <section><span>Content</span></section>
		</div>
	  </header>
	  <main>
		<ul>
		  <li class="active"></li>
		  <li></li>
		  <li></li>
		</ul>
	  </main>
	</section>
<?php } ?>
<script type="text/babel" src="/js/react/admin/<?php echo $pgUI; ?>.js"></script>
