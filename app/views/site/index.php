<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php foreach ($modules as $route => $module): ?>
                <div class="col-lg-4">
                    <h2><?= $module['name'] ?></h2>

                    <p><?= $module['comment'] ?></p>

                    <p><?= Html::a('Start &raquo', ['/' . $route], ['class' => 'btn btn-default']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
