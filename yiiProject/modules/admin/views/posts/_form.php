<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category; // Для категорій
use app\models\User; // Для користувачів

/** @var yii\web\View $this */
/** @var app\models\Posts $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <!-- Вибір категорії з випадаючого списку -->
    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(\app\models\Categories::find()->all(), 'id', 'name'), // Пропонуємо категорії
        ['prompt' => 'Select Category'] // Підказка в випадаючому списку
    ) ?>

    <!-- Вибір користувача з випадаючого списку -->
    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(\app\models\Users::find()->all(), 'id', 'name'), // Пропонуємо користувачів
        ['prompt' => 'Select User'] // Підказка в випадаючому списку
    ) ?>

    <!-- Відображення поточного зображення -->
    <?php if ($model->image): ?>
        <div>
            <p>Current Image:</p>
            <?= Html::img(Yii::getAlias('@web') . $model->image, ['width' => '150px']); ?>
        </div>
    <?php endif; ?>

    <!-- Поле для завантаження нового зображення -->
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
