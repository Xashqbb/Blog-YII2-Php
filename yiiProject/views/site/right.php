<?php
use yii\helpers\Html;
use yii\helpers\Url;
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

    <!-- Інші віджети -->
    <div class="widget">
        <h3 class="widget-title">Пошук</h3>
        <form action="#" method="get">
            <input type="text" name="search" placeholder="Шукати...">
            <button type="submit">Пошук</button>
        </form>
    </div>

    <div class="widget">
        <h3 class="widget-title">Категорії</h3>
        <ul>
            <li><a href="#">Категорія 1</a></li>
            <li><a href="#">Категорія 2</a></li>
            <li><a href="#">Категорія 3</a></li>
            <li><a href="#">Категорія 4</a></li>
        </ul>
    </div>
</aside>
