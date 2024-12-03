<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $popularPosts app\models\Posts[] */

$this->title = 'Результати пошуку';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="content-wrapper">
    <div class="row">
        <!-- Основний контент -->
        <div class="col-md-8">
            <div class="search-results">
                <h2>Результати пошуку за запитом: <?= Html::encode($searchModel->title) ?></h2>
                <div class="content-area">
                    <?php foreach ($dataProvider->models as $post): ?>
                        <div class="post">
                            <h2>
                                <a href="<?= Url::to(['site/view', 'id' => $post->id]) ?>">
                                    <?= Html::encode($post->title) ?>
                                </a>
                            </h2>

                            <!-- Виведення зображення поста, якщо воно є -->
                            <?php if ($post->image): ?>
                                <div class="post-image">
                                    <img src="<?= $post->getImage() ?>" alt="<?= Html::encode($post->title) ?>" />
                                </div>
                            <?php endif; ?>

                            <p><?= \yii\helpers\StringHelper::truncate($post->content, 150) ?></p>
                            <p><a href="<?= Url::to(['site/view', 'id' => $post->id]) ?>">Read more...</a></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                ]); ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="primary-sidebar">
                <aside class="widget">
                    <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
                    <?= $this->render('right', ['popularPosts' => $popularPosts, 'searchModel' => $searchModel]); ?>
                </aside>
            </div>
        </div>
    </div>
</div>
