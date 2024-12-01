<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="col-md-8">

    <h2>Posts in category: <?= Html::encode($category ? $category->name : 'Unknown Category') ?></h2>

    <?php foreach ($posts as $post): ?>
        <article class="post post-list">
            <div class="row">
                <div class="col-md-6">
                    <div class="post-thumb">
                        <a href="<?= Url::toRoute(['/view', 'id' => $post->id]) ?>">
                            <img class="img-topic" src="<?= $post->getImage() ?>" alt="" class="pull-left">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="post-content">
                        <header class="entry-header text-uppercase">
                            <h6><a href="<?= Url::toRoute(['/topic', 'id' => $post->category_id]) ?>">
                                    <?= Html::encode($post->category->name); ?></a></h6>
                            <h1 class="entry-title"><a href="<?= Url::toRoute(['/view', 'id' => $post->id]) ?>">
                                    <?= Html::encode($post->title); ?></a></h1>
                        </header>
                        <div class="entry-content">
                            <p><?= Html::encode(substr($post->content, 0, 360)) . '...'; ?></p>
                        </div>
                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">By <?= Html::encode($post->user->name); ?> On <?= Html::encode($post->getDate()); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>

    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]); ?>

</div>


<?php
echo \Yii::$app->view->renderFile('@app/views/site/right.php', compact('popular', 'recent'));
?>