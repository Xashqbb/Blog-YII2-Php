<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit Profile';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($user, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
<?= $form->field($user, 'password')->passwordInput(['maxlength' => true])->hint('Leave blank if not changing.') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
