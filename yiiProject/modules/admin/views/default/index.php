<div class="admin-default-index">
    <h1>Welcome to the Admin Page</h1>
    <p class="welcome-message">Only accessible by admin@gmail.com</p>

    <ul class="admin-menu">
        <li><a href="<?= \yii\helpers\Url::to(['users/index']) ?>">Manage Users</a></li>
        <li><a href="<?= \yii\helpers\Url::to(['tags/index']) ?>">Manage Tags</a></li>
        <li><a href="<?= \yii\helpers\Url::to(['categories/index']) ?>">Manage Categories</a></li>
        <li><a href="<?= \yii\helpers\Url::to(['posts/index']) ?>">Manage Posts</a></li>
        <li><a href="<?= \yii\helpers\Url::to(['post-tags/index']) ?>">Manage Post-tags</a></li>
        <li><a href="<?= \yii\helpers\Url::to(['comments/index']) ?>">Manage Comments</a></li>
    </ul>
</div>

<style>
    /* Основний стиль для контейнера */
    .admin-default-index {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 60%;
        margin: 0 auto;
        font-family: 'Arial', sans-serif;
    }

    /* Заголовок */
    .admin-default-index h1 {
        text-align: center;
        font-size: 2em;
        color: #343a40;
        margin-bottom: 10px;
    }

    /* Повідомлення */
    .welcome-message {
        text-align: center;
        font-size: 1.1em;
        color: #6c757d;
        margin-bottom: 20px;
    }

    /* Список меню */
    .admin-menu {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .admin-menu li {
        background-color: #007bff;
        border-radius: 5px;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }

    .admin-menu li a {
        display: block;
        padding: 15px;
        color: white;
        text-decoration: none;
        font-size: 1.2em;
        text-align: center;
        border-radius: 5px;
    }

    .admin-menu li:hover {
        background-color: #0056b3;
    }

    .admin-menu li a:hover {
        color: #f8f9fa;
    }

    /* Мобільна версія */
    @media (max-width: 768px) {
        .admin-default-index {
            width: 90%;
        }

        .admin-menu li a {
            font-size: 1em;
        }
    }
</style>
