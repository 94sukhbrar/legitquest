<?php

use yii\helpers\Html;
use app\components\TActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Courts */
/* @var $form yii\widgets\ActiveForm */
?>
<header class="panel-heading">
	<?php echo strtoupper(Yii::$app->controller->action->id); ?>
</header>
<div class="panel-body">

	<?php
	$form = TActiveForm::begin([
		'layout' => 'horizontal',
		'id'	=> 'courts-form',
	]);


	echo $form->errorSummary($model);
	?>


<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6"></div>
</div>

	<?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

	<?php echo $form->field($model, 'code')->textInput(['maxlength' => 255]) ?> 


	<?php echo $form->field($model, 'state_name')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>



	<?php echo $form->field($model, 'state_cd')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>



	<?php echo $form->field($model, 'dist_cd')->textInput(['maxlength' => 255]) ?>



	<?php echo $form->field($model, 'court_code')->textInput(['maxlength' => 255]) ?>



	<div class="form-group">
		<div class="col-md-6 col-md-offset-3 bottom-admin-button btn-space-bottom text-right">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'courts-form-submit', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	</div>

	<?php TActiveForm::end(); ?>

</div>