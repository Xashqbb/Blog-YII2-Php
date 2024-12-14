<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $categories app\models\Categories[] */
/* @var $tags app\models\Tags[] */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-create-post">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'create-post-form',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'category_id')->dropdownList($categories, ['prompt' => 'Select Category']) ?>
    <?= $form->field($model, 'tags')->checkboxList(ArrayHelper::map($tags, 'id', 'name')) ?> <!-- Tags selection -->

    <?= $form->field($imageUploadModel, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Create Post', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
