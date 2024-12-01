<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PostTags $model */

$this->title = 'Create Post Tags';
$this->params['breadcrumbs'][] = ['label' => 'Post Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-tags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
