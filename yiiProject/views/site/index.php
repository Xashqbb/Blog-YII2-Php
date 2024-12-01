<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">

                <article class="post">

                    <div class="post-thumb">
                        <a href="#"><img class="img-index" src="https://via.placeholder.com/800x400" alt="Image"></a>
                    </div>

                    <div class="post-content">

                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="#">Travel</a></h6>
                            <h1 class="entry-title"><a href="#">Home is a peaceful place</a></h1>
                        </header>

                        <div class="entry-content">
                            <p>
                                This is an example post. Customize it according to your needs. Add engaging content and make it unique.
                            </p>
                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="#" class="more-link">Continue Reading</a>
                            </div>
                        </div>

                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">By Admin On 01-12-2024</span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li>
                                <li>10</li>
                            </ul>
                        </div>

                    </div>

                </article>

                <ul class="pagination">
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                </ul>

            </div>

            <!-- Підключення сайдбара -->
            <?php
            echo \Yii::$app->view->renderFile('@app/views/site/right.php');
            ?>
        </div>
    </div>
</div>
