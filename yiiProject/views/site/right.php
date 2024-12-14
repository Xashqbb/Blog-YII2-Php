<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<aside class="primary-sidebar">
    <div class="widget">
        <h3 class="widget-title">Популярні пости</h3>
        <?php if (!empty($popularPosts)): ?>
            <ul>
                <?php foreach ($popularPosts as $post): ?>
                    <li>
                        <a href="<?= \yii\helpers\Url::to(['site/view', 'id' => $post->id]) ?>">
                            <?= \yii\helpers\Html::encode($post->title) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No popular posts available.</p>
        <?php endif; ?>
    </div>

    <!-- Віджет пошуку постів -->
    <div class="widget">
        <h3 class="widget-title">Пошук постів</h3>
        <?php $form = ActiveForm::begin([
            'action' => ['site/search'],
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'title')->textInput(['placeholder' => 'Enter post title']) ?>

        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('Шукати', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>


    <div class="widget">
        <h3 class="widget-title">Категорії</h3>
        <ul>
            <?php
            $categories = \app\models\Categories::find()->all();
            if (!empty($categories)):
                foreach ($categories as $category): ?>
                    <li><a href="<?= Url::to(['site/topic', 'id' => $category->id]) ?>">
                        <?= Html::encode($category->name) ?>
                        </a></li>
                <?php endforeach;
            else: ?>
                <li>Категорії не знайдено</li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
