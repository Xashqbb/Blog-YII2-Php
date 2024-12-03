<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Profile';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Name:</strong> <?= Html::encode($user->name) ?></p>
<p><strong>Email:</strong> <?= Html::encode($user->email) ?></p>

<p>
    <?= Html::a('Edit Profile', ['edit-profile'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="user-posts">
    <h3>Your Posts</h3>
    <?php foreach ($posts as $post): ?>
        <div>
            <h4><?= Html::encode($post->title) ?></h4>
            <?php if (!empty($post->image)): ?>
                <div>
                    <?= Html::img($post->image, ['alt' => 'Post image', 'style' => 'max-width:200px;']) ?>
                </div>
            <?php endif; ?>
            <p><?= Html::encode($post->content) ?></p>
            <?= Html::a('Edit', ['site/edit-post', 'id' => $post->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Delete', ['site/delete-post', 'id' => $post->id], [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Are you sure you want to delete this post?',
                'data-method' => 'post',
            ]) ?>
        </div>
        <hr>
    <?php endforeach; ?>
</div>

