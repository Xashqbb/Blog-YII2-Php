<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="post-item">
    <h2>
        <a href="<?= Url::to(['site/view', 'id' => $post->id]) ?>">
            <?= Html::encode($post->title) ?>
        </a>
    </h2>

    <!-- Виведення зображення поста -->
    <?php if ($post->image): ?>
        <div class="post-image">
            <img src="<?= $post->getImage() ?>" alt="<?= Html::encode($post->title) ?>" />
        </div>
    <?php endif; ?>

    <!-- Виведення категорії -->
    <div class="post-category">
        <strong>Категорія:</strong>
        <?php if (isset($post->category)): ?>
            <a href="<?= Url::to(['category/view', 'id' => $post->category->id]) ?>">
                <?= Html::encode($post->category->name) ?>
            </a>
        <?php else: ?>
            <span>Без категорії</span>
        <?php endif; ?>
    </div>

    <!-- Виведення тегів -->
    <div class="post-tags">
        <strong>Теги:</strong>
        <?php if (!empty($post->tags)): ?>
            <ul class="tag-list">
                <?php foreach ($post->tags as $tag): ?>
                    <li>
                        <a href="<?= Url::to(['tag/view', 'id' => $tag->id]) ?>" class="tag">
                            <?= Html::encode($tag->name) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <span>Без тегів</span>
        <?php endif; ?>
    </div>

    <!-- Виведення контенту поста -->
    <div class="post-content">
        <?= Html::encode($post->content) ?>
    </div>

    <!-- Дата публікації -->
    <div class="post-date">
        <strong>Опубліковано:</strong> <?= Html::encode($post->getDate()) ?>
    </div>
</div>
