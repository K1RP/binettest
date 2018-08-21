<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
	<p><strong>Ваша реферальная ссылка:</strong> <a href="/index.php?r=site%2Fsignup&referrer=<?=Yii::$app->user->id?>">/index.php?r=site%2Fsignup&referrer=<?=Yii::$app->user->id?></a></p>
	<?php if($refUser!=null):?>
		<p><strong>Вы пришли от:</strong> <?=$refUser->username?></p>
	<?php endif;?>
	<?php if($users!=null):?>
		<p><strong>От вас пришли:</strong></p>
		<ol>
		<?php foreach ($users as $user): ?>
			<li>
				<?=$user->username?>
			</li>
		<?php endforeach; ?>
		</ol>
	<?php endif;?>
	
	<?= LinkPager::widget(['pagination' => $pagination]) ?>

</div>
