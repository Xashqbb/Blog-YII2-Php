<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="row">
    <div class="col-md-8">
        <div class="content-area">
            <?php if (!empty($dataProvider->models)): ?>
                <?php foreach ($dataProvider->models as $post): ?>
                    <div class="post">
                        <h2>
                            <a href="<?= Url::to(['site/view', 'id' => $post->id]) ?>">
                                <?= \yii\helpers\Html::encode($post->title) ?>
                            </a>
                        </h2>

                        <?php if ($post->image): ?>
                            <img src="<?= Yii::getAlias('@web' . $post->image) ?>"
                                 alt="<?= \yii\helpers\Html::encode($post->title) ?>" class="img-fluid">
                        <?php endif; ?>

                        <p><?= \yii\helpers\StringHelper::truncate($post->content, 150) ?></p>
                        <p><a href="<?= Url::to(['site/view', 'id' => $post->id]) ?>">Read more...</a></p>
                    </div>
                <?php endforeach; ?>

                <!-- Pagination -->
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                ]); ?>
            <?php else: ?>
                <p>Немає постів, які відповідають запиту.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="primary-sidebar">
            <aside class="widget">
                <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
                <?= $this->render('right', ['popularPosts' => $popularPosts, 'searchModel' => $searchModel]); ?>
            </aside>
        </div>
    </div>
</div>
