<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="row">
    <!-- Main Content Section -->
    <div class="col-md-8">

        <h2 class="category-title">Posts in category: <?= Html::encode($category ? $category->name : 'Unknown Category') ?></h2>

        <?php foreach ($posts as $post): ?>
            <article class="post post-list">
                <div class="row">
                    <!-- Post Image -->
                    <div class="col-md-6">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['/view', 'id' => $post->id]) ?>">
                                <img class="img-fluid post-image" src="<?= $post->getImage() ?>" alt="<?= Html::encode($post->title) ?>">
                            </a>
                        </div>
                    </div>
                    <!-- Post Content -->
                    <div class="col-md-6">
                        <div class="post-content">
                            <header class="entry-header">
                                <h6 class="category-name"><a href="<?= Url::toRoute(['/topic', 'id' => $post->category_id]) ?>">
                                        <?= Html::encode($post->category->name); ?></a></h6>
                                <h1 class="entry-title"><a href="<?= Url::toRoute(['/view', 'id' => $post->id]) ?>">
                                        <?= Html::encode($post->title); ?></a></h1>
                            </header>

                            <!-- Post Excerpt -->
                            <div class="entry-content">
                                <p><?= Html::encode(substr($post->content, 0, 360)) . '...'; ?></p>
                            </div>

                            <!-- Post Author and Date -->
                            <div class="social-share">
                                <span class="social-share-title">
                                    By <?= Html::encode($post->user->name); ?> On <?= Html::encode($post->getDate()); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>

        <!-- Pagination -->
        <div class="pagination-container">
            <?= LinkPager::widget([
                'pagination' => $pagination,
            ]); ?>
        </div>

    </div>

    <!-- Sidebar Section (Right) -->
    <div class="col-md-4">
        <?php
        echo \Yii::$app->view->renderFile('@app/views/site/right.php', compact('popular', 'recent', 'searchModel'));
        ?>
    </div>
</div>

<!-- CSS Styles -->
<style>
    .category-title {
        font-size: 2em;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .post-list {
        margin-bottom: 40px;
        background-color: #f9f9f9;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .post-thumb {
        margin-bottom: 20px;
    }

    .post-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .entry-header h6 {
        font-size: 1.1em;
        color: #007bff;
        margin-bottom: 5px;
    }

    .entry-title {
        font-size: 1.8em;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .entry-title a {
        color: #333;
        text-decoration: none;
    }

    .entry-title a:hover {
        color: #007bff;
    }

    .entry-content p {
        font-size: 1.1em;
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .social-share {
        margin-top: 15px;
        font-size: 0.9em;
        color: #aaa;
    }

    .social-share-title {
        display: block;
    }

    .pagination-container {
        margin-top: 40px;
    }

    /* Sidebar Styling */
    .col-md-4 {
        padding-left: 30px;
        padding-right: 30px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .category-title {
            font-size: 1.5em;
        }

        .col-md-8, .col-md-4 {
            padding-left: 15px;
            padding-right: 15px;
        }

        .post-list {
            padding: 15px;
        }

        .post-content {
            padding-left: 0;
        }
    }
</style>
