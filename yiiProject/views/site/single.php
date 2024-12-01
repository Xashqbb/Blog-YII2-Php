<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $post->title;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-single">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Display post image -->
    <?php if ($post->image): ?>
        <div class="post-image">
            <img src="<?= $post->getImage() ?>" alt="<?= Html::encode($post->title) ?>" />
        </div>
    <?php endif; ?>

    <p><?= Html::encode($post->content) ?></p>

    <div class="comments-section">
        <h3>Comments</h3>

        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><strong><?= Html::encode($comment->author) ?>:</strong> <?= Html::encode($comment->content) ?></p>
            </div>
        <?php endforeach; ?>

        <!-- Pagination for comments -->
        <div class="pagination">
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pagination,
            ]) ?>
        </div>

        <!-- Comment form -->
        <div class="leave-comment">
            <h4>Leave a Reply</h4>
            <form method="post" action="<?= Url::to(['site/comment', 'postId' => $post->id]) ?>">
                <div class="form-group">
                    <input type="text" name="author" class="form-control" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="5" placeholder="Your comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        </div>
    </div>
</div>
