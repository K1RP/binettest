<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin()?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'refUser')->hiddenInput() ?>
<div class="form-group">
	<div>
		<?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
	</div>
</div>
<?php ActiveForm::end() ?>