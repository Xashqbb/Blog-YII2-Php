<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $categories app\models\Categories[] */
/* @var $tags app\models\Tags[] */

$this->title = 'Edit Post';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="post-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'category_id')->dropdownList($categories, ['prompt' => 'Select Category']) ?>
    <?= $form->field($model, 'tags')->checkboxList(\yii\helpers\ArrayHelper::map($tags, 'id', 'name')) ?> <!-- Tags selection -->

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
