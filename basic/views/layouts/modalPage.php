<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $content string */

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover" />
		<?= Html::csrfMetaTags() ?>
	</head>
	<?php $this->beginBody() ?><body><?php echo $content; ?></body><?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
